@extends('layouts.back-end.app-seller')

@section('title', \App\CPU\translate('Withdraw Request'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('seller.dashboard.index')}}">{{\App\CPU\translate('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('Withdraw')}}  </li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-body">

                <div class="chartjs-custom">
                    <canvas id="LineChart" style="height: 20rem;"></canvas>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h1>المعاملات المالية</h1>
            </div>
            <div class="card-body">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-12">
                                <h2>22 ريال</h2>
                            </div>
                            <div class="col-lg-10 col-md-10 col-12">
                                <h3>معاملة بيع منتج جديد</h3>
                                <span>
                                    <i class="fa fa-clock"></i>
                                    12/7/2022
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-12">
                                <h2>22 ريال</h2>
                            </div>
                            <div class="col-lg-10 col-md-10 col-12">
                                <h3>معاملة بيع منتج جديد</h3>
                                <span>
                                    <i class="fa fa-clock"></i>
                                    12/7/2022
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-12">
                                <h2>22 ريال</h2>
                            </div>
                            <div class="col-lg-10 col-md-10 col-12">
                                <h3>معاملة بيع منتج جديد</h3>
                                <span>
                                    <i class="fa fa-clock"></i>
                                    12/7/2022
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!-- /.row -->


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
    const labelss = ['اجل','نقد','مرتجع','محفظة','عمولات المنصة'];

    const datas = {
        labels: labelss,
        datasets: [
            {
                label: 'المبيعات اليومية',
                data: [300, 50, 100,55,44],
                backgroundColor: [
                    'rgb(54, 162, 235)',
                    'rgb(93, 245, 66)',
                    'rgb(255, 99, 132)',
                    'rgb(245, 233, 66)',
                    'rgb(66, 114, 245)',
                ],
            },
        ]
    };
    const configs = {
        type: 'doughnut',
        data: datas,
    };

    const myCharts = new Chart(
            document.getElementById('LineChart'),
            configs
    );

    </script>

  <script>
      function status_filter(type) {
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.post({
              url: '{{route('seller.business-settings.withdraw.status-filter')}}',
              data: {
                  withdraw_status_filter: type
              },
              beforeSend: function () {
                  $('#loading').show()
              },
              success: function (data) {
                 location.reload();
              },
              complete: function () {
                  $('#loading').hide()
              }
          });
      }
  </script>

  <script>
      function close_request(route_name) {
          swal({
              title: "{{\App\CPU\translate('Are you sure?')}}",
              text: "{{\App\CPU\translate('Once deleted, you will not be able to recover this')}}",
              icon: "{{\App\CPU\translate('warning')}}",
              buttons: true,
              dangerMode: true,
          })
              .then((willDelete) => {
                  if (willDelete) {
                      window.location.href = (route_name);
                  }
              });
      }
  </script>
@endpush
