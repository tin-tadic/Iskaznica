@extends('layouts.app')

@section('pageTitle', 'Upravljanje korisnikom')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                
                <div class="card-body">
                    <div class="centerMe">

                        <p id="newCardHeader">Upravljanje korisničkim podatcima</p>
                        
                        <hr id="newCardHeaderDivider" />
                        
                        <form id="newCardForm" action="/TODO" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <div class="error-wrapper">
                                    <p>Ime i prezime</p>
                                    <input class="unosPodataka unesiText" type="text" id="user-nameInput" name="user-nameInput" placeholder="Ime i prezime" value="{{ $user->name }}" /><br />
                                    @if ($errors->has('imePrezime'))
                                        <p class="addCardError">{{ $errors->first('imePrezime') }}</p>
                                    @endif
                                </div>

                                <div class="error-wrapper">
                                    <p>Email</p>
                                    <input class="unosPodataka unesiText" type="text" id="user-emailInput" name="user-emailInput" placeholder="Email korisnika" value="{{ $user->email }}"/><br />
                                    @if ($errors->has('email'))
                                        <p class="addCardError">{{ $errors->first('email') }}</p>
                                    @endif
                                </div>

                                <div class="error-wrapper">
                                    <p>Nivo dozvola korisnika</p>
                                    <input class="unosPodataka unesiText" type="text" id="user-permissionInput" name="user-permissionInput" placeholder="Dužnost korisnika" value="{{ $user->duznost }}" /><br />
                                    @if ($errors->has('duznost'))
                                        <p class="addCardError">{{ $errors->first('duznost') }}</p>
                                    @endif
                                </div>

                                <div class="error-wrapper">
                                    <p class="label">Zadnji put mijenjano</p>
                                    {{-- Formatiranje obavezno jer now() vraca i vrijeme --}}
                                    <input class="unosPodataka unesiText" type="date" id="user-lastUpdated" value="{{ $user->updated_at }}" /><br />
                                </div>
                                


                                <input class="unosPodataka dugmadi" type="submit" id="napraviIskaznicu" value="Spremi promjene" />
                            </div>
                        </form>

                    </div>

                </div>
            </div>        
        
        </div>
    </div>
</div>
@endsection
