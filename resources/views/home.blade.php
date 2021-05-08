@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="/dodajIskaznicu" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <input type="text" id="imePrezime" name="imePrezime" placeholder="Upišite ime za pretragu..." /><br />

                            <input type="text" id="medij" name="medij" placeholder="Medij korisnika" /><br />

                            <input type="text" id="duznost" name="duznost" placeholder="Dužnost korisnika korisnika" /><br />

                            <input type="vazenje" id="vazenje" name="vazenje" value="{{ now()->format('Y-m-d') }}" min="{{ now()->format('Y-m-d') }}" /><br />

                            <input type="file" id="slika" name="image" /><br />

                            <input type="submit" value="Submit">
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
