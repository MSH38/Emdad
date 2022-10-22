@extends('layouts.back-end.app-seller')
@section('title', 'الاداء')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <div class="row align-items-center mb-3">
            <div class="col-sm">
                <h1 class="page-header-title">الاداء</h1>
            </div>
        </div>
        <div class="row" style="margin-top: 20px">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="chartjs-custom">
                            <canvas id="LineChart" style="height: 20rem;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script src="{{ asset('assets/back-end') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('assets/back-end') }}/vendor/chart.js.extensions/chartjs-extensions.js"></script>
    <script
        src="{{ asset('assets/back-end') }}/vendor/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js">
    </script>
@endpush
@push('script_2')
    <script>
        const labelss = [
            @foreach ($product_count as $product)
            '{{$product["name"]}}',
            @endforeach
        ];

        const datas = {
            labels: labelss,
            datasets: [{
                label: 'اداء المنتجات',
                data: [
                    @foreach ($product_count as $product)
                    '{{$product["count"]}}',
                    @endforeach
                ],
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            },
        ]
        };

        const configs = {
            type: 'line',
            data: datas,
            options: {}
        };

        const myCharts = new Chart(
            document.getElementById('LineChart'),
            configs
        );
    </script>

@endpush
