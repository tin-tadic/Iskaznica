<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\OldCard;
use Illuminate\Support\Facades\DB;
use Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;


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

            'vazenje.required' => 'Važenje iskaznice nije unešeno!',
            'vazenje.date'=> 'Datum nije ispravno unešen!',

            'image.required' => 'Niste odabrali sliku!',
            'image.mimes' => 'Format slike nije podržan!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }


        $name = auth()->user()->id . '-' . time() . '-' . $request->image->getClientOriginalName();

        $newCardId = Card::create([
            'dodao_korisnik' => auth()->user()->id,
            'ime_prezime' => $request->input('imePrezime'),
            'medij' => $request->input('medij'),
            'duznost' => $request->input('duznost'),
            'vazi_do' => $request->input('vazenje'),
            'slika' => $name,
            'qr_kod' => 'Ako vidite ovu poruku dulje od 1 minute doslo je do greske.',
        ]);
        $request->image->storeAs('slikeKorisnika', $name, 'public');

        //QR name generated with time(), needs to be stored because it is used twice separately
        $qr_name = auth()->user()->id . '-' . time() . '.svg';
        QrCode::generate('localhost:8000/viewProfile/' . $newCardId->id, '../public/storage/QR_kodovi/' . $qr_name);
        DB::table('cards')->where('id', $newCardId->id)->update(['qr_kod' => $qr_name]);

        return redirect()->route('viewProfile', ['brIskaznice' => $newCardId->id]);
    }



    public function dohvatiProfil($brIskaznice) {
        if ( DB::table('cards')->where('id', $brIskaznice)->exists() ) {
            //Use first instead of get
            $result = DB::table('cards')->where('id', $brIskaznice)->get();

            $slika = $result[0]->slika;
            $imePrezime = $result[0]->ime_prezime;
            $id = $result[0]->id;
            while (strlen($id) < 5) 
                $id =  '0' . $id;
            $medij = $result[0]->medij;
            $duznost = $result[0]->duznost;
            //Returns 'Day/Month'
            //$vazi_do = Carbon::parse(result[0]->vazi_do)->foramt('dd.mm.YYYY');
            $vazi_do = $result[0]->vazi_do[-2] . $result[0]->vazi_do[-1] . '/' . $result[0]->vazi_do[-5] . $result[0]->vazi_do[-4];

            if (auth()->user() != null && auth()->user()->role > 0) {
                $dodao_korisnik = DB::table('users')->where('id', $result[0]->dodao_korisnik)->get();
                $dodao_korisnik = $dodao_korisnik[0]->name;
                return view("viewProfile", compact('slika', 'imePrezime', 'id', 'medij', 'duznost', 'vazi_do', 'dodao_korisnik'));
            }
            
            
            return view("viewProfile", compact('slika', 'imePrezime', 'id', 'medij', 'duznost', 'vazi_do'));
        } else {
            return view("notFound");
        }
    }

    public function dohvatiProfilZaEditiranje($brIskaznice) {
        if ( DB::table('cards')->where('id', $brIskaznice)->exists() ) {
            $result = DB::table('cards')->where('id', $brIskaznice)->get();

            $slika = $result[0]->slika;
            $imePrezime = $result[0]->ime_prezime;
            $id = $result[0]->id;
            $medij = $result[0]->medij;
            $duznost = $result[0]->duznost;
            $vazi_do = $result[0]->vazi_do;            
            
            return view("editCard", compact('slika', 'imePrezime', 'id', 'medij', 'duznost', 'vazi_do'));
        } else {
            return view("notFound");
        }
    }

    public function editProfile(Request $request, $brIskaznice) {
        $rules = [
            'imePrezime' => ['required', 'min:2', 'max: 50'],
            'medij' => ['required', 'min:2', 'max:50'],
            'duznost' => ['required', 'min:2', 'max:50'],
            'vazenje' => ['required', 'date'],
            'image' => ['mimes:jpeg,jpg,png,bmp'],
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

            'vazenje.required' => 'Važenje iskaznice nije unešeno!',
            'vazenje.date'=> 'Datum nije ispravno unešen!',

            'image.mimes' => 'Format slike nije podržan!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        // If there is an image change, upload the new one and delete the old one.
        // Otherwise just change the other info
        if($request->image) {
            $old_name = DB::table('cards')->where('id', $brIskaznice)->value('slika');
            Storage::delete('/public/slikeKorisnika/' . $old_name);

            $name = auth()->user()->id . '-' . time() . '-' . $request->image->getClientOriginalName();
            DB::table('cards')->where('id', $brIskaznice)
                ->update([
                    'dodao_korisnik' => auth()->user()->id,
                    'ime_prezime' => $request->input('imePrezime'),
                    'medij' => $request->input('medij'),
                    'duznost' => $request->input('duznost'),
                    'vazi_do' => $request->input('vazenje'),
                    'slika' => $name,
                    ]);
            $request->image->storeAs('slikeKorisnika', $name, 'public');

            return redirect()->route('viewProfile', ['brIskaznice' => $brIskaznice]);
        } else {
            DB::table('cards')->where('id', $brIskaznice)
                ->update([
                    'dodao_korisnik' => auth()->user()->id,
                    'ime_prezime' => $request->input('imePrezime'),
                    'medij' => $request->input('medij'),
                    'duznost' => $request->input('duznost'),
                    'vazi_do' => $request->input('vazenje'),
                    ]);
            return redirect()->route('viewProfile', ['brIskaznice' => $brIskaznice]);
        }


        $name = auth()->user()->id . '-' . time() . '-' . $request->image->getClientOriginalName();

        $newCardId = Card::create([
            'dodao_korisnik' => auth()->user()->id,
            'ime_prezime' => $request->input('imePrezime'),
            'medij' => $request->input('medij'),
            'duznost' => $request->input('duznost'),
            'vazi_do' => $request->input('vazenje'),
            'slika' => $name,
        ]);
        $request->image->storeAs('slikeKorisnika', $name, 'public');


        return redirect()->route('viewProfile', ['brIskaznice' => $newCardId->id]);
    }

    //Make into soft delete()
    public function deleteProfile($brIskaznice) {
        if ( DB::table('cards')->where('id', $brIskaznice)->exists() ) {
            $result = DB::table('cards')->where('id', $brIskaznice)->get();

            $slika = $result[0]->slika;
            $imePrezime = $result[0]->ime_prezime;
            $id = $result[0]->id;
            $medij = $result[0]->medij;
            $duznost = $result[0]->duznost;
            $vazi_do = $result[0]->vazi_do;
            $dodao_korisnik = DB::table('users')->where('id', $result[0]->dodao_korisnik)->get();

            OldCard::create([
                'dodao_korisnik' => $dodao_korisnik[0]->id,
                'ime_prezime' =>  $imePrezime,
                'medij' => $medij,
                'duznost' => $duznost,
                'vazi_do' => $vazi_do,
                'slika' => $slika,
                'izbrisano' => now(),
                'izbrisao_korisnik' => auth()->user()->id,
            ]);
            //Storage::move('slikeKorisnika/' . $slika, 'stareSlikeKorisnika/' . $slika);

            DB::table('cards')->where('id', '=', $brIskaznice)->delete();


            //TODO::Redirect to home page with message
            return "Uspjesno izbrisano!";
        } else {
            //TODO::Redirect to same page with message
            return "Doslo je do greske";
        }

    }

}
