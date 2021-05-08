<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use Illuminate\Support\Facades\DB;
use Validator;


class CardController extends Controller
{
    public function dodajIskaznicu(Request $request) {
        $rules = [
            'imePrezime' => ['required', 'min:2', 'max: 50'],
            'medij' => ['required', 'min:2', 'max:50'],
            'duznost' => ['required', 'min:2', 'max:50'],
            'vazenje' => ['required', 'date'],
            'image' => ['required', 'mimes:jpeg,jpg,png,bmp'],
        ];
        $messages = [
            'imePrezime.required' => 'Niste unijeli ime i prezime!',
            'imePrezime.min' => 'Ime mora biti minimalno 2 znaka!',
            'imePrezime.max' => 'Ime mora biti maksimalno 50 znakova!',

            'medij.required' => 'Niste unijeli medij!',
            'medij.min' => 'Medij mora biti minimalno 2 znaka!',
            'medij.max' => 'Medij mora biti maksimalno 50 znakova!',

            'duznost.required' => 'Niste unijeli dužnost!',
            'duznost.min' => 'Dužnost mora biti minimalno 2 znaka!',
            'duznost.max' => 'Dužnost mora biti maksimalno 50 znakova!',

            'vazenje.required' => 'Važenje iskaznice nije ispravno unešeno!',
            'vazenje.date'=> 'Datum nije ispravno unešen!',

            'image.required' => 'Niste odabrali sliku!',
            'image.mimes' => 'Format slike nije podržan!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }


        $name = time() . $request->image->getClientOriginalName();

        $newCardId = Card::create([
            'dodao_korisnik' => auth()->user()->id,
            'ime_prezime' => $request->input('imePrezime'),
            'medij' => $request->input('medij'),
            'duznost' => $request->input('duznost'),
            'vazi_do' => $request->input('vazenje'),
            'slika' => $name,
            'qr_kod' => 'TODO in controller'
        ]);
        $request->image->storeAs('slikeKorisnika', $name, 'public');


        return redirect()->route('viewProfile', ['brIskaznice' => $newCardId->id]);
    }


    public function dohvatiProfil($brIskaznice) {
        if ( DB::table('cards')->where('id', $brIskaznice)->exists() ) {
            $result = DB::table('cards')->where('id', $brIskaznice)->get();

            //Ima li elegantniji nacin da se ovo posalje na view?
            $slika = $result[0]->slika;
            $imePrezime = $result[0]->ime_prezime;
            $id = $result[0]->id;
            while (strlen($id) < 5) 
                $id =  '0' . $id;
            $medij = $result[0]->medij;
            $duznost = $result[0]->duznost;
            //Returns 'Day/Month'
            $vazi_do = $result[0]->vazi_do[-2] . $result[0]->vazi_do[-1] . '/' . $result[0]->vazi_do[-5] . $result[0]->vazi_do[-4];

            if (auth()->user() != null && auth()->user()->role > 0) {
                $dodao_korisnik = DB::table('users')->where('id', $result[0]->dodao_korisnik)->get();
                $dodao_korisnik = $dodao_korisnik[0]->name;
                return view("viewProfile", compact('slika', 'imePrezime', 'id', 'medij', 'duznost', 'vazi_do', 'dodao_korisnik'));
            }
            
            
            return view("viewProfile", compact('slika', 'id', 'medij', 'duznost', 'vazi_do'));
        } else {
            return view("profileNotFound");
        }
    }

}
