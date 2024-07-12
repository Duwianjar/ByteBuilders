@extends('layouts.app')

@push('css')
    
@endpush

@section('content')

<div class="container-dashboard">
    <h4 class="font-weight-bold text-gradient">Earnings</h4>
    <div>
        <canvas id="expenseChart" width="400" height="400"></canvas>
    </div>
</div>
<div class="container-dashboard">
    <h4 class="font-weight-bold text-gradient">Detail Earnings</h4>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Depository</th>
                <th>Category</th>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @php
                $page = request()->get('page', 1);
                $no = ($page - 1) * $earnings->perPage() + 1;
            @endphp
            @foreach ($earnings as $earning)
                <tr>
                    <td>{{ $no++ }}</td> 
                    <td>{{ $earning->depository->name }}</td> 
                    <td>{{ $earning->category->nama }}</td>
                    <td>{{ $earning->description }}</td>
                    <td>{{ $earning->amount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination">
        {{ $earnings->links() }}
    </div>
</div>

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var data = {
                labels: @json($chartData['labels']),
                datasets: [{
                    data: @json($chartData['data']),
                    backgroundColor: @json($chartData['backgroundColor'])
                }]
            };

            var options = {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'top'
                }
            };

            var ctx = document.getElementById('expenseChart').getContext('2d');
            var myPieChart = new Chart(ctx, {
                type: 'pie',
                data: data,
                options: options
            });
        });
    </script>
    <script>
        function findAndHideElement() {
            const hiddenElement = document.querySelector('.hidden');
            if (hiddenElement) {
                hiddenElement.classList.add('d-none');
                clearInterval(interval); 
            }
        }
    
        const interval = setInterval(findAndHideElement, 10); 
    </script>
@endpush
