@extends('layouts.adminApp')

@section('content')
    <div class="container container-dashboard p-lg-5">
        <div class="d-flex justify-content-between align-items-center mt-4">
            <h3 class="mb-0 text-gradient">Admin</h3>
            <a href="#" class="btn btn-secondary">Add New User</a>
        </div>
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
                    @php
                        $users = [
                            ['name' => 'John Doe', 'email' => 'john@example.com', 'role' => 'Admin', 'created_at' => '2023-01-15'],
                            ['name' => 'Jane Smith', 'email' => 'jane@example.com', 'role' => 'User', 'created_at' => '2023-02-20'],
                            ['name' => 'Mike Johnson', 'email' => 'mike@example.com', 'role' => 'Editor', 'created_at' => '2023-03-10'],
                            ['name' => 'Emily Davis', 'email' => 'emily@example.com', 'role' => 'User', 'created_at' => '2023-04-05']
                        ];
                    @endphp

                    @foreach ($users as $index => $user)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td>{{ $user['role'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($user['created_at'])->format('d-m-Y') }}</td>
                            <td>
                                <a href="#" class="btn btn-secondary btn-sm">Edit</a>
                                <form action="#" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
