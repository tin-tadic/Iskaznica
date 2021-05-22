@extends('layouts.app')

@section('pageTitle', 'Upravljanje iskaznicama')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                

                <div class="card-body">
                    <form id="searchUsersForm" action="/pretraga-korisnika" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="error-wrapper">
                            <div class="centerMe">

                                <div class="container">
                                    <div class="row">

                                        <div class="col-sm searchUsers">
                                            <p class="newCardHeader">Pretraga Korisnika</p>

                                            <input type="radio" name="searchParametersUser" id="user-byName" value="user-byName">
                                            <label for="user-byName">Po imenu</label>


                                            <input type="radio" name="searchParametersUser" id="user-byEmail" value="user-byEmail">
                                            <label for="user-byEmail">Po mailu</label>

                                            <input type="radio" name="searchParametersUser" id="user-byRole" value="user-byRole">
                                            <label for="user-byRole">Po nivou dopuštenja/ulozi</label>

                                            {{-- add option for disabled users --}}
                                        </div>

                                        <div class="col-sm searchCards">
                                            <p class="newCardHeader">Pretraga Iskaznica</p>

                                            <input type="radio" name="searchParametersUser" id="card-byName" value="card-byName">
                                            <label for="card-byName">Po imenu</label>

                                            <input type="radio" name="searchParametersUser" id="card-byNumber" value="card-byNumber">
                                            <label for="card-byNumber">Po broju iskaznice</label>

                                            <input type="radio" name="searchParametersUser" id="card-byUuid" value="card-byUuid">
                                            <label for="card-byUuid">Po ID-u iskaznice</label>

                                            {{-- add option for deleted cards --}}
                                        </div>

                                    </div>
                                  </div>
                                <br />

                                {{-- ^Remove this and add a margin to the button below --}}

                                <input class="unosPodataka unesiText" type="text" id="home-searchFor" name="home-searchFor" placeholder="Upišite kriterij za pretragu" value="{{ old('unosKorisnika') }}" /><br />
                            </div>
                        </div>

                    </form>

                </div>
            </div>


            @if ($users = Session::get('users'))
                <div class="card">
                    <div class="card-body home-scrollMe">
                        <table class="home-displayDataTable">
                            <thead>
                                <td>Ime</td>
                                <td>ID korisnika</td>
                                <td>Email</td>
                                <td>Nivo dozvola korisnika</td>
                                <td>Zadnji put mijenjano</td>
                                <td>Edit</td>
                            </thead>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="home-displayData">{{ $user->name }}</td>
                                    <td class="home-displayData">{{ $user->id }}</td>
                                    <td class="home-displayData">{{ $user->email }}</td>
                                    <td class="home-displayData">{{ $user->role }}</td>
                                    <td class="home-displayData">{{ $user->updated_at->format("d/m/y h:m") }}</td>
                                    <td>
                                        <a href="{{ route('getUserForEdit', $user->id) }}" target="_blank">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            @elseif ($cards = Session::get('cards'))
                <div class="card">
                    <div class="card-body home-scrollMe">
                        <table class="home-displayDataTable">
                            <thead>
                                <td>Broj iskaznice</td>
                                <td>ID iskaznice</td>
                                <td>Ime i prezime nositelja</td>
                                <td>Medij</td>
                                <td>Dužnost</td>
                                <td>Važi do</td>
                                <td>Zadnji put mijenjano</td>
                                <td>Pregled</td>
                            </thead>
                            @foreach ($cards as $card)
                                <tr>
                                    <td class="home-displayData">{{ $card->id }}</td>
                                    <td class="home-displayData">{{ $card->ID_iskaznice }}</td>
                                    <td class="home-displayData">{{ $card->ime_prezime }}</td>
                                    <td class="home-displayData">{{ $card->medij }}</td>
                                    <td class="home-displayData">{{ $card->duznost }}</td>
                                    <td class="home-displayData">{{ $card->vazi_do }}</td>
                                    <td class="home-displayData">{{ $card->updated_at->format("d/m/y h:m") }}</td>
                                    <td>
                                        <a href="{{ route('viewProfile', $card->id) }}" target="_blank">Pregled</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            @endif
        
        
        </div>
    </div>
</div>
@endsection
