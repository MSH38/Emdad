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

                    {{-- //// FORM /////  --}}

                    <div class="col "style="height:80vh ; overflow-y:scroll;  overflow-x: hidden;">

                        <div class="d-flex justify-content-center align-items-center">
                            <p class="p-0 m-0" style="font-size:2.5rem ; font-weight:800;">
                                {{ \App\CPU\translate('Start Selling on') }}</p>
                        </div>

                        <div class="d-flex justify-content-center p-0 m-0 align-items-center">
                            <div class="rounded-circle overflow-hidden p-0 m-0">
                            </div>
                            <span class="d-flex justify-content-center align-items-center gap-2" style="flex-direction: {{ Session::get('direction') === 'rtl' ? 'row' : 'row-reverse' }};">
                                <strong style="color:#800080 ;font-size:2.3rem; font-weight:bolder"> إمــداد</strong>
                                <p class="p-0 m-0"style="font-size:2rem  ; font-weight:800 ">{{ \App\CPU\translate('Today') }} </p>
                            </span>
                        </div>

                        <div class="card-body p-0 " style=" margin:0 80px ;">
                            <h2 class="fs-2 fw-bolder m-0 ">{{ \App\CPU\translate('Verification code') }}</h2>
                            <p class="fs-3 m-0">{{ \App\CPU\translate('enter the code') }}</p>
                            {{-- <hr class="mt-2"> --}}

                            <form class="needs-validation digit-group mt-4" data-group-name="digits" data-autosubmit="false"
                             autocomplete="off"  action="{{ route('customer.auth.login') }}"
                                method="post" id="form-id"style="flex-direction: {{ Session::get('direction') === 'rtl' ? 'row-reverse' : 'row' }};">
                                @csrf

                                <input type="text" id="digit-1" name="digit-1" data-next="digit-2" />
                                <input type="text" id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" />
                                <input type="text" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" />
                                <input type="text" id="digit-4" name="digit-4" data-next="digit-5" data-previous="digit-3" />

                                </form>


                                <div class="d-flex justify-content-center align-items-center gap-2 ">
                                    <p class="p-0 m-0"style="font-size:1rem  ; font-weight:800 ">{{ \App\CPU\translate('the code ends') }} </p>
                                    <i id="demo"></i>
                                </div>

                                <button class="btn btn-primary btn-block btn-shadow mt-4" type="submit"
                                    style="font-size: 1.5rem ;">{{ \App\CPU\translate('Create New ACC') }}
                                </button>
                                <hr>
                                <button class="btn btn-block btn-shadow"type="submit"
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

.digit-group{

    display: flex;
    justify-content: center;
    align-items: center;
    flex: row;
    margin: 10px 0 ;

}

.digit-group input {
		width: 5rem;
		height: 5rem;
		background-color: rgb(196, 193, 193);
		border: 1px solid #eee;
		line-height: 50px;
        padding: 5px;
        border-radius: 10px;
		text-align: center;
		font-size: 24px;
		font-family: 'Raleway', sans-serif;
		font-weight: 200;
		color: black;
		margin: 0 2px;

	}

    </style>



    {{-- /// TIMER //// --}}


    <script>
        // Set the date we're counting down to
        var countDownDate = new Date().getTime() + 180000;

        // Update the count down every 1 second
        var x = setInterval(function() {

          // Get today's date and time
          var now = new Date().getTime();

          // Find the distance between now and the count down date
          var distance = countDownDate - now;

          // Time calculations for days, hours, minutes and seconds
          var days = Math.floor(distance / (1000 * 60 * 60 * 24));
          var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
          var seconds = Math.floor((distance % (1000 * 60)) / 1000);

          // Display the result in the element with id="demo"
          document.getElementById("demo").innerHTML = "00:0" + minutes +":" + seconds ;

          // If the count down is finished, write some text
          if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "EXPIRED";
          }
        }, 1000);

    </script>


    <script>
        $('.digit-group').find('input').each(function() {
            $(this).attr('maxlength', 1);
            $(this).on('keyup', function(e) {
                var parent = $($(this).parent());

                if(e.keyCode === 8 || e.keyCode === 37) {
                    var prev = parent.find('input#' + $(this).data('previous'));

                    if(prev.length) {
                        $(prev).select();
                    }
                } else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
                    var next = parent.find('input#' + $(this).data('next'));

                    if(next.length) {
                        $(next).select();
                    } else {
                        if(parent.data('autosubmit')) {
                            parent.submit();
                        }
                    }
                }
            });
        });
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
