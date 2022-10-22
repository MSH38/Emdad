@extends('layouts.back-end.app-seller')
@section('title', \App\CPU\translate('Shop view'))
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h3 mb-0  ">{{\App\CPU\translate('my_shop')}} {{\App\CPU\translate('Info')}} </h3>
                    </div>
                    <div class="card-body">
                        <div class="row mt-2">
                            @if($shop->image=='def.png')
                                <div class="col-md-3 text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                                    <img height="200" width="200" class="rounded-circle border"
                                         onerror="this.src='{{asset('assets/front-end/img/image-place-holder.png')}}'"
                                         src="{{asset('assets/back-end')}}/img/shop.png">
                                </div>
                            @else
                                <div class="col-md-3 text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                                    <img src="{{asset('storage/public/shop/'.$shop->image)}}"
                                         onerror="this.src='{{asset('assets/front-end/img/image-place-holder.png')}}'"
                                         class="rounded-circle border"
                                         height="200" width="200" alt="">
                                </div>
                            @endif


                            <div class="col-md-4 mt-4">
                                <div class="flex-start">
                                    <h4>{{\App\CPU\translate('Name')}} : </h4>
                                    <h4 class="mx-1">{{$shop->name}}</h4>
                                </div>
                                <div class="flex-start">
                                    <h6>{{\App\CPU\translate('Phone')}} : </h6>
                                    <h6 class="mx-1">{{$shop->contact}}</h6>
                                </div>
                                <div class="flex-start">
                                    <h6>{{\App\CPU\translate('address')}} : </h6>
                                    <h6 class="mx-1">{{$shop->address}}</h6>
                                </div>

                                <div class="flex-start">
                                    <a class="btn btn-primary" href="{{route('seller.shop.edit',[$shop->id])}}">{{\App\CPU\translate('edit')}}</a>
                                </div>
                            </div>
                            <div class="col-md-5"></div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <form method="POST" action="{{route('seller.shop.updateday',[$shop->id])}}" enctype="multipart/form-data">
                        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                     <div class="card-header">
                        <h3 class="h3 mb-0  ">{{\App\CPU\translate('working_hours')}} {{\App\CPU\translate('24 Hours')}} </h3>
                        </div>
                        <div class="card-body">
                            @foreach($days as $day)
                                <div class="form-inline">
                                    <label class="my-1 mr-2">{{ ucfirst($day->name) }}: {{\App\CPU\translate('From Hours')}} </label>
                                    <select class="custom-select my-1 mr-sm-2" name="from_hours[{{ $day->id }}]">
                                        <option value="">--</option>
                                        @foreach(range(1,12) as $hours)
                                            <option
                                                value="{{ $hours < 10 ? "$hours" : $hours }}"
                                                {{ old('from_hours.'.$day->id, $shop->days->find($day->id) ? $shop->days->find($day->id)->pivot['from_hours'] : null) == ($hours < 10 ? "0$hours" : $hours) ? 'selected' : '' }}
                                            >{{ $hours < 10 ? "0$hours" : $hours }}</option>
                                        @endforeach
                                    </select>
                                    <label class="my-1 mr-2">:</label>
                                    <select class="custom-select my-1 mr-sm-2" name="from_minutes[{{ $day->id }}]">
                                        <option value="">--</option>
                                        <option value="00" {{ old('from_minutes.'.$day->id, $shop->days->find($day->id) ? $shop->days->find($day->id)->pivot['from_minutes'] : null) == '00' ? 'selected' : '' }}>00</option>
                                        <option value="30" {{ old('from_minutes.'.$day->id, $shop->days->find($day->id) ? $shop->days->find($day->id)->pivot['from_minutes'] : null) == '30' ? 'selected' : '' }}>30</option>
                                    </select>
                                    <select class="custom-select my-1 mr-sm-2" name="am_pm[{{ $day->id }}]">
                                        <option value="">--</option>
                                        <option value="صباحاً" {{ old('am_pm.'.$day->id, $shop->days->find($day->id) ? $shop->days->find($day->id)->pivot['am_pm'] : null) == 'صباحاً' ? 'selected' : '' }}>صباحاً</option>
                                        <option value="مساءً" {{ old('am_pm.'.$day->id, $shop->days->find($day->id) ? $shop->days->find($day->id)->pivot['am_pm'] : null) == 'مساءً' ? 'selected' : '' }}>مساءً</option>
                                    </select>
                                    <label class="my-1 mr-2">{{\App\CPU\translate('To Hours')}}</label>
                                    <select class="custom-select my-1 mr-sm-2" name="to_hours[{{ $day->id }}]">
                                        <option value="">--</option>
                                        @foreach(range(1,12) as $hours)
                                            <option
                                                value="{{ $hours < 10 ? "0$hours" : $hours }}"
                                                {{ old('to_hours.'.$day->id, $shop->days->find($day->id) ? $shop->days->find($day->id)->pivot['to_hours'] : null) == ($hours < 10 ? "0$hours" : $hours) ? 'selected' : '' }}
                                            >{{ $hours < 10 ? "0$hours" : $hours }}</option>
                                        @endforeach
                                    </select>
                                    <label class="my-1 mr-2">:</label>
                                    <select class="custom-select my-1 mr-sm-2" name="to_minutes[{{ $day->id }}]">
                                        <option value="">--</option>
                                        <option value="00" {{ old('to_minutes.'.$day->id, $shop->days->find($day->id) ? $shop->days->find($day->id)->pivot['to_minutes'] : null) == '00' ? 'selected' : '' }}>00</option>
                                        <option value="30" {{ old('to_minutes.'.$day->id, $shop->days->find($day->id) ? $shop->days->find($day->id)->pivot['to_minutes'] : null) == '30' ? 'selected' : '' }}>30</option>
                                    </select>
                                    <select class="custom-select my-1 mr-sm-2" name="pm_am[{{ $day->id }}]">
                                        <option value="">--</option>
                                        <option value="صباحاً" {{ old('pm_am.'.$day->id, $shop->days->find($day->id) ? $shop->days->find($day->id)->pivot['pm_am'] : null) == 'صباحاً' ? 'selected' : '' }}>صباحاً</option>
                                        <option value="مساءً" {{ old('pm_am.'.$day->id, $shop->days->find($day->id) ? $shop->days->find($day->id)->pivot['pm_am'] : null) == 'مساءً' ? 'selected' : '' }}>مساءً</option>
                                    </select>                                </div>
                            @endforeach

                        </div>
                </div>
            </div>
        </div>

         <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h3 mb-0 ">  حدد الموقع على الخريطه </h3>
                            </div>
                            <div class="card-body">
                            <div class="form-group">
                                <input class="form-control map-input {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{$shop->address}}">
                                <input type="hidden" name="latitude" id="address-latitude" value="{{ old('latitude') ?? '0' }}" />
                                <input type="hidden" name="longitude" id="address-longitude" value="{{ old('longitude') ?? '0' }}" />
                                @if($errors->has('address'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('address') }}
                                    </div>
                                @endif
                                <span class="help-block">ابحث بالموقع وباسم الفرع</span>
                            </div>
                            <div id="address-map-container" class="mb-2" style="width:100%;height:400px; ">
                                <div style="width: 100%; height: 100%" id="address-map"></div>
                            </div>
                             <div class="form-group">
                                <button type="submit" class="btn btn-primary float-right">{{\App\CPU\translate('submit map address')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <!-- Page level plugins -->
     <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize&language=en&region=GB" async defer></script>
    <script src="{{asset('js/mapInput.js')}}"></script>
@endpush
