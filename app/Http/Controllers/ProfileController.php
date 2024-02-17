<?php

namespace App\Http\Controllers;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Models\Favorites;
class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }
    public function hasRole(Request $request,)
    {
        $user = $request->user();
        return $user -> role;
    }
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return Redirect::back()->withErrors(['updatePassword' => 'The current password is incorrect.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'password-updated');
    }
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
    public function favorites()
    {
        $user = Auth::user();
        $favorites = Favorites::where('user_id', $user->id)->get();

        return view('profile.favorites', compact('favorites'));
    }

    public function removeFromFavoritesView($favoriteId)
    {
        $favorite = Favorites::findOrFail($favoriteId);
        $favorite->delete();

        return redirect()->route('profile.favorites')->with('success', 'Товар удален из избранного.');
    }
}
