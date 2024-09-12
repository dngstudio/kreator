<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Admin can edit any user's profile form.
     */
    public function editUser($id): View
    {
        // Fetch the user by ID
        $user = User::findOrFail($id);

        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request, $id = null): RedirectResponse
    {
        // Check if admin is editing another user's profile
        if ($id && Auth::user()->isAdmin()) {
            $user = User::findOrFail($id);
        } else {
            $user = $request->user();
        }

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit', ['id' => $user->id])->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function allaccounts()
    {
        $accounts = \App\Models\User::with('roles')->get(); // Eager load roles

        // Pass the accounts data to the view
        return view('all-accounts', ['accounts' => $accounts]);
    }

    public function create()
    {
        // Show the form to create a new user
        return view('users.create'); // Make sure to create this view file
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string'
        ]);

        // Create a new user
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Assign the selected role to the new user
        $user->assign($request->role);

        // Redirect back to all accounts page with success message
        return redirect()->route('all-accounts')->with('success', 'New user created successfully.');
    }

}
