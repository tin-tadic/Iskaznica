@extends('layouts.app')

@section('pageTitle', 'Upravljanje korisnikom')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                
                <div class="card-body">
                    <div class="centerMe">

                        <p class="newCardHeader">Upravljanje Administratorskim Profilom</p>
                        
                        <hr id="newCardHeaderDivider" />
                        
                        <form id="newCardForm" action="/edit-user/{{ $user->id }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="editAdmin-main">
                                <div class="editAdmin-errorWrapper">
                                    <p class="bolder">Ime</p>
                                    <input class="unosPodataka unesiText" type="text" id="editAdmin-nameInput" name="editAdmin-nameInput" placeholder="Ime" value="{{ $user->name }}" /><br />
                                    @if ($errors->has('editAdmin-nameInput'))
                                        <p class="addCardError">{{ $errors->first('editAdmin-nameInput') }}</p>
                                    @endif
                                </div>

                                <div class="editAdmin-errorWrapper">
                                    <p class="bolder">Email</p>
                                    <input class="unosPodataka unesiText" type="text" id="editAdmin_emailInput" name="email" placeholder="Email korisnika" value="{{ $user->email }}"/><br />
                                    @if ($errors->has('email'))
                                        <p class="addCardError">{{ $errors->first('email') }}</p>
                                    @endif
                                </div>

                                
                                <div class="editAdmin-errorWrapper">
                                    <fieldset id="passwordChange">
                                        
                                        <legend id="passwordChangeLegend">Promjena šifre</legend>
                                        
                                        <p class="bolder">Šifra</p>
                                        <input class="unosPodataka unesiText editAdmin-password" type="password" id="editAdmin-passwordInput" name="editAdmin-passwordInput" placeholder="Unesite novu šifru" /><br /><br />
                                        
                                        <p class="bolder">Potvrda šifre</p>
                                        <input class="unosPodataka unesiText editAdmin-password" type="password" id="editAdmin-passwordInput_confirmation" name="editAdmin-passwordInput_confirmation" placeholder="Potvrdite novu šifru" /><br />
                                        
                                        @if ($errors->has('editAdmin-passwordInput'))
                                            <p class="addCardError">{{ $errors->first('editAdmin-passwordInput') }}</p>
                                        @endif

                                    </fieldset>
                                </div>


                                
                                <input class="unosPodataka dugmadi editAdmin-button" type="submit" id="napraviIskaznicu" value="Spremi promjene" />
                            </div>
                        </form>

                        @if(Auth::user()->role == 2 && $user->id != 1)
                            <div>
                                @if(!$user->disabled)
                                    <a class="editAdmin-hammerTime" id="" onclick="event.preventDefault();
                                        if(confirm('Jeste li sigurni da želite onesposobiti račun ovog administratora? \n\nKorisnik se neće moći prijaviti dok ne osposobite račun.')) {
                                                document.getElementById('disableAdmin').submit();
                                            }">
                                        Onesposobi račun
                                    </a>
                                    <form id="disableAdmin" action="{{ route('disableAdmin', ['userId' => $user->id]) }}" method="POST">
                                        @csrf
                                    </form>
                                @else
                                    <a class="editAdmin-hammerTime" id="" onclick="event.preventDefault();
                                        if(confirm('Jeste li sigurni da želite ponovno osposobiti račun ovog administratora?')) {
                                                document.getElementById('enableAdmin').submit();
                                            }">
                                        Osposobi račun
                                    </a>
                                    <form id="enableAdmin" action="{{ route('enableAdmin', ['userId' => $user->id]) }}" method="POST">
                                        @csrf
                                    </form>
                                @endif
                            </div>
                        @endif

                    </div>

                </div>
            </div>        
        
        </div>
    </div>
</div>
@endsection
