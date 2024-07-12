<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MoneyWise - Register</title>
<link rel="icon" type="image/x-icon" href="{{ asset('assets/icon/mw.png') }}">

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">

</head>
<body class="d-flex align-items-center justify-content-center">

<div class="container">
    <div class="row">
        <div class="col-lg-6 ">
            <img src="{{ asset('assets/img/auth.png') }}" alt="MoneyWise App" class="img-fluid">
        </div>
        <div class="col-lg-6">
            <div class="form-container">
                <h1 class="form-title">Register</h1>
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input id="name" type="text" class="form-control" name="name" required autofocus autocomplete="name">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input id="email" type="email" class="form-control" name="email" required autocomplete="email">
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                        @error('password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password:</label>
                        <input id="confirm_password" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        @error('confirm_password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-ungu btn-block">Register</button>

                    <p>Already have an account? <a href="{{ route('login') }}">Log in here</a></p>
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
