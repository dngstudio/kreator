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
    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();

        // Check if the profile image should be removed
        if ($request->has('remove_profile_image') && $request->input('remove_profile_image') == '1') {
            if ($user->profile_image) {
                // Delete the image from storage
                \Storage::delete('public/' . $user->profile_image);

                // Set the profile image column to null in the database
                $user->profile_image = null;
            }
        }

        // Handle the file upload if a new image was uploaded
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $path = $file->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        // Save other user details
        $user->fill($request->validated());
        
        // If email is changed, reset email verification
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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

    public function showProfile($id)
    {
        $user = \App\Models\User::findOrFail($id);

        $posts = $user->posts()->get(); // Assuming the posts relationship is defined on the User model
        return view('profile.show', compact('user', 'posts'));

    }

    public function allCreators()
    {
        // Fetch all users with the role 'creator'
        $creators = User::whereHas('roles', function($query) {
            $query->where('name', 'creator');
        })->get();

        return view('creators.index', compact('creators'));
    }

}
