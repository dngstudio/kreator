<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get subscriptions of the logged-in user
        $subscriptions = $user->subscriptions;

        // Fetch posts from subscribed creators
        $posts = Post::whereIn('user_id', $subscriptions->pluck('id'))->latest()->get();

        return view('dashboard', compact('posts'));
    }
}

