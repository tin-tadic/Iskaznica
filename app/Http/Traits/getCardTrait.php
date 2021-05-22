<?php

namespace App\Http\Traits;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Card;

trait getCardTrait {
    public static function getCard($brIskaznice) {
        if ( DB::table('cards')->where('id', $brIskaznice)->where('deleted_at', NULL)->exists() ) {
            $result = DB::table('cards')->where('id', $brIskaznice)->first();

            $slika = $result->slika;
            $imePrezime = $result->ime_prezime;
            $id = $result->id;
            while (strlen($id) < 5) 
                $id =  '0' . $id;
            $medij = $result->medij;
            $duznost = $result->duznost;
            $vazi_do = Carbon::parse($result->vazi_do)->format('d/m/y');

            if (auth()->user() != null && auth()->user()->role > 0) {
                $dodao_korisnik = DB::table('users')->where('id', $result->dodao_korisnik)->first();
                $dodao_korisnik = $dodao_korisnik->name;
                return view("viewProfile", compact('slika', 'imePrezime', 'id', 'medij', 'duznost', 'vazi_do', 'dodao_korisnik'));
            }
            
            return view("viewProfile", compact('slika', 'imePrezime', 'id', 'medij', 'duznost', 'vazi_do'));
        } else {
            return view("notFound");
        }
    }
}