<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // Ensure only admin or creator can access the posts page
        if (!Auth::user()->isAn('admin') && !Auth::user()->isA('creator')) {
            return redirect()->route('dashboard')->with('error', 'Nemate dozvolu da upravljate postovima.');
        }

        $query = Post::query();

        // If the user is not an admin, only show their posts
        if (Auth::user()->isA('creator') && !Auth::user()->isAn('admin')) {
            $query->where('user_id', Auth::id());
        }

        // Admin filtering by user
        if (Auth::user()->isAn('admin') && $request->input('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        // Sorting logic
        switch ($request->input('sort')) {
            case 'oldest':
                $query->oldest();
                break;
            case 'views':
                $query->orderBy('views', 'desc');
                break;
            default:
                $query->latest();  // Default to 'latest'
        }

        // Get the filtered/sorted posts
        $posts = $query->get();

        // If admin, get list of users for filtering
        $users = Auth::user()->isAn('admin') 
        ? User::whereHas('roles', function($query) {
            $query->whereIn('name', ['admin', 'creator']);
        })->get() 
        : [];

        return view('posts.index', compact('posts', 'users'));
    }



    public function create()
    {
        // Ensure only admin or creator can access the create post page
        if (Auth::user()->isAn('admin') || Auth::user()->isA('creator')) {
            return view('posts.create');
        }

        return redirect()->route('dashboard')->with('error', 'You do not have permission to create posts.');
    }

    public function store(Request $request): RedirectResponse
    {
        // Ensure only admin or creator can store a new post
        if (!(Auth::user()->isAn('admin') || Auth::user()->isA('creator'))) {
            return redirect()->route('posts.index')->with('error', 'You do not have permission to create posts.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = new Post();
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->user_id = Auth::id();

        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('featured_images', 'public');
            $post->featured_image = basename($imagePath);
        }

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        $user = Auth::user();

        // Check if the user is an admin or the creator of the post
        if ($user->isAn('admin') || $user->id === $post->user_id) {
            return view('posts.edit', compact('post'));
        }

        // Redirect to dashboard with an error if unauthorized
        return redirect()->route('dashboard')->with('error', 'You do not have permission to edit this post.');
    }


    public function update(Request $request, Post $post)
    {
        $user = Auth::user();

        // Check if the user is an admin or the creator of the post
        if ($user->isAn('admin') || $user->id === $post->user_id) {

            // Validate input
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'featured_image' => 'nullable|image|max:2048',
            ]);

            // Update post with validated data
            $post->title = $validatedData['title'];
            $post->description = $validatedData['description'];

            // Handle featured image upload if it exists
            if ($request->hasFile('featured_image')) {
                $imagePath = $request->file('featured_image')->store('featured_images', 'public');
                $post->featured_image = basename($imagePath);
            }

            // Save the post
            $post->save();

            return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
        }

        // Redirect to dashboard with an error if unauthorized
        return redirect()->route('dashboard')->with('error', 'You do not have permission to update this post.');
    }


    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

    public function show(Post $post)
    {
        $user = Auth::user();
        $creator = $post->user;

        // Increment views count only if the user is not the creator
        if (!$user->is($creator)) {
            $post->increment('views');
        }

        // Allow the creator, admin, or a subscribed user to view the post
        if ($user->is($creator) || $user->isAn('admin') || ($user->isAn('subscriber') && $user->subscriptions->contains($creator))) {
            return view('posts.show', compact('post'));
        }

        return redirect()->route('profile.show', $creator->id)->with('status', 'You need to subscribe to view this post.');
    }



}
