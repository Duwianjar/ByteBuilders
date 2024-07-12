<header>
<nav class="navbar navbar-expand-lg navbar-dark px-4">
    <a class="navbar-brand" href="{{ route('dashboard') }}">
        <img src="{{ asset('assets/icon/mw.png') }}" width="35" height="35" class="d-inline-block align-top" alt="mw Icon">
        <span id="text-brand" class="text-white">MoneyWise</span>
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link text-white mx-2" href="{{ route('dashboard') }}">Home</a>
            </li>
            @if(Auth::user()->role != "admin")
                <li class="nav-item">
                    <a class="nav-link text-white mx-2" href="{{ route('earning') }}">Earning</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white mx-2" href="{{ route('expenses') }}">Expenses</a>
                </li>
            @else
            <li class="nav-item dropdown ">
                <a class="nav-link dropdown-toggle text-white mx-2" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item" type="submit">Logout</button>
                    </form>
                </div>
            </li>
            @endif
        </ul>
    </div>
</nav>
</header>

