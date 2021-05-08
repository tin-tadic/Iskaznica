@extends('layouts.app')

@section('pageTitle', 'Stranica nije pronađena')

@section('content')
<div class="container">
    <div class="row justify-content-center padMe">

        <div class="card" id="notFoundMain">
            <div class="card-body" id="centerMeNotFound">
                <img id="notFound" src="/storage/slikeKorisnika/notFound.jpg" alt="profil ne postoji" />
                <p id="nePostojiText">Stranica nije pronađena</p>
            </div>
        </div>

    </div>


</div>
@endsection
