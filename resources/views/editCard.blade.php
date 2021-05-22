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
                        
                        <hr id="newCardHeaderDivider" />
                        <form id="newCardForm" action="/edit-iskaznice/{{ $card->id }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <div class="error-wrapper">
                                    <input class="unosPodataka unesiText" type="text" id="editCard-name" name="editCard-name" placeholder="Ime i prezime" value="{{ $card->ime_prezime }}" /><br />
                                    @if ($errors->has('editCard-name'))
                                        <p class="addCardError">{{ $errors->first('editCard-name') }}</p>
                                    @endif
                                </div>

                                <div class="error-wrapper">
                                    <input class="unosPodataka unesiText" type="text" id="editCard-medium" name="editCard-medium" placeholder="Medij korisnika" value="{{ $card->medij }}" /><br />
                                    @if ($errors->has('editCard-medium'))
                                        <p class="addCardError">{{ $errors->first('editCard-medium') }}</p>
                                    @endif
                                </div>

                                <div class="error-wrapper">
                                    <input class="unosPodataka unesiText" type="text" id="editCard-duty" name="editCard-duty" placeholder="Dužnost korisnika" value="{{ $card->duznost }}" /><br />
                                    @if ($errors->has('editCard-duty'))
                                        <p class="addCardError">{{ $errors->first('editCard-duty') }}</p>
                                    @endif
                                </div>

                                <div class="error-wrapper">
                                    <p class="label">Važi do:</p>
                                    {{-- Formatiranje obavezno jer now() vraca i vrijeme --}}
                                    <input class="unosPodataka unesiText" type="date" id="editCard-validUntil" name="editCard-validUntil" placeholder="mm/dd/yyyy" min="{{ $card->vazi_do }}" value="{{ $card->vazi_do }}" /><br />
                                    @if ($errors->has('editCard-validUntil'))
                                        <p class="addCardError">{{ $errors->first('editCard-validUntil') }}</p>
                                    @endif
                                </div>
                                
                                <div class="error-wrapper addCardBottom">
                                    <p class="label">Profilna slika:</p>
                                    <input type="file" id="editCard_image" name="editCard_image" /><br />
                                    @if ($errors->has('editCard_image'))
                                        <p class="addCardError">{{ $errors->first('editCard_image') }}</p>
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
