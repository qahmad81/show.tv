<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">

        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('img/logo.png') }}" alt="">
        </a>

            



        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent"  style="position: relative;">


        <nav class="navbar navbar-light" style="position: absolute; top: -5px;">
          <form class="form-inline" action="{{ url('search') }}">
            @csrf
            <input class="form-control mr-sm-2" type="search" name="search" placeholder="{{ __('Search in Episodes')}}"
                @if(isset($searchword)) value="{{$searchword}}" @endif aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">{{ __('Search')}}</button>
          </form>
        </nav>

            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto" style="position: absolute;top: 45px;">
        @auth
        @if (Auth::id() == 1)
        <a class="navbar" href="{{ route('series.index') }}">
            {{ __('Series') }}
        </a>
        <a class="navbar" href="{{ route('episodes.index') }}">
            {{ __('Episodes') }}
        </a>
        <a class="navbar" href="{{ url('user') }}">
            {{ __('Users') }}
        </a>
        @else


        @endif
        @endauth

        @if(isset($menuSerieses)&&Auth::id() != 1)
        @foreach($menuSerieses as $series)
        <a class="navbar" href="{{ route('series.show',$series->id) }}">
            {{ $series->title }}
        </a>
        @endforeach
        @endif

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img src="{{ Storage::disk('users')->url(Auth::user()->image) }}" 
                            style="border-radius: 50px;border: 2px solid green;" width="64">
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>

    </div>
</nav>
