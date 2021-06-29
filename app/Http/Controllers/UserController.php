<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function loadAddUser() {
        return view('addUser')->with('password', Str::random());
    }

    public function addUser(Request $request) {

        $rules = [
            'name' => ['required', 'min:2', 'max: 20'],
            'email' => ['required', 'max:50', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'max:20'],
        ];
        $messages = [
            'name.required' => 'Niste unijeli ime!',
            'name.min' => 'Ime mora biti minimalno 2 znaka!',
            'name.max' => 'Ime mora biti maksimalno 20 znakova!',

            'email.required' => 'Niste unijeli email!',
            'email.max' => 'Email mora biti maksimalno 50 znakova!',
            'email.email' => 'Format emaila nije ispravan!',
            'email.unique' => 'Email je već u uporabi!',

            'password.required' => 'Niste unijeli lozinku!',
            'password.min' => 'lozinka mora biti minimalno 8 znakova!',
            'password.max' => 'Dužnost mora biti maksimalno 20 znakova!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 1,
        ]);

        return redirect()->route('home')->with('success', 'Administrator uspješno dodan.');
    }

    public function editUser(Request $request, $userId) {

        //The Validation rules are defined based on the values of the request
        $rules = [];
        $user = User::where('id', $userId)->first();
        
        //Here we check the request and only add the validation rules if the user has changed that field
        //This is done because it allows us to only call the "update" function later on for only the changed fields
        if ($request->input('editAdmin-nameInput') != $user->name) {
            $rules['editAdmin-nameInput'] = ['min:2', 'max: 50'];
        }
        if ($request->input('editAdmin-passwordInput')) {
            $rules['editAdmin-passwordInput'] = ['min:8', 'confirmed'];
        }
        if ($request->input('email') != $user->email) {
            $rules['email'] = ['min:2', 'max:50', 'email', 'unique:users'];
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
                
                //Reduces strain on DB with one (1!) whole less write request
                if (!$user->password_changed) {
                    $user->password_changed = 1;
                }
            }
            $user->save();

            return redirect()->route('home')->with('success', 'Podatci uspješno promijenjeni.');

        } else {
            return redirect()->route('home')->with('info', 'Nije bilo promjena.');
        }
            

    }

    public function disableAdmin($userId) {

        //Prevents the superadmin from disabling themselves
        if (User::find($userId)->role == 2) {
            return redirect()->route('home')->with('error', 'Ne možete sami sebi onesposobiti račun...');
        }

        try {
            User::find($userId)->update(['disabled' => 1]);
            return redirect()->back()->with('info', 'Ovaj administrator je sada onemogućen!');

        } catch (ModelNotFoundException $exception) {
            return redirect()->route('home')->with('error', 'Taj administrator ne postoji!');
        }
    }

    public function enableAdmin($userId) {
        try {
            User::find($userId)->update(['disabled' => 0]);
            return redirect()->back()->with('success', 'Ovaj administrator je ponovno omogućen!');

        } catch (ModelNotFoundException $exception) {
            return redirect()->route('home')->with('error', 'Taj administrator ne postoji!');
        }
    }

}
