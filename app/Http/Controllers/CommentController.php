<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $user = Auth::user();

        // Check if the user is a creator and if they own the post
        if ($user->isA('creator') && $post->user_id !== $user->id) {
            return response()->json(['error' => 'Nemaš dozvolu da komentarišeš ovaj post'], 403);
        }

        // Check if the user is a subscriber and if they are subscribed to the creator
        if ($user->isA('subscriber')) {
            $isSubscribed = \DB::table('subscriptions')
                ->where('subscriber_id', $user->id)
                ->where('creator_id', $post->user_id)
                ->exists();

            if (!$isSubscribed) {
                return response()->json(['error' => 'Nemaš dozvolu da komentarišeš ovaj post'], 403);
            }
        }

        // Validate the comment body
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        // Create the comment
        $comment = $post->comments()->create([
            'user_id' => $user->id,
            'body' => $request->body,
        ]);

        // Return success response with the new comment
        return response()->json([
            'message' => 'Komentar dodat!',
            'comment' => $comment->load('user')
        ]);

    }

    public function destroy(Post $post, $commentId)
{
    $user = Auth::user();
    $comment = $post->comments()->findOrFail($commentId);

    // Allow the admin or the comment author to delete the comment
    if ($user->isAn('admin') || $comment->user_id === $user->id) {
        $comment->delete();
        return response()->json(['message' => 'Komentar obrisan!']);
    }

    return response()->json(['error' => 'Nemaš dozvolu da obrišeš komentar'], 403);
}




}
