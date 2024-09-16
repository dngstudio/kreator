<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('user_id', Auth::id())->get();
        // Ensure only admin or creator can access the posts page
        if (Auth::user()->isAn('admin') || Auth::user()->isA('creator')) {
            return view('posts.index', compact('posts'));
        }

        return redirect()->route('dashboard')->with('error', 'You do not have permission to manage posts.');

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
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post->title = $request->input('title');
        $post->description = $request->input('description');

        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('featured_images', 'public');
            $post->featured_image = basename($imagePath);
        }

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
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

        if ($user->isAn('subscriber') && $user->subscriptions->contains($creator)) {
            return view('posts.show', compact('post'));
        }

        return redirect()->route('profile.show', $creator->id)->with('status', 'You need to subscribe to view this post.');
    }
}
