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
                                            <p class="newCardHeader">Pretraga Administratora</p>

                                            <span class="home-radio">
                                                <label for="user-byName">
                                                    <input type="radio" name="searchParametersUser" id="user-byName" value="user-byName" checked>
                                                    Po imenu
                                                </label>
                                            </span>

                                            <span class="home-radio">
                                                <label for="user-byEmail">
                                                    <input type="radio" name="searchParametersUser" id="user-byEmail" value="user-byEmail">
                                                    Po mailu
                                                </label>
                                            </span>

                                            <span class="home-radio">
                                                <label for="user-byRole">
                                                    <input type="radio" name="searchParametersUser" id="user-byRole" value="user-byRole">
                                                    Po nivou dopuštenja/ulozi
                                                </label>
                                            </span>

                                        </div>

                                        <div class="col-sm searchCards">
                                            <p class="newCardHeader">Pretraga Iskaznica</p>

                                            <span class="home-radio">
                                                <label for="card-byName">
                                                    <input type="radio" name="searchParametersUser" id="card-byName" value="card-byName">
                                                    Po imenu
                                                </label>
                                                
                                            </span>

                                            <span class="home-radio">
                                                <label for="card-byNumber">
                                                    <input type="radio" name="searchParametersUser" id="card-byNumber" value="card-byNumber">
                                                    Po broju iskaznice
                                                </label>
                                            </span>

                                            <span class="home-radio">
                                                <label for="card-byUuid">
                                                    <input type="radio" name="searchParametersUser" id="card-byUuid" value="card-byUuid">
                                                    Po ID-u iskaznice
                                                </label>
                                            </span>

                                            <span class="home-radio">
                                                <label for="card-byAddedBy">
                                                   <input type="radio" name="searchParametersUser" id="card-byAddedBy" value="card-byAddedBy">
                                                   Po ID-u korisnika
                                                </label>
                                            </span>


                                            @if (Auth::user() && Auth::user()->role > 1)
                                                <br />
                                                <label for="searchForDeletedCards">
                                                    <input type="checkBox" name="searchForDeletedCards" id="searchForDeletedCards" value="searchForDeletedCards">
                                                    Pretraži izbrisane iskaznice
                                                </label>
                                            @endif
                                        </div>

                                    </div>
                                  </div>
                                <br />

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
                                <td>ID administratora</td>
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
                                    <td class="home-displayData">{{ $user->updated_at->format("d/m/y H:i") }}</td>
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
                                    <td class="home-displayData">{{ $card->updated_at->format("d/m/y H:i") }}</td>
                                    <td>
                                        <a href="{{ route('viewProfile', $card->ID_iskaznice) }}" target="_blank">Pregled</a>
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
