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
            </div>
        </div>

    </div>

@endsection
