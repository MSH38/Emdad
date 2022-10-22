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
                    onerror="this.src='{{ asset('assets/back-end/img/400x400/img2.jpg') }}'" style="width: 5rem">
                    --}}

                    <span class="d-flex justify-content-center align-items-center gap-2"
                        style="flex-direction: {{ Session::get('direction') === 'rtl' ? 'row' : 'row-reverse' }};">
                        <strong class="fw-bolder fs-1" style="color:#800080;">إمــداد</strong>
                        <h1 class="fw-bolder">Seller Hub </h1>
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
        <div class="row">
            <div class="col-4">
                <div class="card o-hidden border-0 shadow-lg" style=" ; background:transparent ; border-radius: 20px ;">
                    <div class="card-body p-0 m-0  position-relative "
                        style="background:transparent ; border-radius: 20px ;">
                        <div class="position-sticky w-100 h-50  d-flex justify-content-around align-items-center flex-column gap-1"
                            style="height:80vh ;">
                            <h2 class="fs-2 fw-bolder " style="width:80%;">{{ \App\CPU\translate('register steps') }}</h2>

                            <div class="progress" style="width:80%">
                                <div class="progress-bar progress-bar-success bg-Success" role="progressbar" aria-valuenow="40"
                                    aria-valuemin="0" aria-valuemax="100" style="width:67%">
                                </div>
                            </div>

                            <h2 class="fs-5" style="width:80%; ">2/3 {{ \App\CPU\translate('complete') }} </h2>

                            <div class="" style="width:80%">
                                <span class="d-flex gap-2">
                                    <i class="fa-solid fa-circle-check text-success" style="line-height:2"></i>
                                    <h2 class="fs-4  text-secondary">{{ \App\CPU\translate('trade info') }}</h2>
                                </span>
                            </div>
                            <div class="" style="width:80%">
                                <span class="d-flex gap-2">
                                    <i class="fa-solid fa-circle-check text-success" style="line-height:2"></i>
                                    <h2 class="fs-4 text-secondary ">{{ \App\CPU\translate('legal info') }}</h2>
                                </span>
                            </div>
                            <div class="" style="width:80%">
                                <span class="d-flex gap-2">
                                    <div class="lds-ring" style="background: color:#800080; color:color:#800080">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                    <h2 class="fs-4 " style="color:#800080">
                                        {{ \App\CPU\translate('category and products') }}</h2>
                                </span>
                            </div>



                        </div>
                    </div>
                </div>
            </div>

            {{-- ///// FORM //////////// --}}

            <div class="col-8">
                <div class="card o-hidden border-0 shadow-lg" style=" ; background:transparent ; border-radius: 20px ;">
                    <div class="card-body p-0 m-0  overflow-hidden " style="background:transparent ; border-radius: 20px ;">
                        <div class="" style="height:80vh ; overflow-y:scroll;  overflow-x: hidden;">
                            <div class="card-body p-0 " style=" margin:0 80px ;">
                                <h2 class="fs-2 fw-bolder m-0 mt-2  ">{{ \App\CPU\translate('category and products') }}
                                </h2>
                                {{-- <hr class="mt-2"> --}}

                                <form class="needs-validation digit-group mt-4" data-group-name="digits"
                                    data-autosubmit="false" autocomplete="off" action="{{ route('customer.auth.login') }}"
                                    method="post"
                                    id="form-id"style="flex-direction: {{ Session::get('direction') === 'rtl' ? 'row-reverse' : 'row' }};">
                                    @csrf


                                    <div class="row justify-content-center gap-3">
                                        @foreach ($all_cats as $key => $val)
                                            <div class="col col-5 rounded p-2" style="background: #eee">
                                                <h3 class="">{{ $val->name }}</h3>
                                                <div class=" me-2 row row-cols-3 ">
                                                    @foreach ($val->childes as $item)
                                                        <span class="fom-check p-0 m-0 ">
                                                            <input class="p-0 m-0  form-check-input" type="checkbox"
                                                                value="{{ $item->name }}" id="{{ $item->id }}">
                                                            <label class="p-0 m-0  form-check-label me-4"
                                                                for="{{ $item->id }}">
                                                                {{ $item->name }}
                                                            </label>
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <hr>


                                    <div class="col-md-12 col-12">

                                        <div class="form-group p-0 m-0">
                                            <label style="font-size: 1.3rem" class="input-label fw-bolder" for="cats_list">قم بتحميل قائمة المنتجات الخاصة بك </label>
                                            <input type="file" name="cats_list" class="form-control"id="cats_list" required>
                                        </div>

                                    </div>



                                    <div class="d-flex justify-content-around align-items-center  gap-2 mt-3 "
                                        style="flex-direction: {{ Session::get('direction') === 'rtl' ? 'row' : 'row-reverse' }};">

                                        <button class="btn btn-shadow "type="submit"
                                            style="font-size: 1.5rem ;background: rgb(172, 171, 171) ; color:white ;">
                                            {{ \App\CPU\translate('previous') }}
                                        </button>

                                        <button class="btn btn-primary  btn-shadow px-3" type="submit"
                                            style="font-size: 1.5rem ;">{{ \App\CPU\translate('next') }}
                                        </button>
                                    </div>
                                </form>



                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>

@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />


<style>
    .lds-ring {
        display: inline-block;
        position: relative;
        width: 20px;
        height: 20px;
    }

    .lds-ring .stop {
        box-sizing: border-box;
        display: block;
        position: absolute;
        width: 16px;
        height: 16px;
        margin: 3px;
        border: 3px solid grey;
        border-radius: 50%;
    }

    .lds-ring div {
        box-sizing: border-box;
        display: block;
        position: absolute;
        width: 16px;
        height: 16px;
        margin: 3px;
        border: 3px solid grey;
        border-radius: 50%;
        animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        border-color: grey transparent transparent transparent;
    }

    .lds-ring div:nth-child(1) {
        animation-delay: -0.45s;
    }

    .lds-ring div:nth-child(2) {
        animation-delay: -0.3s;
    }

    .lds-ring div:nth-child(3) {
        animation-delay: -0.15s;
    }

    @keyframes lds-ring {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
.filepond--item {
    color: red
}
</style>




<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>




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

    <script>


document.onload = ()=>{
    var file  = document.querySelector(".filepond--label-action");

    console.log(file)

}





        const inputElement = document.querySelector('input[type="file"]');
        const pond = FilePond.create(inputElement);

        create(inputElement, {
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    /* store file somewhere and call `load` when done */
                },
            },
        });




        function getRequest(route, id, type) {
            $.get({
                url: route,
                dataType: 'json',
                success: function(data) {
                    if (type == 'select') {
                        $('#' + id).empty().append(data.select_tag);
                    }
                },
            });
        }
    </script>

@endpush
