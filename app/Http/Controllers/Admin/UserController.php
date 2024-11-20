<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserRequest;
use App\Http\Middleware\OnlyAdminHasAccess;
use Illuminate\Routing\Controllers\HasMiddleware;

class UserController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'auth',
            OnlyAdminHasAccess::class
        ];
    }

    public function showHome() {
        return view('admin.home');
    }

    public function showUsers() {
        $users = User::all()->sortBy('name');
        $title = 'Utilizatori';
        return view('admin.users')->with('users', $users)->with('title', $title);
    }

    public function newUserForm() {
        $title = 'Utilizator nou';
        return view('admin.new-user-form')->with('title', $title);
    }

    public function createNewUser(AddUserRequest $request) {
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->password = bcrypt($request->password);

        if ($request->hasFile('photo')) {
            $photoExtension = $request->file('photo')->getClientOriginalExtension();
            $photoName = str_replace(' ', '_', $request->name) . '_' . time() . '.' . $photoExtension;
            $request->file('photo')->move('images/users', $photoName);

            $user->photo = $photoName;
        }

        $user->save();
        return redirect(route('admin.users'));
    }
}
