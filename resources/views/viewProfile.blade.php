@extends('layouts.app')

@section('pageTitle', 'Podatci o iskaznici')

@section('content')
<div class="container">
    <div class="row justify-content-center padMe">

        {{-- QR modal --}}
        <div class="modal fade" id="qrCodeModal">
            <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">QR kod na iskaznicu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>  
                <div class="modal-body centerMe">
                    <img id="QRcodeImg" src="/storage/QR_kodovi/{{ $card->qr_kod }}" alt="kod ne postoji">
                    <p>{{ $card->ime_prezime }}</p>
                </div>
            </div>
            </div>
        </div>
        {{-- /QR modal --}}

        <div class="col-md-6 leftSide">

            <div class="centerMe">
                <div id="profilePicDiv">
                    <img data-toggle="modal" data-target="#qrCodeModal" id="profilePic" src="/storage/slikeKorisnika/{{ $card->slika }}" alt="slika ne postoji" />
                </div>
                <p id="imePrezime">{{ $card->ime_prezime }}</p>

                @if (Auth::user() && Auth::user()->role > 0)
                    
                <div id="adminButtonUserPageDiv">
                    <a class="adminButtonUserPage" id="editCardButton" href="{{ route('editProfile', $card->ID_iskaznice) }}">Edit</a>
                    <a class="adminButtonUserPage" id="terminateCardButton" onclick="event.preventDefault();
                        if(confirm('Jeste li sigurni da želite izbrisati ovu iskaznicu?')) {
                                document.getElementById('deleteCard-form').submit();
                            }">
                        Ukini
                    </a>
                    <form id="deleteCard-form" action="{{ route('deleteProfile', ['brIskaznice' => $card->ID_iskaznice]) }}" method="POST">
                        @csrf
                    </form>
                </div>
                @endif

            </div>

        </div>

        <div class="col-md-6 rightSide">
        <div id="podatci">
            <div class="centerMe">
                <p class="poddioIskaznice">Broj Iskaznice</p>
                <p class="vrijednost" id="brIskaznice">{{ $card->id }}</p>
            </div>

            <div class="centerMe">
                <p class="poddioIskaznice">Medij</p>
                <p class="vrijednost" id="medij">{{ $card->medij }}</p>
            </div class="centerMe">

            <div class="centerMe">
                <p class="poddioIskaznice">Dužnost</p>
                <p class="vrijednost" id="duznost">{{ $card->duznost }}</p>
            </div class="centerMe">

            <div class="centerMe">
                <p class="poddioIskaznice">Važi do</p>
                <p class="vrijednost" id="vazenje">{{ $card->vazi_do }}</p>
            </div>

            @if (Auth::user() && Auth::user()->role > 0)
                <div class="centerMe">
                    <p class="poddioIskaznice">Dodao Korisnik</p>
                    <p class="vrijednost" id="vazenje">{{ $card->dodao_korisnik }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
