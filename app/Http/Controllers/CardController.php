<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use Illuminate\Support\Facades\DB;
use Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;


class CardController extends Controller
{

    public function dodajIskaznicu(Request $request) {

        $rules = [
            'addCard-name' => ['required', 'min:2', 'max: 50'],
            'addCard-medium' => ['required', 'min:2', 'max:50'],
            'addCard-duty' => ['required', 'min:2', 'max:50'],
            'addCard-validUntil' => ['required', 'date'],
            'addCard_image' => ['required', 'mimes:jpeg,jpg,png,bmp'],
        ];
        $messages = [
            'addCard-name.required' => 'Niste unijeli ime i prezime!',
            'addCard-name.min' => 'Ime mora biti minimalno 2 znaka!',
            'addCard-name.max' => 'Ime mora biti maksimalno 50 znakova!',

            'addCard-medium.required' => 'Niste unijeli medij!',
            'addCard-medium.min' => 'Medij mora biti minimalno 2 znaka!',
            'addCard-medium.max' => 'Medij mora biti maksimalno 50 znakova!',

            'addCard-duty.required' => 'Niste unijeli dužnost!',
            'addCard-duty.min' => 'Dužnost mora biti minimalno 2 znaka!',
            'addCard-duty.max' => 'Dužnost mora biti maksimalno 50 znakova!',

            'addCard-validUntil.required' => 'Važenje iskaznice nije unešeno!',
            'addCard-validUntil.date'=> 'Datum nije ispravno unešen!',

            'addCard_image.required' => 'Niste odabrali sliku!',
            'addCard_image.mimes' => 'Format slike nije podržan!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        
        $name = auth()->user()->id . '-' . Str::random(15) . '-' . $request->addCard_image->getClientOriginalName();

        $newCardId = Card::create([
            'dodao_korisnik' => auth()->user()->id,
            'ime_prezime' => $request->input('addCard-name'),
            'medij' => $request->input('addCard-medium'),
            'duznost' => $request->input('addCard-duty'),
            'vazi_do' => $request->input('addCard-validUntil'),
            'slika' => $name,
            'qr_kod' => 'Ako vidite ovu poruku dulje od 1 minute doslo je do greske.',
            'ID_iskaznice' => Str::uuid(),
        ]);
        $request->addCard_image->storeAs('slikeKorisnika', $name, 'public');

        //QR name is generated with Str::random(), so it needs to be stored because it is used twice separately
        $qr_name = auth()->user()->id . '-' . Str::random(15) . '.svg';
        QrCode::generate('localhost:8000/viewProfile/' . $newCardId->ID_iskaznice, '../public/storage/QR_kodovi/' . $qr_name);
        DB::table('cards')->where('id', $newCardId->id)->update(['qr_kod' => $qr_name]);

        return redirect()->route('viewProfile', ['brIskaznice' => $newCardId->ID_iskaznice]);
    }

    public function dohvatiProfil($brIskaznice) {

        if ( DB::table('cards')->where('ID_iskaznice', $brIskaznice)->where('deleted_at', NULL)->exists() ) {
            $card = DB::table('cards')->where('ID_iskaznice', $brIskaznice)->first();

            while (strlen($card->id) < 5) 
                $card->id =  '0' . $card->id;
                $card->vazi_do = Carbon::parse($card->vazi_do)->format('d/m/y');

                $dodao_korisnik = DB::table('users')->where('id', $card->dodao_korisnik)->first();
                $card->dodao_korisnik = $dodao_korisnik->name;
                return view("viewProfile")->with('card', $card);

        } else {
            return view("notFound");
        }

    }

    public function dohvatiProfilZaEditiranje($brIskaznice) {
        if ( DB::table('cards')->where('ID_iskaznice', $brIskaznice)->where('deleted_at', NULL)->exists() ) {
            $card = DB::table('cards')->where('ID_iskaznice', $brIskaznice)->first();
            return view("editCard")->with('card', $card);
        } else {
            return view("notFound");
        }
    }

    public function editProfile(Request $request, $brIskaznice) {
        if (DB::table('cards')->where('ID_iskaznice', $brIskaznice)->where('deleted_at', NULL)->exists() ) {
            $rules = [
                'editCard-name' => ['required', 'min:2', 'max: 50'],
                'editCard-medium' => ['required', 'min:2', 'max:50'],
                'editCard-duty' => ['required', 'min:2', 'max:50'],
                'editCard-validUntil' => ['required', 'date'],
                'editCard_image' => ['sometimes', 'mimes:jpeg,jpg,png,bmp'],
            ];
            $messages = [
                'editCard-name.required' => 'Niste unijeli ime i prezime!',
                'editCard-name.min' => 'Ime mora biti minimalno 2 znaka!',
                'editCard-name.max' => 'Ime mora biti maksimalno 50 znakova!',

                'editCard-medium.required' => 'Niste unijeli medij!',
                'editCard-medium.min' => 'Medij mora biti minimalno 2 znaka!',
                'editCard-medium.max' => 'Medij mora biti maksimalno 50 znakova!',

                'editCard-duty.required' => 'Niste unijeli dužnost!',
                'editCard-duty.min' => 'Dužnost mora biti minimalno 2 znaka!',
                'editCard-duty.max' => 'Dužnost mora biti maksimalno 50 znakova!',

                'vazeditCard-validUntilenje.required' => 'Važenje iskaznice nije unešeno!',
                'editCard-validUntil.date'=> 'Datum nije ispravno unešen!',

                'editCard_image.mimes' => 'Format slike nije podržan!',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            // If there is an image change, upload the new one and delete the old one.
            // Otherwise just change the other info
            if($request->editCard_image) {
                $old_name = DB::table('cards')->where('ID_iskaznice', $brIskaznice)->value('slika');
                Storage::delete('/public/slikeKorisnika/' . $old_name);

                $name = auth()->user()->id . '-' . Str::random(15) . '-' . $request->editCard_image->getClientOriginalName();
                DB::table('cards')->where('ID_iskaznice', $brIskaznice)
                    ->update([
                        'dodao_korisnik' => auth()->user()->id,
                        'ime_prezime' => $request->input('editCard-name'),
                        'medij' => $request->input('editCard-medium'),
                        'duznost' => $request->input('editCard-duty'),
                        'vazi_do' => $request->input('editCard-validUntil'),
                        'slika' => $name,
                        'updated_at' => Carbon::now()
                        ]);
                $request->editCard_image->storeAs('slikeKorisnika', $name, 'public');

            } else {
                DB::table('cards')->where('ID_iskaznice', $brIskaznice)
                    ->update([
                        'dodao_korisnik' => auth()->user()->id,
                        'ime_prezime' => $request->input('editCard-name'),
                        'medij' => $request->input('editCard-medium'),
                        'duznost' => $request->input('editCard-duty'),
                        'vazi_do' => $request->input('editCard-validUntil'),
                        'updated_at' => Carbon::now()
                        ]);
            }
            
            return redirect()->route('viewProfile', ['brIskaznice' => $brIskaznice])->with('success', 'Promjene uspješno spremljene.');
        } else {
            return redirect()->route('home')->with('error', 'Iskaznica je izbrisana ili ne postoji.');
        }
    }

    public function deleteProfile($brIskaznice) {
        if ( DB::table('cards')->where('ID_iskaznice', $brIskaznice)->exists() ) {
            $result = DB::table('cards')->where('ID_iskaznice', $brIskaznice)->first();

            //Delete image and QR code (and remove their entries from the database), then soft delete item
            Storage::delete(['public/slikeKorisnika/' . $result->slika, 'public/QR_kodovi/' . $result->qr_kod]);
            DB::table('cards')->where('ID_iskaznice', $brIskaznice)
                ->update([
                    'slika' => 'DELETED',
                    'qr_kod' => 'DELETED',
                    ]);
            Card::where('ID_iskaznice', $brIskaznice)->delete();

            return redirect()->route('home')->with('success', 'Iskaznica uspješno izbrisana.');
        } else {
            return redirect()->route('home')->with('error', 'Iskaznica ne postoji.');
        }


    }

}
