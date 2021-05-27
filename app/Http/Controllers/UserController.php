<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function editUser(Request $request, $userId) {

        //The Validation rules are defined based on the values of the request
        $rules = [];
        $user = User::where('id', $userId)->first();
        
        if ($request->input('editAdmin-nameInput') != $user->name) {
            $rules['editAdmin-nameInput'] = ['required', 'min:2', 'max: 50'];
        }
        if ($request->input('editAdmin-passwordInput')) {
            $rules['editAdmin-passwordInput'] = ['min:8', 'confirmed'];
        }
        if ($request->input('email') != $user->email) {
            $rules['email'] = ['required', 'min:2', 'max:50', 'email', 'unique:users'];
        }

        $messages = [
            'editAdmin-nameInput.required' => 'Niste unijeli ime!',
            'editAdmin-nameInput.min' => 'Ime mora biti minimalno 2 znaka!',
            'editAdmin-nameInput.max' => 'Ime mora biti maksimalno 50 znakova!',

            'email.required' => 'Niste unijeli email!',
            'email.min' => 'Email mora biti minimalno 2 znaka!',
            'email.max' => 'Email mora biti maksimalno 50 znakova!',
            'email.email' => 'Neispravan format emaila!',
            'email.unique' => 'Email je već u upotrebi!',

            'editAdmin-passwordInput.min' => 'Šifra mora imati minimalno 8 znakova!',
            'editAdmin-passwordInput.confirmed' => 'Šifre se ne podudaraju!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        //If anything has been changed, we check what was changed and update it
        if(!empty($rules)) {

            if (array_key_exists('editAdmin-nameInput', $rules)) {
                $user->name = $request->input('editAdmin-nameInput');
            }
            if (array_key_exists('email', $rules)) {
                $user->email = $request->input('email');
            }
            if (array_key_exists('editAdmin-passwordInput', $rules)) {
                $user->password = Hash::make($request->input('editAdmin-passwordInput'));
            }
            $user->save();

            return redirect()->route('home')->with('success', 'Podatci uspješno promijenjeni.');

        } else {
            return redirect()->route('home')->with('info', 'Nije bilo promjena.');
        }
            

    }
}
