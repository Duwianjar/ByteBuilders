@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/depository.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

@endpush
@section('content')

    <div class="col-12">
        <h2 class="font-weight-bold text-gradient mb-4">Depository
        </h2>
    </div>
    <div class="mx-auto">
        <div class="p-4 container-depository">
            @include('client.partials.update-depository')
        </div>

        <div class="p-4 container-depository">
            @include('client.partials.list-history')
        </div>

        <div class="p-4 container-depository">
            @include('client.partials.delete-depository')
        </div>
    </div>
@endsection

@push('js')
<script>
    document.getElementById('editButton').addEventListener('click', function() {
        var form = document.getElementById('editForm');
        if (form.classList.contains('d-hidden')) {
            form.classList.remove('d-hidden');
            form.classList.add('d-visible');
            setTimeout(() => form.classList.remove('d-fade'), 10);
        } else {
            form.classList.add('d-fade');
            form.addEventListener('transitionend', () => {
                form.classList.remove('d-visible');
                form.classList.add('d-hidden');
            }, { once: true });
        }
    });
</script>
@endpush
