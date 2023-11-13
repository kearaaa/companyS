<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Str;

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
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse //pelajari
    {
        $user = Auth::user();

        // Menghapus avatar sebelumnya jika ada
        if ($request->hasFile('avatar') && $user->avatar) {
            // Hapus avatar sebelumnya
            $previousAvatarPath = storage_path("app/public/avatars/{$user->id}/{$user->avatar}");
            if (file_exists($previousAvatarPath)) {
                unlink($previousAvatarPath);
            }
        }

        $request->user()->fill($request->validated()); //pelajari

            if ($request->user()->isDirty('email')) { //pelajari
                $request->user()->email_verified_at = null;
            }

        if ($request->hasFile('avatar')) {
            $avatarFile = $request->file('avatar');
            $hashedFileName = Str::random(40) . '.' . $avatarFile->getClientOriginalExtension();

            // Simpan file avatar yang di-hash
            Storage::putFileAs('public/avatars/' . $user->id, $avatarFile, $hashedFileName);

            $user->avatar = $hashedFileName;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated'); //pelajari
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]); //pelajari

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
