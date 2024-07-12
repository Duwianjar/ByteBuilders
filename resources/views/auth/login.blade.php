<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MoneyWise - Login</title>
<link rel="icon" type="image/x-icon" href="{{ asset('assets/icon/mw.png') }}">

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">

</head>
<body class="d-flex align-items-center justify-content-center">

<div class="container">
    <div class="row">
        <div class="col-lg-6 ">
            <img src="{{ asset('assets/img/login.png') }}" alt="MoneyWise App" class="img-fluid">
        </div>
        <div class="col-lg-6 mt-5">
            <div class="form-container mt-5">
                <h1 class="form-title">Login</h1>
                <div class="mb-4">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div>
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="username" autofocus>
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    @if (Route::has('password.request'))
                    <a class="d-block mt-2 text-right text-secondary" href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>

                    @endif

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-ungu btn-block">Login</button>
                    </div>
                    <p>Don't have an account? <a href="{{ route('register') }}">Sign up here.</a></p>


                </form>

            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-CZwr4zVuM9vMpcJCCGjzBCDVPtLarLkZMg/yD2j2MR5J1Y4U3QCzqYwTCtJlSGI/" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-+0n0xVW2eSR5Lqk5KA7w5fjMouJwMmwZym0kqjv0r6h7Z1KS7xfovrFNYuw3hwpH" crossorigin="anonymous"></script>
</body>
</html>

