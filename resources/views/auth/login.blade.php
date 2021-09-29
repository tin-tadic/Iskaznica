@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body centerMe">
                    <p class="newCardHeader">Prijava</p>
                    <hr id="newCardHeaderDivider" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="centerMe form-group">
                            <input id="email" type="email" class="unosPodataka unesiText @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Unesite email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group centerMe">
                            <input id="password" type="password" class="unosPodataka unesiText @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Unesite šifru">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group centerMe">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                Upamti me
                            </label>
                        </div>
                        <button type="submit" class="unosPodataka dugmadi">
                            Prijava
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
