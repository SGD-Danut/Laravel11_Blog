<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\AddUserRequest;
use App\Http\Middleware\OnlyAdminHasAccess;
use App\Http\Requests\UpdateUserRequest;
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
            $request->file('photo')->move('storage/images/users', $photoName);

            $user->photo = $photoName;
        }

        $confirmationUpdateMessage = "Utilizatorul " . $request->name . " a fost adăugat cu succes!";

        if ($request->validateEmail == 1) {
            $user->email_verified_at = now();
            $finalConfirmationUpdateMessage = $confirmationUpdateMessage . " Email-ul utilizatorului este validat.";
        } else {
            $finalConfirmationUpdateMessage = $confirmationUpdateMessage . " Email-ul utilizatorului nu este validat.";
        }

        $user->save();

        return redirect(route('admin.users'))->with('success', $finalConfirmationUpdateMessage);
    }

    public function editUserForm($userId) {
        $user = User::findOrFail($userId);
        $title = 'Editare Utilizator';
        return view('admin.edit-user-form')->with('user', $user)->with('title', $title);
    }

    public function updateUser(UpdateUserRequest $request, $userId) {
        $request->validate(
            [
                'email' => 'unique:users,email,' . $userId
            ],
            [
                'email.unique' => 'Această adresă de email este deja înregistrată!'
            ],
        );

        
        $user = User::findOrFail($userId);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->role = $request->role;
        
        if($request->hasFile('photo')) {
            if ($user->photo != 'defaultUserPhoto.png') {
                File::delete('storage/images/users/' . $user->photo);
            }
            $photoExtension = $request->file('photo')->getClientOriginalExtension();
            $photoName = str_replace(' ', '_', $request->name) . '_' . time() . '.' . $photoExtension;
            $request->file('photo')->move('storage/images/users', $photoName);

            $user->photo = $photoName;
        }

        $confirmationUpdateMessage = 'Datele utilizatorului au fost actualizate cu succes';

        //Daca utilizatorul alege optiunea 'Nici-o acțiune':
        if ($request->userEmailAction == 'noAction') {
            $finalConfirmationUpdateMessage = $confirmationUpdateMessage . '.';
        }

        //Trimite notificare utilizatorului de confirmare email - prin email:
        if ($request->userEmailAction == 'notifyUserToConfirmEmail') {
            if ($user->email_verified_at == null) {
                $user->sendEmailVerificationNotification();
                $finalConfirmationUpdateMessage = $confirmationUpdateMessage . " și a fost trimisă o notificare utilizatorului prin email pentru confirmare a email-ului.";
            } else {
                $finalConfirmationUpdateMessage = $confirmationUpdateMessage . ", dar nu s-a trimis o notificare utilizatorului prin email pentru confirmare a email-ului deoarece adresa de email este deja validată.";
            }
        }

        //Validare email:
        if ($request->userEmailAction == 'validateEmail') {
            if ($user->email_verified_at == null) {
                $user->email_verified_at = now();
                $finalConfirmationUpdateMessage = $confirmationUpdateMessage . " și email-ul a fost validat cu succes.";
            } else {
                $finalConfirmationUpdateMessage = $confirmationUpdateMessage . " dar email-ul nu a fost validat cu succes deoarece este deja validat.";   
            }
        }

        //Invalidare email:
        if ($request->userEmailAction == 'invalidateEmail') {
            if ($user->email_verified_at != null) {
                $user->email_verified_at = null;
                $finalConfirmationUpdateMessage = $confirmationUpdateMessage . " și email-ul a fost invalidat cu succes.";
            } else {
                $finalConfirmationUpdateMessage = $confirmationUpdateMessage . " și email-ul nu a fost invalidat cu succes deoarece este deja invalidat.";
            }
        }

        $user->save();
        
        return redirect(route('admin.users'))->with('success', $finalConfirmationUpdateMessage);
    }

    public function deleteUser(Request $request, $userId) {
        $user = User::findOrFail($userId);

        if ($user->role == 'admin') {
            return redirect(route('admin.users'));
        }

        if ($user->photo != 'defaultUserPhoto.png') {
            File::delete('storage/images/users/' . $user->photo);
        }

        $user->delete();
        return redirect(route('admin.users'));
    }
}
