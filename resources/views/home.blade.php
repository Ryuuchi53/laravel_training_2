@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body text-center">
                        <div>
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('myChart');

        const chartData = {
            labels: @json(isset($data) ? $data->map(fn($item) => $item->color) : []),
            datasets: [{
                label: 'Color',
                backgroundColor: @json(isset($data) ? $data->map(fn($item) => $item->color) : []),
                borderColor: @json(isset($data) ? $data->map(fn($item) => $item->color) : []),
                data: @json(isset($data) ? $data->map(fn($item) => $item->year) : [])
            }]
        };

        new Chart(ctx, {
            type: 'pie',
            data: chartData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>