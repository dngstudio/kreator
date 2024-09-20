<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Check if user is a creator
        if ($user->isA('creator')) {
            // Fetch the creator's own posts (limit to 5)
            $posts = Post::where('user_id', $user->id)->latest()->take(5)->get();
            
            // Fetch the creator's subscribers
            $subscribers = $user->subscribers; // Assuming a `subscribers` relation exists

            $totalViews = $user->posts()->sum('views');

            return view('dashboard', compact('posts', 'subscribers', 'totalViews'));
        } else {
            // Fetch posts from creators the user is subscribed to (limit to 5)
            $subscriptions = $user->subscriptions;
            $posts = Post::whereIn('user_id', $subscriptions->pluck('id'))->latest()->take(5)->get();

            return view('dashboard', compact('posts'));
        }
    }
}
