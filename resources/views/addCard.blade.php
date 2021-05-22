@extends('layouts.app')

@section('pageTitle', 'Dodaj novu iskaznicu')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                

                <div class="card-body">                    
                    <div class="centerMe">

                        <p class="newCardHeader">Stvaranje nove iskaznice</p>
                        
                        <hr id="newCardHeaderDivider" />
                        
                        <form id="newCardForm" action="/dodaj-iskaznicu" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <div class="error-wrapper">
                                    <input class="unosPodataka unesiText" type="text" id="addCard-name" name="addCard-name" placeholder="Ime i prezime" value="{{ old('addCard-name') }}" /><br />
                                    @if ($errors->has('addCard-name'))
                                        <p class="addCardError">{{ $errors->first('addCard-name') }}</p>
                                    @endif
                                </div>

                                <div class="error-wrapper">
                                    <input class="unosPodataka unesiText" type="text" id="addCard-medium" name="addCard-medium" placeholder="Medij korisnika" value="{{ old('addCard-medium') }}" /><br />
                                    @if ($errors->has('addCard-medium'))
                                        <p class="addCardError">{{ $errors->first('addCard-medium') }}</p>
                                    @endif
                                </div>

                                <div class="error-wrapper">
                                    <input class="unosPodataka unesiText" type="text" id="addCard-duty" name="addCard-duty" placeholder="Dužnost korisnika" value="{{ old('addCard-duty') }}" /><br />
                                    @if ($errors->has('addCard-duty'))
                                        <p class="addCardError">{{ $errors->first('addCard-duty') }}</p>
                                    @endif
                                </div>

                                <div class="error-wrapper">
                                    <p class="label">Važi do:</p>
                                    {{-- Formatiranje obavezno jer now() vraca i vrijeme --}}
                                    <input class="unosPodataka unesiText" type="date" id="addCard-validUntil" name="addCard-validUntil" placeholder="mm/dd/yyyy" value="{{ now()->format('Y-m-d') }}" min="{{ now()->format('Y-m-d') }}" value="{{ old('addCard-validUntil') }}" /><br />
                                    @if ($errors->has('addCard-validUntil'))
                                        <p class="addCardError">{{ $errors->first('addCard-validUntil') }}</p>
                                    @endif
                                </div>
                                
                                <div class="error-wrapper addCardBottom">
                                    <p class="label">Profilna slika:</p>
                                    <input type="file" id="addCard_image" name="addCard_image" /><br />
                                    @if ($errors->has('addCard_image'))
                                        <p class="addCardError">{{ $errors->first('addCard_image') }}</p>
                                    @endif
                                </div>

                                <input class="unosPodataka dugmadi" type="submit" id="napraviIskaznicu" value="Napravi iskaznicu" />
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
