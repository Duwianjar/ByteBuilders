@extends('layouts.adminApp')

@section('content')
    <div class="container container-dashboard p-lg-5">
        <div class="d-flex justify-content-between align-items-center mt-4">
            <h3 class="mb-0 text-gradient">Admin</h3>
            <a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#addUserModal">Add New User</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="table-responsive mt-3">
            <table class="table table-hover table-bordered">
                <thead class="thead-primary">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Tanggal Daftar</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td>{{ $user['role'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($user['created_at'])->format('d-m-Y') }}</td>
                            <td>
                                <a href="#" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#editUserModal{{ $user['id'] }}">Edit</a>
                                <form action="{{ route('admin.profile.destroy', $user['id']) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this profile?')">Delete</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit User Modal -->
                        <div class="modal fade" id="editUserModal{{ $user['id'] }}" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel{{ $user['id'] }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editUserModalLabel{{ $user['id'] }}">Edit User</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.users.update', $user['id']) }}" method="POST">
                                    {{-- <form action="" method="POST"> --}}
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="name">Nama:</label>
                                                <input id="name" type="text" class="form-control" name="name" value="{{ $user['name'] }}" required autofocus autocomplete="name">
                                                @error('name')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="email">Email:</label>
                                                <input id="email" type="email" class="form-control" name="email" value="{{ $user['email'] }}" required autocomplete="email">
                                                @error('email')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="password">Password:</label>
                                                <input id="password" type="password" class="form-control" name="password" minlength="8" autocomplete="new-password">
                                                @error('password')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="confirm_password">Confirm Password:</label>
                                                <input id="confirm_password" type="password" class="form-control" name="password_confirmation" minlength="8" autocomplete="new-password">
                                                @error('confirm_password')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Update User</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Edit User Modal -->
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add New User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama:</label>
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
                            <input id="password" type="password" class="form-control" name="password" minlength="8" required autocomplete="new-password">
                            @error('password')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirm Password:</label>
                            <input id="confirm_password" type="password" class="form-control" name="password_confirmation" minlength="8" required autocomplete="new-password">
                            @error('confirm_password')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
