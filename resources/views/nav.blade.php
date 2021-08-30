<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
 
        

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav mr-auto">
                @auth
                <li class="nav-item">
                    <a class="nav-link navLink" href="/">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link navLink" href="{{ route("addCard") }}">Dodaj novu iskaznicu</a>
                </li>

                @if (auth()->user() && auth()->user()->role == 2)
                    <li class="nav-item">
                        <a class="nav-link navLink" href="{{ route("loadAddUser") }}">Dodaj novog administratora</a>
                    </li>
                @endif
                @endauth
            </ul>

        {{-- This is aligned right --}}
        <ul class="navbar-nav my-2 my-lg-0">
            @guest
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('getUserForEdit', auth()->user()->id) }}">Postavke profila</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            @endguest
            </ul>
    </div>
</nav>