@extends('layouts.app')

@section('pageTitle', 'Dodavanje novog administratora')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                
                <div class="card-body">
                    <div class="centerMe">

                        <p class="newCardHeader">Dodavanje Novog Administratora</p>
                        
                        <hr id="newCardHeaderDivider" />
                        
                        <form id="newCardForm" action="/add-user/" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <div class="editAdmin-errorWrapper">
                                    <p class="bolder">Ime</p>
                                    <input class="unosPodataka unesiText" type="text" id="editAdmin-nameInput" name="name" placeholder="Ime" value="{{ old('name') }}"/><br />
                                    @if ($errors->has('name'))
                                        <p class="addCardError">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>

                                <div class="editAdmin-errorWrapper">
                                    <p class="bolder">Email</p>
                                    <input class="unosPodataka unesiText" type="text" id="editAdmin_emailInput" name="email" placeholder="Email korisnika" value="{{ old('email') }}"/><br />
                                    @if ($errors->has('email'))
                                        <p class="addCardError">{{ $errors->first('email') }}</p>
                                    @endif
                                </div>

                                <input class="unosPodataka dugmadi editAdmin-button" type="submit" id="napraviIskaznicu" value="Dodaj Administratora" />
                            </div>
                        </form>

                    </div>

                </div>
            </div>        
        
        </div>
    </div>
</div>

@endsection
