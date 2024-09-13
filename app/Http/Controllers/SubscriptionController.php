<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SubscriptionController extends Controller
{
    public function showSubscribePage(User $creator)
    {
        return view('subscriptions.subscribe', compact('creator'));
    }

    public function subscribe(User $creator)
    {
        $subscriber = Auth::user();
        if (!$subscriber->subscriptions->contains($creator)) {
            $subscriber->subscriptions()->attach($creator);
        }

        return redirect()->route('profile.show', $creator->id)->with('status', 'Subscribed successfully!');
    }

    public function showUnsubscribePage(User $creator)
    {
        return view('subscriptions.unsubscribe', compact('creator'));
    }

    public function unsubscribe(User $creator)
    {
        $subscriber = Auth::user();
        if ($subscriber->subscriptions->contains($creator)) {
            $subscriber->subscriptions()->detach($creator);
        }

        return redirect()->route('profile.show', $creator->id)->with('status', 'Unsubscribed successfully!');
    }
}

