@extends('layouts.back-end.app')

@section('title',\App\CPU\translate('Update branches'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-edit"></i>تحديث معلومات الفرع</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.branches.update',[$branche['id']])}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('branche_name')}}</label>
                                        <input type="text" value="{{$branche['branche_name']}}" name="branche_name"
                                               class="form-control" placeholder="branche_name"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1"> {{\App\CPU\translate('branche_address')}}</label>
                                        <input type="text" value="{{$branche['branche_address']}}" name="branche_address"
                                               class="form-control" placeholder="branche_address"
                                               required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('email')}}</label>
                                        <input type="email" value="{{$branche['email']}}" name="email" class="form-control"
                                               placeholder="Ex : ex@example.com"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('phone_mobile')}}</label>
                                        <input type="text" name="phone_mobile" value="{{$branche['phone_mobile']}}" class="form-control"
                                               placeholder="********967"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('manager_phone')}}</label>
                                        <input type="text" name="manager_phone" value="{{$branche['manager_phone']}}" class="form-control"
                                               placeholder="********967"
                                               required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('identity')}} {{\App\CPU\translate('type')}}</label>
                                        <select name="identity_type" class="form-control">
                                            <option
                                                value="passport" {{$branche['identity_type']=='passport'?'selected':''}}>
                                                {{\App\CPU\translate('passport')}}
                                            </option>
                                            <option
                                                value="driving_license" {{$branche['identity_type']=='driving_license'?'selected':''}}>
                                                {{\App\CPU\translate('driving')}} {{\App\CPU\translate('license')}}
                                            </option>
                                            <option value="nid" {{$branche['identity_type']=='nid'?'selected':''}}>{{\App\CPU\translate('nid')}}
                                            </option>
                                            <option
                                                value="company_id" {{$branche['identity_type']=='company_id'?'selected':''}}>
                                                {{\App\CPU\translate('company')}} {{\App\CPU\translate('id')}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('identity')}} {{\App\CPU\translate('number')}}</label>
                                        <input type="text" name="identity_number" value="{{$branche['identity_number']}}"
                                               class="form-control"
                                               placeholder="Ex : DH-23434-LS"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('identity')}} {{\App\CPU\translate('identity_image')}}</label>
                                        <div>
                                            <div class="row" id="coba"></div>
                                        </div>
                                    </div>
                                </div>

                                <br>

                                @foreach(json_decode($branche['identity_image'],true) as $img)
                                    <div class="col-md-4 col-12 mb-2">
                                        <img height="150" src="{{asset('storage/public/branche').'/'.$img}}">
                                    </div>
                                @endforeach
                                <hr>
                            </div>

                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('menager_password')}}</label>
                                <input type="text" name="menager_password" class="form-control" placeholder="Ex : menager_password">
                            </div>

                            <div class="form-group">
                                <label> {{\App\CPU\translate('branch_photo')}}</label><small style="color: red">* ( {{\App\CPU\translate('ratio')}} 1:1 )</small>
                                <div class="custom-file">
                                    <input type="file" name="branch_photo" id="customFileEg1" class="custom-file-input"
                                           accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    <label class="custom-file-label" for="customFileEg1">{{\App\CPU\translate('choose')}} {{\App\CPU\translate('file')}}</label>
                                </div>
                                <hr>
                                <center>
                                    <img style="height: 200px;border: 1px solid; border-radius: 10px;" id="viewer"
                                         src="{{asset('storage/public/branche').'/'.$branche['branch_photo']}}" alt="branche branch_photo"/>
                                </center>
                            </div>

                            <div class="form-group">
                                <label for="address">حدد موقع الفرع على الخريطه</label>
                                <input class="form-control map-input {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{  $branche->address }}">
                                <input type="hidden" name="latitude" id="address-latitude" value="{{ $branche->latitude ?? '0' }}" />
                                <input type="hidden" name="longitude" id="address-longitude" value="{{ $branche->longitude ?? '0' }}" />
                                @if($errors->has('address'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('address') }}
                                    </div>
                                @endif
                                <span class="help-block">يجب اختيار موقع الفرع على الخريطه</span>
                            </div>
                            <div id="address-map-container" class="mb-2" style="width:100%;height:400px; ">
                                <div style="width: 100%; height: 100%" id="address-map"></div>
                            </div>


                            <label>اوقات دوام الفرع</label>
                        @foreach($days as $day)
                            <div class="form-inline">
                                <label class="my-1 mr-2">{{ ucfirst($day->name) }}: from</label>
                                <select class="custom-select my-1 mr-sm-2" name="from_hours[{{ $day->id }}]">
                                    <option value="">--</option>
                                    @foreach(range(0,23) as $hours)
                                        <option
                                            value="{{ $hours < 10 ? "0$hours" : $hours }}"
                                            {{ old('from_hours.'.$day->id) == ($hours < 10 ? "0$hours" : $hours) ? 'selected' : '' }}
                                        >{{ $hours < 10 ? "0$hours" : $hours }}</option>
                                    @endforeach
                                </select>
                                <label class="my-1 mr-2">:</label>
                                <select class="custom-select my-1 mr-sm-2" name="from_minutes[{{ $day->id }}]">
                                    <option value="">--</option>
                                    <option value="00" {{ old('from_minutes.'.$day->id) == '00' ? 'selected' : '' }}>00</option>
                                    <option value="30" {{ old('from_minutes.'.$day->id) == '30' ? 'selected' : '' }}>30</option>
                                </select>
                                <label class="my-1 mr-2">to</label>
                                <select class="custom-select my-1 mr-sm-2" name="to_hours[{{ $day->id }}]">
                                    <option value="">--</option>
                                    @foreach(range(0,23) as $hours)
                                        <option
                                            value="{{ $hours < 10 ? "0$hours" : $hours }}"
                                            {{ old('to_hours.'.$day->id) == ($hours < 10 ? "0$hours" : $hours) ? 'selected' : '' }}
                                        >{{ $hours < 10 ? "0$hours" : $hours }}</option>
                                    @endforeach
                                </select>
                                <label class="my-1 mr-2">:</label>
                                <select class="custom-select my-1 mr-sm-2" name="to_minutes[{{ $day->id }}]">
                                    <option value="">--</option>
                                    <option value="00" {{ old('to_minutes.'.$day->id) == '00' ? 'selected' : '' }}>00</option>
                                    <option value="30" {{ old('to_minutes.'.$day->id) == '30' ? 'selected' : '' }}>30</option>
                                </select>
                            </div>
                             @endforeach

                            <hr>
                            <button type="submit" class="btn btn-primary float-right">{{\App\CPU\translate('submit')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize&language=en&region=GB" async defer></script>
    <script src="{{asset('js/mapInput.js')}}"></script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
        });
    </script>

    <script src="{{asset('assets/back-end/js/spartan-multi-image-picker.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'identity_image[]',
                maxCount: 5,
                rowHeight: '120px',
                groupClassName: 'col-2',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset('assets/back-end/img/400x400/img2.jpg')}}',
                    width: '100%'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('Please only input png or jpg type file', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('File size too big', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>
@endpush
