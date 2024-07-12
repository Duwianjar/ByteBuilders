@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

@endpush

@section('content')
    <div class="col-12 row">
        <h3 class="font-weight-bold text-gradient mb-2 my-das col-md-6">My Dahsboard </h3>
        <p class=" col-md-6 notes">Notes for {{ now()->startOfMonth()->format('j M Y') }} - {{ now()->endOfMonth()->format('j M Y') }}</p>
    </div>
    <div class="p-4 my-3 container-dashboard row">
        <div class="col-md-4 d-flex align-items-center">
            <img class="circle-image" src="{{ asset('assets/img/money.png') }}" alt="Money">
            <div class="ml-3">
                <p class="mb-0">Total Balance</p>
                <p class="mt-0">Rp. {{ number_format($balance, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="row col-md-8">

            <div class="col-6 d-flex align-items-center">
                <img class="circle-image" src="{{ asset('assets/img/earning.png') }}" alt="Money Earning">
                <div class="ml-3">
                    <p class="mb-0 ">Earning</p>
                    <p class="mt-0 text-success">Rp. {{ number_format($earning, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="col-6 d-flex align-items-center">
                <img class="circle-image" src="{{ asset('assets/img/expenses.png') }}" alt="Money Expenses" >
                <div class="ml-3">
                    <p class="mb-0 ">Expenses</p>
                    <p class="mt-0 text-danger">Rp. {{ number_format($expense, 0, ',', '.') }}</p>
                </div>
            </div>
            </div>
    </div>
    <div class="p-4 container-dashboard row d-lg-none d-block">
        <div class="col-12">
            <h4>Depository</h4>
        </div>
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show col-12" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @elseif(session('error'))
                <div class="alert alert-danger alert-dismissible fade show col-12" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row">
            @foreach($depositoried as $item)
                <a href="{{ url('depositories/' . $item->id) }}" class="bank m-2 py-1 px-2 text-white rounded" style="background: {{ $item->color }}; ">{{ $item->name }} Rp. {{ number_format($item->balance, 0, ',', '.') }}</a>
            @endforeach
                <a href="#" data-toggle="modal" data-target="#exampleModal"  class="bank m-2 py-1 px-2 text-white rounded btn btn-secondary" ><i class="fas fa-plus"></i> Add New</a>
            </div>
        </div>
    </div>
    <div class="p-4 container-dashboard row">
            <div class="col-md-4">
                <h4 class="m2">All Transaction</h4>
            </div>
            <div class="col-md-8 text-right">
                <a href="{{ route('dashboard.month', ['month' => 1]) }}" class="btn btn-secondary m-2">1 Month</a>
                <a href="{{ route('dashboard.month', ['month' => 3]) }}" class="btn btn-secondary m-2">3 Month</a>
                <a href="{{ route('dashboard.month', ['month' => 6]) }}" class="btn btn-secondary m-2">6 Month</a>
                <a href="{{ route('dashboard.month', ['month' => 12]) }}" class="btn btn-secondary m-2">1 Year</a>
            </div>
        <p class="not-mobile">Does not support mobile display, please use desktop or landscape mode</p>
        <div class="col-12">
            <canvas id="transactionChart"></canvas>
        </div>
    </div>



@endsection

@push('js')
<script>
        const months = {!! json_encode($months) !!};
        const earningsData = {!! json_encode($earningsData) !!};
        const expensesData = {!! json_encode($expensesData) !!};

        const ctx = document.getElementById('transactionChart').getContext('2d');
        const transactionChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Earning',
                        data: earningsData,
                        borderColor: 'green',
                        backgroundColor: 'rgba(0, 255, 0, 0.1)',
                        fill: true
                    },
                    {
                        label: 'Expenses',
                        data: expensesData,
                        borderColor: 'red',
                        backgroundColor: 'rgba(255, 0, 0, 0.1)',
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                // maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Earning and Expenses Chart'
                    }
                }
            }
        });
</script>

@endpush
