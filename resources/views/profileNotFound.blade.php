@extends('layouts.app')

@section('pageTitle', 'Stranica nije pronađena')

@section('content')
<div class="container">
    <div class="row justify-content-center padMe">

        <div>
            <div id="centerMeNotFound">
                <img id="notFound" src="/storage/slikeKorisnika/notFound.jpg" alt="profil ne postoji" />
            </div>
            <p id="nePostojiText">Stranica nije pronađena</p>
        </div>

    </div>


</div>
@endsection
