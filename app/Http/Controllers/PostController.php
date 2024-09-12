<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        // Allow only admins and creators to access these methods
        $this->middleware(['auth', 'role:admin|creator']);
    }

    public function index()
    {
        // Fetch posts created by the authenticated user
        $posts = Auth::user()->posts;

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    // Store a newly created post
    public function store(PostRequest $request)
    {
        $post = new Post();
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->featured_image = $request->file('featured_image')->store('images'); // Store the image
        $post->user_id = Auth::id(); // Associate the post with the logged-in user
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    // Add more methods like edit, update, and destroy as needed
}
