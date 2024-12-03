<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UpdateProfilePasswordRequest;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public static function middleware(): array
    {
        return [
            'auth'
        ];
    }

    public function showUserProfileForm() {
        $user = User::findOrFail(auth()->id());
        $title = 'Editare Profil Utilizator';
        return view('admin.edit-user-profile-form')->with('user', $user)->with('title', $title);
    }


    public function updateUserProfile(ProfileUpdateRequest $request) {
        $request->validate( 
            [
                'email' => 'unique:users,email,' . auth()->id()
            ],
            [
                'email.unique' => 'Această adresă de email este deja înregistrată!'
            ],
        );
        
        $user = User::findOrFail(auth()->id());

        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;
        
        if($request->hasFile('photo')) {
            if ($user->photo != 'defaultUserPhoto.png') {
                File::delete('storage/images/users/' . $user->photo);
            }
            $photoExtension = $request->file('photo')->getClientOriginalExtension();
            $photoName = str_replace(' ', '_', $request->name) . '_' . time() . '.' . $photoExtension;
            $request->file('photo')->move('storage/images/users', $photoName);

            $user->photo = $photoName;
        }

        $user->save();
        
        return redirect(route('dashboard'));
    }
    
    public function updatePassword(UpdateProfilePasswordRequest $request) {
        $credentials = [
            'email' => auth()->user()->email,
            'password' => $request->old_password
        ];
    
        if (Auth::attempt($credentials)) {
            $newPassword = bcrypt($request->new_password);
            // $user = auth()->user();
            $user = User::findOrFail(auth()->id());
            $user->password = $newPassword;
    
            $user->save();
            
            return redirect()->back()->with('passwordMessage', 'Parola a fost modificată cu succes. <br> Noua parolă pentru acest cont este <strong>' . $request->new_password . '</strong>. <br> Notați noua parolă într-un loc sigur.');
        }
    }
    
}
