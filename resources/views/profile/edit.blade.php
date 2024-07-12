

@extends('layouts.adminApp')


@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
@endpush
@section('content')


    <div class="col-12">
        <h2 class="font-weight-bold text-gradient mb-4">My Profile
        </h2>
    </div>
    <div class="mx-auto">
        <div class="p-4 container-profile">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="p-4 container-profile">
            @include('profile.partials.update-password-form')
        </div>

        <div class="p-4 container-profile">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
@endsection
