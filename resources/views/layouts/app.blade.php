<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>MoneyWise</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/icon/mw.png') }}">

        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
        @stack('css')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen ">
            @include('layouts.navigation')

            <main>
            <div class="row px-5 py-4">
                <div class="col-lg-8">
                    @yield('content')
                </div>
                <div class="col-lg-4 container-dashboard text-center aside-profile">
                    @include('layouts.aside')
                </div>

                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add New Depository</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('depositories.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter depository name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="information">Information</label>
                                        <input type="text" class="form-control" id="information" name="information" placeholder="Enter information" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="color">Color</label>
                                        <input type="color" class="form-control" id="color" name="color" value="#ff0000">
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                                </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="editPhotoModal" tabindex="-1" role="dialog" aria-labelledby="editPhotoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content mb-5">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editPhotoModalLabel">Edit Foto Profil</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center mb-5">
                                @if (Auth::user()->photo != null)
                                    <img src="{{ asset(Auth::user()->photo) }}" alt="user" class="img-fluid rounded-circle mb-3" id="currentPhoto" style="width: 250px; height: 250px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('assets/img/user.png') }}" alt="user" class="img-fluid rounded-circle mb-3" id="currentPhoto" style="width: 250px; height: 250px; object-fit: cover;">
                                @endif
                                <form id="editForm" action="{{ route('users.update.photo', ['id' => Auth::user()->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="newPhoto">Pilih Foto Baru:</label>
                                        <input type="file" class="form-control bg-secondary text-white" id="newPhoto" name="newPhoto" accept="image/*">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </main>
        </div>
    </body>
    @stack('js')
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</html>
