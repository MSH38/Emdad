@extends('seller-views.partials.app_for_seller')

@section('title', \App\CPU\translate('Seller Apply'))


@push('css_or_js')
    <link href="{{ asset('assets/back-end') }}/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/back-end/css/croppie.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush


@section('content')

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid rtl "style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};">

            @php($logo = \App\Model\BusinessSetting::where(['type' => 'company_web_logo'])->first()->value)

            <div class="container d-flex justify-content-between">


                <a class="navbar-brand rounded-circle p-2 overflow-hidden d-flex justify-content-center align-items-center "
                    href="#">
{{--
                    <img class="z-index-2" src="{{ asset('storage/public/company/' . $logo) }}" alt="Logo"
                    onerror="this.src='{{ asset('assets/back-end/img/400x400/img2.jpg') }}'" style="width: 5rem"> --}}
                    <span class="d-flex justify-content-center align-items-center gap-2" style="flex-direction: {{ Session::get('direction') === 'rtl' ? 'row' : 'row-reverse' }};">
                        <strong class="fw-bolder fs-1" style="color:#800080;">إمــداد</strong>
                        <h1 class="fw-bolder" >Seller Hub </h1>
                    </span>
                </a>

                <div>
                    @php($local = \App\CPU\Helpers::default_lang())
                    <div class="topbar-text dropdown disable-autohide  text-capitalize">
                        <a class="topbar-link dropdown-toggle" href="#" data-toggle="dropdown">
                            @foreach (json_decode($language['value'], true) as $data)
                                @if ($data['code'] == $local)
                                    <img class="{{ Session::get('direction') === 'rtl' ? 'ml-2' : 'mr-2' }}" width="20"
                                        src="{{ asset('assets/front-end') }}/img/flags/{{ $data['code'] }}.png"
                                        alt="Eng">
                                    {{ $data['name'] }}
                                @endif
                            @endforeach
                        </a>
                        <ul class="dropdown-menu dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'right' : 'left' }}"
                            style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};">
                            @foreach (json_decode($language['value'], true) as $key => $data)
                                @if ($data['status'] == 1)
                                    <li>
                                        <a class="dropdown-item pb-1" href="{{ route('lang', [$data['code']]) }}">
                                            <img class="{{ Session::get('direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"
                                                width="20"
                                                src="{{ asset('assets/front-end') }}/img/flags/{{ $data['code'] }}.png"
                                                alt="{{ $data['name'] }}" />
                                            <span style="text-transform: capitalize">{{ $data['name'] }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </nav>

    <div class="container main-card rtl"
        style="height:50vh  margin:0 10% text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }}">

        <div class="card o-hidden border-0 shadow-lg" style=" ; background:transparent ; border-radius: 20px ;">
            <div class="card-body p-0 m-0  overflow-hidden " style="background:transparent ; border-radius: 20px ;">
                <!-- Nested Row within Card Body -->
                <div class="row ">
                    <div class="col position-relative m-0 p-0 d-none d-lg-block" style="height:80vh">
                        <img src="{{ asset('assets/images/delivery-man.jpg') }}" style="background-image: cover"
                            width="100%" alt="">

                        <div class="position-absolute top-0 w-100 h-100" style="background: #1c531659"></div>

                        <span class="position-absolute w-100 top-0  mt-5" style="right:-5%">
                            <img width="100%" height="100%" src="{{ asset('assets/images/flags/blob.svg') }}"
                                style="opacity: .5;
                            transform: rotateZ(-80deg);" alt="">
                        </span>

                        <div class="position-absolute top-0 w-100 h-100 d-flex flex-column justify-content-end align-items-center pb-5 "
                            style="background: transparent ; z-index:1 ;">
                            <h1 class="text-white" style="font-weight:bolder ; font-size:4rem">
                                {{ \App\CPU\translate('image words') }}</h1>
                            <p class="text-white fs-4 " style="width: 80%"> {{ \App\CPU\translate('image words p') }}</p>
                        </div>

                    </div>

                    <div class="col "style="height:80vh ; overflow-y:scroll;  overflow-x: hidden;">

                        <div class="d-flex justify-content-center align-items-center">
                            <p class="p-0 m-0" style="font-size:2.5rem ; font-weight:800;">
                                {{ \App\CPU\translate('Start Selling on') }}</p>
                        </div>

                        <div class="d-flex justify-content-center p-0 m-0 align-items-center">

                            <div class="rounded-circle overflow-hidden p-0 m-0">
{{--
                                <img class="z-index-2" src="{{ asset('storage/public/company/' . $logo) }}" alt="Logo"
                                    onerror="this.src='{{ asset('assets/back-end/img/400x400/img2.jpg') }}'"
                                    style="width: 4rem"> --}}
                            </div>

                            <span class="d-flex justify-content-center align-items-center gap-2" style="flex-direction: {{ Session::get('direction') === 'rtl' ? 'row' : 'row-reverse' }};">
                                <strong style="color:#800080 ;font-size:2.3rem; font-weight:bolder"> إمــداد</strong>
                                <p class="p-0 m-0"style="font-size:2rem  ; font-weight:800 ">{{ \App\CPU\translate('Today') }} </p>
                            </span>

                        </div>

                        <div class="card-body p-0 " style=" margin:0 80px ;">
                            <h2 class="fs-2 fw-bolder m-0 ">{{ \App\CPU\translate('Create Acc') }}</h2>
                            <p class="fs-2 m-0">{{ \App\CPU\translate('Create Acc p') }}</p>
                            {{-- <hr class="mt-2"> --}}
                            <form class="needs-validation " autocomplete="off" action="{{ route('seller.auth.phone_verify') }}"
                                method="post" id="form-id">
                                @csrf

                                <div class="form-group ">
                                    <label for="reg-fn"
                                        style="font-size: 1.5rem">{{ \App\CPU\translate('user name') }}</label>
                                    <input class="form-control" value="{{ old('full-name') }}" type="text"
                                        name="full-name"
                                        style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};"
                                        required>
                                    <div class="invalid-feedback">{{ \App\CPU\translate('Please enter your full name') }}!
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email"
                                        style="font-size: 1.5rem">{{ \App\CPU\translate('Email') }}</label>
                                    <input class="form-control" type="email" name="email" id="email"
                                        style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};"
                                        value="{{ old('email') }}" required>
                                    <div class="invalid-feedback">
                                        {{ \App\CPU\translate('please_provide_valid_email_or_phone_number') }}
                                        .
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <div class="row justify-content-center align-items-center ">
                                        <div class="col-8">

                                            <label for="reg-phone"
                                                style="font-size: 1.5rem">{{ \App\CPU\translate('phone_number') }}</label>
                                            <input class="form-control w-100" type="number" value="{{ old('phone') }}"
                                                name="phone"
                                                style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};"
                                                required>
                                            <div class="invalid-feedback">
                                                {{ \App\CPU\translate('Please enter your phone number') }}!
                                            </div>

                                        </div>

                                        <div class="col-4">

                                            <label for=""
                                                style="font-size: 1.5rem">{{ \App\CPU\translate('Choose Country') }}</label>
                                            <select class="form-select form-select-lg m-0"
                                                aria-label="Default select example">

                                                <option class="fs-5" selected style="font-size: 1.5rem ; padding:5px"
                                                    value="1">{{ \App\CPU\translate('yemen') }} +967</option>
                                                {{-- <option class="fs-5"style="font-size: 1.5rem" value="2"><img src="C:\Users\SanDBaG\Downloads\Chrome\imdad\public\assets\images\flags\saudi-arabia.svg" alt=""></option> --}}

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-primary btn-block btn-shadow" type="submit"
                                    style="font-size: 1.5rem ;">{{ \App\CPU\translate('Create New ACC') }}
                                </button>
                                <hr>
                                <button class="btn  btn-block btn-shadow"type="submit"
                                    style="font-size: 1.5rem ;background: rgb(172, 171, 171) ; color:white">
                                    {{ \App\CPU\translate('Alredy Have ACC') }}
                                </button>
                            </form>
                        </div>


                    </div>


                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')

    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}', Error, {
                    CloseButton: true,
                    ProgressBar: true
                });
            @endforeach
        </script>
    @endif



    <style>



    </style>
    .text{

    }

    <script>
        $('#inputCheckd').change(function() {
            // console.log('jell');
            if ($(this).is(':checked')) {
                $('#apply').removeAttr('disabled');
            } else {
                $('#apply').attr('disabled', 'disabled');
            }

        });

        $('#exampleInputPassword ,#exampleRepeatPassword').on('keyup', function() {
            var pass = $("#exampleInputPassword").val();
            var passRepeat = $("#exampleRepeatPassword").val();
            if (pass == passRepeat) {
                $('.pass').hide();
            } else {
                $('.pass').show();
            }
        });
        $('#apply').on('click', function() {

            var image = $("#image-set").val();
            if (image == "") {
                $('.image').show();
                return false;
            }
            var pass = $("#exampleInputPassword").val();
            var passRepeat = $("#exampleRepeatPassword").val();
            if (pass != passRepeat) {
                $('.pass').show();
                return false;
            }


        });

        function Validate(file) {
            var x;
            var le = file.length;
            var poin = file.lastIndexOf(".");
            var accu1 = file.substring(poin, le);
            var accu = accu1.toLowerCase();
            if ((accu != '.png') && (accu != '.jpg') && (accu != '.jpeg')) {
                x = 1;
                return x;
            } else {
                x = 0;
                return x;
            }
        }

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

        function readlogoURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewerLogo').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readBannerURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewerBanner').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#LogoUpload").change(function() {
            readlogoURL(this);
        });
        $("#BannerUpload").change(function() {
            readBannerURL(this);
        });
    </script>

@endpush
