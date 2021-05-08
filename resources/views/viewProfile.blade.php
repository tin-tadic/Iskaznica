@extends('layouts.app')

@section('pageTitle', 'Podatci o iskaznici')

@section('content')
<div class="container">
    <div class="row justify-content-center padMe">

        <div class="col-md-6 leftSide">

            <div class="centerMe">
                <div id="profilePicDiv">
                    <img id="profilePic" src="/storage/slikeKorisnika/{{ $slika }}" alt="profilna slika" />
                </div>
                <p id="imePrezime">{{ $imePrezime }}</p>
            </div>

        </div>

        <div class="col-md-6 rightSide">

                <div id="podatci">

                    <div class="centerMe">
                        <p class="poddioIskaznice">Broj Iskaznice</p>
                        <p class="vrijednost" id="brIskaznice">{{ $id }}</p>
                    </div>

                    <div class="centerMe">
                        <p class="poddioIskaznice">Medij</p>
                        <p class="vrijednost" id="medij">{{ $medij }}</p>
                    </div class="centerMe">

                    <div class="centerMe">
                        <p class="poddioIskaznice">Dužnost</p>
                        <p class="vrijednost" id="duznost">{{ $duznost }}</p>
                    </div class="centerMe">

                    <div class="centerMe">
                        <p class="poddioIskaznice">Važi do</p>
                        <p class="vrijednost" id="vazenje">{{ $vazi_do }}</p>
                    </div>

                    @if (Auth::user() && Auth::user()->role > 0)
                        <div class="centerMe">
                            <p class="poddioIskaznice">Dodao korisnik</p>
                            <p class="vrijednost" id="vazenje">{{ $dodao_korisnik }}</p>
                        </div>
                    @endif
        </div>
    </div>
</div>
@endsection
