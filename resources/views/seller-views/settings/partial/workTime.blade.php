
@extends('layouts.back-end.app-seller')

@section('title', 'الاعدادات')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">الاعدادات</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-12">
                @include('seller-views.settings.sidebar')
            </div>
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>اختار الفرع</h3>
                        <select name="branche_id" class="form-control rounded-pill" style="width: 115px;">
                            <option value="" selected>اختر الفرع</option>
                            @foreach ($branches as $branche)
                                <option value="{{ $branche->id }}">{{ $branche->branche_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="card-body">
                        <div class="form-group d-flex justify-content-around">
                            <span>السبت</span>
                            <label class="switch">
                                <input type="checkbox" class="status">
                                <span class="slider round"></span>
                            </label>
                            <span>مفتوح من</span>
                            <input type="time" class="form-control w-25" name="from_time">
                            <span>الى</span>
                            <input type="time" class="form-control w-25" name="to_time">
                        </div>

                        <div class="form-group d-flex justify-content-around">
                            <span>الاحد</span>
                            <label class="switch">
                                <input type="checkbox" class="status">
                                <span class="slider round"></span>
                            </label>
                            <span>مفتوح من</span>
                            <input type="time" class="form-control w-25" name="from_time">
                            <span>الى</span>
                            <input type="time" class="form-control w-25" name="to_time">
                        </div>

                        <div class="form-group d-flex justify-content-around">
                            <span>الاثنين</span>
                            <label class="switch">
                                <input type="checkbox" class="status">
                                <span class="slider round"></span>
                            </label>
                            <span>مفتوح من</span>
                            <input type="time" class="form-control w-25" name="from_time">
                            <span>الى</span>
                            <input type="time" class="form-control w-25" name="to_time">
                        </div>

                        <div class="form-group d-flex justify-content-around">
                            <span>الثلاثاء</span>
                            <label class="switch">
                                <input type="checkbox" class="status">
                                <span class="slider round"></span>
                            </label>
                            <span>مفتوح من</span>
                            <input type="time" class="form-control w-25" name="from_time">
                            <span>الى</span>
                            <input type="time" class="form-control w-25" name="to_time">
                        </div>

                        <div class="form-group d-flex justify-content-around">
                            <span>الاربعاء</span>
                            <label class="switch">
                                <input type="checkbox" class="status">
                                <span class="slider round"></span>
                            </label>
                            <span>مفتوح من</span>
                            <input type="time" class="form-control w-25" name="from_time">
                            <span>الى</span>
                            <input type="time" class="form-control w-25" name="to_time">
                        </div>

                        <div class="form-group d-flex justify-content-around">
                            <span>الخميس</span>
                            <label class="switch">
                                <input type="checkbox" class="status">
                                <span class="slider round"></span>
                            </label>
                            <span>مفتوح من</span>
                            <input type="time" class="form-control w-25" name="from_time">
                            <span>الى</span>
                            <input type="time" class="form-control w-25" name="to_time">
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection
