<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
        $this->middleware('verified');
        $this->middleware('auth');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user)
    {
        return view("profile.edit", compact('user'));
    }

    /**
     * @param Request $request
     * @param User $user
     * @return RedirectResponse|Redirector
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name,' . $user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'avatar' => ['mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $oldAvatarImage = $user->profile->image;

        $user->name = trim($request->name);
        $user->slug = trim($request->slug);
        $user->email = trim($request->email);

        if (! empty($request->password)) {
            $user->password = Hash::make(trim($request->password));
        }

        $user->save();

        $user->profile->first_name = trim($request->first_name);
        $user->profile->last_name = trim($request->last_name);
        $user->profile->birthday = $request->birthday;

        if ($request->hasFile('avatar')) {
            $avatarName = $user->id.'_avatar'.time().'.'.request()->avatar->getClientOriginalExtension();
            $request->avatar->storeAs('public/avatars', $avatarName);
            $user->profile->image = $avatarName;
        }

        $user->profile->bio = $request->bio;
        $user->profile->save();

        if ($oldAvatarImage !== $user->profile->image) {
            if($oldAvatarImage !== 'default_avatar.png') {
                $this->removeAvatarImage($oldAvatarImage);
            }
        }

        $user->detachRoles();
        $user->attachRole($request->role);

        return redirect("/profile/" . $user->slug ."/edit")->with("success", "User [ ". $user->name . " ] updated.");
    }

    /**
     * @param $image
     */
    private function removeAvatarImage($image)
    {
        if ( ! empty($image) ) {
            $destination = storage_path(config('cms.image.avatar_directory'));
            $imagePath     = $destination . $image;

            if ( file_exists($imagePath) ) unlink($imagePath);
        }
    }
}