@extends('layouts.back-end.app-seller')

@section('title', \App\CPU\translate('Profile Settings'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
@endpush

@section('content')
    <!-- Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">{{ \App\CPU\translate('Settings') }}</h1>
                </div>

                <div class="col-sm-auto">
                    <a class="btn btn-primary" href="{{ route('seller.dashboard.index') }}">
                        <i class="tio-home mr-1"></i> {{ \App\CPU\translate('Dashboard') }}
                    </a>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->

        <div class="row">
            <div class="col-lg-3">
                <!-- Navbar -->
                <div class="navbar-vertical navbar-expand-lg mb-3 mb-lg-5">
                    <!-- Navbar Toggle -->
                    <button type="button" class="navbar-toggler btn btn-block btn-white mb-3"
                        aria-label="Toggle navigation" aria-expanded="false" aria-controls="navbarVerticalNavMenu"
                        data-toggle="collapse" data-target="#navbarVerticalNavMenu">
                        <span class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0">{{ \App\CPU\translate('Nav menu') }}</span>

                            <span class="navbar-toggle-default">
                                <i class="tio-menu-hamburger"></i>
                            </span>

                            <span class="navbar-toggle-toggled">
                                <i class="tio-clear"></i>
                            </span>
                        </span>
                    </button>
                    <!-- End Navbar Toggle -->
                </div>
                <!-- End Navbar -->
            </div>

            <div class="col-12">

                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="card">
                            <div class="card-header"></div>
                            <div class="card-body">
                                <div class="text-center">
                                    <img id="viewer"
                                        onerror="this.src='{{ asset('assets/back-end/img/160x160/img1.jpg') }}'"
                                        src="{{ asset('storage/public/seller') }}/{{ $data->image }}"
                                        class="avatar-img img-fluid img-thumbnail mx-auto d-block"
                                        style="border-radius: 10px" width="100">
                                    <h2 class="pt-3 ">{{ $data->f_name }} {{ $data->l_name }}</h2>
                                    <p>
                                        {{ $data->email }} @if ($data->status == 'approved')
                                            <i class="fa fa-check-circle text-success"></i>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-12">
                        <div class="card" style="background: linear-gradient(to right, #a093c5 0%, #645cb3 100%)">
                            <div class="card-body">
                                <div>
                                    <h2 class="text-light">{{ \App\CPU\translate('balance') }}</h2>
                                    <h1 class="text-light" style="font-size: 40px">{{ number_format($data->wallet->total_earning) }}$</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-4">
                        <form action="{{ route('seller.profile.update', [$data->id]) }}" method="post"
                            enctype="multipart/form-data" id="seller-profile-form">
                            @csrf

                            <!-- Card -->
                            <div class="card mb-3 mb-lg-5">
                                <div class="card-header">
                                    <h2 class="card-title h4">{{ \App\CPU\translate('Basic') }}
                                        {{ \App\CPU\translate('information') }}</h2>
                                </div>

                                <!-- Body -->
                                <div class="card-body">
                                    <!-- Form -->
                                    <!-- Form Group -->
                                    <div class="row form-group">
                                        <label for="firstNameLabel"
                                            class="col-sm-3 col-form-label input-label">{{ \App\CPU\translate('Full') }}
                                            {{ \App\CPU\translate('name') }}
                                            <i class="tio-help-outlined text-body ml-1" data-toggle="tooltip"
                                                data-placement="top" title="Display name"></i></label>

                                        <div class="col-sm-9 row">
                                            <div class="col-md-6">
                                                <label for="name">{{ \App\CPU\translate('First') }}
                                                    {{ \App\CPU\translate('Name') }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="f_name" value="{{ $data->f_name }}"
                                                    class="form-control" id="name" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="name">{{ \App\CPU\translate('Last') }}
                                                    {{ \App\CPU\translate('Name') }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="l_name" value="{{ $data->l_name }}"
                                                    class="form-control" id="name" required>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form Group -->

                                    <!-- Form Group -->
                                    <div class="row form-group">
                                        <label for="phoneLabel"
                                            class="col-sm-3 col-form-label input-label mt-3">{{ \App\CPU\translate('Phone') }}
                                            <span
                                                class="input-label-secondary">({{ \App\CPU\translate('Optional') }})</span></label>

                                        <div class="col-sm-9"><small class="text-danger">( *
                                                {{ \App\CPU\translate('country_code_is_must') }}
                                                {{ \App\CPU\translate('like_for_BD_880') }} )</small>
                                            <input type="number" class="js-masked-input form-control" name="phone"
                                                id="phoneLabel" placeholder="+x(xxx)xxx-xx-xx"
                                                aria-label="+(xxx)xx-xxx-xxxxx" value="{{ $data->phone }}"
                                                data-hs-mask-options='{
                                                "template": "+(880)00-000-00000"
                                                }'>
                                        </div>
                                    </div>
                                    <!-- End Form Group -->

                                    <div class="row form-group">
                                        <label for="newEmailLabel"
                                            class="col-sm-3 col-form-label input-label">{{ \App\CPU\translate('Email') }}</label>

                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" name="email" id="newEmailLabel"
                                                value="{{ $data->email }}"
                                                placeholder="{{ \App\CPU\translate('Enter new email address') }}"
                                                aria-label="Enter new email address">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 col-form-label">
                                        </div>
                                        <div class="form-group col-md-9" id="select-img">
                                            <div class="custom-file">
                                                <input type="file" name="image" id="customFileUpload"
                                                    class="custom-file-input"
                                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                <label class="custom-file-label"
                                                    for="customFileUpload">{{ \App\CPU\translate('image') }}
                                                    {{ \App\CPU\translate('Upload') }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="button"
                                            onclick="{{ env('APP_MODE') != 'demo' ? "form_alert('seller-profile-form','Want to update seller info ?')" : 'call_demo()' }}"
                                            class="btn btn-primary">{{ \App\CPU\translate('Save changes') }}
                                        </button>
                                    </div>

                                    <!-- End Form -->
                                </div>
                                <!-- End Body -->
                            </div>
                            <!-- End Card -->
                        </form>
                    </div>

                    <div class="col-md-8 col-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Bar Chart -->
                                <div class="chartjs-custom">
                                    <canvas id="myChart" style="height: 20rem;"></canvas>
                                </div>
                                <!-- End Bar Chart -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-12">
                        <!-- Card -->
                        <div id="passwordDiv" class="card mb-3 mb-lg-5">
                            <div class="card-header">
                                <h4 class="card-title">{{ \App\CPU\translate('Change') }}
                                    {{ \App\CPU\translate('your') }} {{ \App\CPU\translate('password') }}</h4>
                            </div>

                            <!-- Body -->
                            <div class="card-body">
                                <!-- Form -->
                                <form id="changePasswordForm" action="{{ route('seller.profile.settings-password') }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf

                                    <!-- Form Group -->
                                    <div class="row form-group">
                                        <label for="newPassword" class="col-sm-3 col-form-label input-label">
                                            {{ \App\CPU\translate('New') }}
                                            {{ \App\CPU\translate('password') }}</label>

                                        <div class="col-sm-9">
                                            <input type="password" class="js-pwstrength form-control" name="password"
                                                id="newPassword"
                                                placeholder="{{ \App\CPU\translate('Enter new password') }}"
                                                aria-label="Enter new password"
                                                data-hs-pwstrength-options='{
                                                "ui": {
                                                    "container": "#changePasswordForm",
                                                    "viewports": {
                                                    "progress": "#passwordStrengthProgress",
                                                    "verdict": "#passwordStrengthVerdict"
                                                    }
                                                }
                                                }'>

                                            <p id="passwordStrengthVerdict" class="form-text mb-2"></p>

                                            <div id="passwordStrengthProgress"></div>
                                        </div>
                                    </div>
                                    <!-- End Form Group -->

                                    <!-- Form Group -->
                                    <div class="row form-group">
                                        <label for="confirmNewPasswordLabel" class="col-sm-3 col-form-label input-label">
                                            {{ \App\CPU\translate('Confirm') }}
                                            {{ \App\CPU\translate('password') }} </label>

                                        <div class="col-sm-9">
                                            <div class="mb-3">
                                                <input type="password" class="form-control" name="confirm_password"
                                                    id="confirmNewPasswordLabel"
                                                    placeholder="{{ \App\CPU\translate('Confirm your new password') }}"
                                                    aria-label="Confirm your new password">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form Group -->

                                    <div class="d-flex justify-content-end">
                                        <button type="button"
                                            onclick="{{ env('APP_MODE') != 'demo' ? "form_alert('changePasswordForm','Want to update admin password ?')" : 'call_demo()' }}"
                                            class="btn btn-primary">{{ \App\CPU\translate('Save changes') }}</button>
                                    </div>
                                </form>
                                <!-- End Form -->
                            </div>
                            <!-- End Body -->
                        </div>
                        <!-- End Card -->
                    </div>

                    <div class="col-md-8 col-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Bar Chart -->
                                <div class="chartjs-custom">
                                    <canvas id="BarChart" style="height: 20rem;"></canvas>
                                </div>
                                <!-- End Bar Chart -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sticky Block End Point -->
            <div id="stickyBlockEndPoint"></div>
        </div>
    </div>
    <!-- End Row -->
    </div>
    <!-- End Content -->
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
        const labels = [
            '{{ \App\CPU\translate('Paid') }}',
            '{{ \App\CPU\translate('Unpaid') }}',
        ];

        const data = {
            labels: labels,
            datasets: [{
                label: 'My First dataset',
                backgroundColor: ['#46eb34', '#eb344f'],
                data: [{{ $paid_order }}, {{ $unpaid_order }}],
            }]
        };

        const config = {
            type: 'doughnut',
            data: data,
            options: {}
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>
    <script>
        const labelss = [
            '{{ \App\CPU\translate('pending') }}',
            '{{ \App\CPU\translate('Processing') }}',
            '{{ \App\CPU\translate('confirmed') }}',
            '{{ \App\CPU\translate('delivered') }}',
            '{{ \App\CPU\translate('canceled') }}',
        ];

        const datas = {
            labels: labelss,
            datasets: [{
                label: '{{ \App\CPU\translate('Orders') }}',
                backgroundColor: [
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 226, 9, 0.5)',
                    'rgba(87, 255, 9, 0.5)',
                    'rgba(9, 255, 17, 0.5)',
                    'rgba(255, 9, 42, 0.5)',
                ],
                data: [
                    {{$pending_order}},
                    {{$processing_order}},
                    {{$confirmed_order}},
                    {{$delivered_order}},
                    {{$canceled_order}},
                ],
            }]
        };

        const configs = {
            type: 'bar',
            data: datas,
            options: {}
        };

        const myCharts = new Chart(
            document.getElementById('BarChart'),
            configs
        );
    </script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUpload").change(function() {
            readURL(this);
        });
    </script>

    <script>
        $("#generalSection").click(function() {
            $("#passwordSection").removeClass("active");
            $("#generalSection").addClass("active");
            $('html, body').animate({
                scrollTop: $("#generalDiv").offset().top
            }, 2000);
        });

        $("#passwordSection").click(function() {
            $("#generalSection").removeClass("active");
            $("#passwordSection").addClass("active");
            $('html, body').animate({
                scrollTop: $("#passwordDiv").offset().top
            }, 2000);
        });
    </script>
@endpush

@push('script')
@endpush
