@extends('layouts.app')

@section('pageTitle', 'Promjena podataka iskaznice')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                

                <div class="card-body">                    
                    <div class="centerMe">

                        <p id="newCardHeader">Promjena podataka iskaznice</p>
                        
                        {{-- For testing to see if there are any errors --}}
                        {{-- @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br />
                                
                            @endforeach
                            
                        @endif --}}
                        <hr id="newCardHeaderDivider" />
                        <form id="newCardForm" action="/editProfile/{{ $id }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <div class="error-wrapper">
                                    <input class="unosPodataka unesiText" type="text" id="imePrezimeUnos" name="imePrezime" placeholder="Ime i prezime" value="{{ $imePrezime }}" /><br />
                                    @if ($errors->has('imePrezime'))
                                        <p class="addCardError">{{ $errors->first('imePrezime') }}</p>
                                    @endif
                                </div>

                                <div class="error-wrapper">
                                    <input class="unosPodataka unesiText" type="text" id="medijUnos" name="medij" placeholder="Medij korisnika" value="{{ $medij }}"/><br />
                                    @if ($errors->has('medij'))
                                        <p class="addCardError">{{ $errors->first('medij') }}</p>
                                    @endif
                                </div>

                                <div class="error-wrapper">
                                    <input class="unosPodataka unesiText" type="text" id="duznostUnos" name="duznost" placeholder="Dužnost korisnika" value="{{ $duznost }}" /><br />
                                    @if ($errors->has('duznost'))
                                        <p class="addCardError">{{ $errors->first('duznost') }}</p>
                                    @endif
                                </div>

                                <div class="error-wrapper">
                                    <p class="label">Važi do:</p>
                                    {{-- Formatiranje obavezno jer now() vraca i vrijeme --}}
                                    <input class="unosPodataka unesiText" type="date" id="vazenjeUnos" name="vazenje" placeholder="mm/dd/yyyy" value="{{ $vazi_do }}" min="{{ $vazi_do }}" /><br />
                                    @if ($errors->has('vazenje'))
                                        <p class="addCardError">{{ $errors->first('vazenje') }}</p>
                                    @endif
                                </div>
                                
                                <div class="error-wrapper addCardBottom">
                                    <p class="label">Profilna slika:</p>
                                    <input type="file" id="slikaUnos" name="image" /><br />
                                    @if ($errors->has('image'))
                                        <p class="addCardError">{{ $errors->first('image') }}</p>
                                    @endif
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
