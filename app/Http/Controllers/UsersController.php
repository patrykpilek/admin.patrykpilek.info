<?php

namespace App\Http\Controllers;

use App\User;
use App\Profile;
use App\Http\Requests\UserDestroyRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UsersController extends Controller
{
    /**
     * BlogController constructor.
     */
    public function __construct()
    {
        $this->middleware('verified');
        $this->middleware('auth');
        $this->middleware('check-permissions');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::orderBy('name')->paginate($this->limit);
        $usersCount = User::count();

        return view("users.index", compact('users', 'usersCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        $user = new User();
        return view("users.create", compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name,'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required'],
            'avatar' => ['mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->slug = $request->slug;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->remember_token = Str::random(10);
        $user->save();
        $user->profile()->save(new Profile);
        $user->attachRole($request->role);

        $user->profile->first_name = $request->first_name;
        $user->profile->last_name = $request->last_name;
        $user->profile->birthday = $request->birthday;
        $user->profile->bio = $request->bio;

        if ($request->hasFile('avatar')) {
            $avatarName = $user->id.'_avatar'.time().'.'.request()->avatar->getClientOriginalExtension();
            $request->avatar->storeAs('public/avatars', $avatarName);
            $user->profile->image = $avatarName;
        }

        $user->profile->save();

        return redirect("/users/" . $user->slug ."/edit")->with("success", "[ ". $user->name . " ] created.");
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user)
    {
        return view("users.edit", compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return Response
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

        return redirect("/users/" . $user->slug ."/edit")->with("success", "User [ ". $user->name . " ] updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param UserDestroyRequest $request
     * @param int $id
     * @return Response
     */
    public function destroy(UserDestroyRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $deleteOption = $request->delete_option;
        $selectedUser = $request->selected_user;

        if ($deleteOption == "delete") {
            // delete user posts
            $user->posts()->withTrashed()->forceDelete();
            // delete user image
            if($user->profile->image !== 'default_avatar.png') {
                $this->removeAvatarImage($user->profile->image);
            }
        }
        elseif ($deleteOption == "attribute") {
            $user->posts()->update(['author_id' => $selectedUser]);
        }

        $user->delete();

        return redirect("/users")->with("success", "[ ". $user->name . " ] deleted.");
    }

    /**
     * @param UserDestroyRequest $request
     * @param $id
     * @return Factory|View
     */
    public function confirm(UserDestroyRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $users = User::where('id', '!=', $user->id)->pluck('name', 'id');

        return view("users.confirm", compact('user', 'users'));
    }

    /**
     * @param $image
     */
    private function removeAvatarImage($image)
    {
        if ( ! empty($image) ) {
            $destination = storage_path(config('cms.image.avatar_directory'));
            $imagePath = $destination . $image;

            if ( file_exists($imagePath) ) unlink($imagePath);
        }
    }

}
