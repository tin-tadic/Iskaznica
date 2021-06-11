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
                                
                                <div class="editAdmin-errorWrapper">

                                    <p class="bolder">Automatski Generirana Šifra</p>
                                    <div>
                                        <input type="text" class="unosPodataka unesiText" id="editAdmin-passwordInput" name="password" value="{{ $password }}" /><br />
                                    </div>
                                    <p>
                                        Novi administratori moraju promijeniti šifru prije donošenja ikakvih promjena!<br />
                                        Kliknite na dugme kako biste kopirali generiranu šifru.
                                    </p>
                                    <button type="button" id="copyPasswordButton" onclick="copyPassword()">Kopiraj šifru</button>
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

<script>
    function copyPassword() {

        //TODO::automail
        var copyText = document.getElementById("editAdmin-passwordInput");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        alert("Šifra uspješno kopirana.");
    }
</script>

<style>
    #copyPasswordButton {
        border: 1px solid blue;
        border-radius: 10px;
        color: red;
    }
</style>

@endsection
