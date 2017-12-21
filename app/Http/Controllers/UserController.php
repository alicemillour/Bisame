<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUser;
use App\Http\Requests\UpdateUserPosition;
use App\Http\Requests\UpdateUserAge;
use App\Http\Requests\UpdateUserAvatar;
use App\Repositories\UserRepository;
use App\User;
use App\Role;
use App\AgeGroup;
use App\Badge;
use App\Avatar;

class UserController extends Controller
{
    /**
    * Display the specified resource.
    */
    public function show(Request $request, User $user)
    {
        return view('users.show', [
            'user' => $user,
            'recipes' => $user->recipes()->latest()->limit(3)->get(),
            'badges' => Badge::get(),
            // 'recipes' => $user->recipes()->withCount('comments')->latest()->limit(3)->get(),
            // 'comments' => $user->comments()->with('post.author')->latest()->limit(5)->get(),
            // 'roles' => Role::all()
        ]);
    }

    /**
    * Display the specified resource.
    */
    public function home()
    {
        $user = auth()->user();
        return view('users.home', [
            'user' => $user,
            'recipes' => $user->recipes()->latest()->limit(3)->get(),
            'age_groups' => AgeGroup::get(),
            'badges' => Badge::get(),
            'avatars' => Avatar::get(),
            // 'recipes' => $user->recipes()->withCount('comments')->latest()->limit(3)->get(),
            // 'comments' => $user->comments()->with('post.author')->latest()->limit(5)->get(),
            // 'roles' => Role::all()
        ]);
    }

    /**
    * Show the form for editing the specified resource.
    */
    public function edit(Request $request, User $user)
    {
        $this->authorize('update', $user);

        return view('users.edit', $user, [
            'user' => $user,
            'roles' => Role::all()
        ]);
    }

    /**
    * Update the specified resource in storage.
    */
    public function update(UpdateUser $request, User $user)
    {
        $this->authorize('update', $user);

        $user->update(array_filter($request->only(['name', 'email', 'password'])));

        return redirect()->route('users.home')->withSuccess(__('users.updated'));
    }

    /**
    * Update the specified resource in storage.
    */
    public function updatePosition(UpdateUserPosition $request)
    {
        $user = auth()->user();
        print_r($user);
        // $this->authorize('update', $user);

        $user->posX = $request->input('posX');
        $user->posY = $request->input('posY');
        $user->save();

        return __('users.updated');
    }

    /**
    * Update the specified resource in storage.
    */
    public function updateAge(UpdateUserAge $request)
    {
        $user = auth()->user();

        $this->authorize('update', $user);

        $user->update(array_filter($request->only(['age_group_id'])));

        return __('users.updated');
    }
    /**
    * Update the specified resource in storage.
    */
    public function updateAvatar(UpdateUserAvatar $request)
    {
        $user = auth()->user();

        $this->authorize('update', $user);

        $user->update(array_filter($request->only(['avatar_id'])));

        return __('users.updated');
    }
    
        /**
     * Delete the account of the user.
     *
     * @param  UserRepository  $users
     * @return \Illuminate\Http\Response
     */
    public function getDelete(UserRepository $users)
    {
        Auth::user()->name = 'deleted_'.Auth::user()->id;
        Auth::user()->email = null;
        Auth::user()->save();
        Auth::user()->delete();
//        $users->destroy(Auth::user()->id);
        Auth::logout();
        return redirect('');
    }
}
