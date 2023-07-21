<nav class="navbar navbar-expand-lg bg-white py-3">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('assets/images/logo/header.png') }}" alt="I-maintenance" width="80%" height="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('calculator-oee') ? 'text-primary' : '' }}"
                        aria-current="page" href="{{ route('calculator-oee') }}">OEE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('calculator-rbm') ? 'text-primary' : '' }}"
                        href="{{ route('calculator-rbm') }}">RBM</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('calculator-lcc') ? 'text-primary' : '' }}"
                        href="{{ route('calculator-lcc') }}">LCC</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('aboutUs') ? 'text-primary' : '' }}"
                        href="{{ route('aboutUs') }}">About Us</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                @if (Route::has('login'))
                <li class="nav-item me-2">
                    <a class=" btn btn-primary" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @endif

                @if (Route::has('register'))
                <li class="nav-item">
                    <a class=" btn btn-outline-primary px-3" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('dashboard') }}">
                            Dashboard
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
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
    </div>
</nav>
