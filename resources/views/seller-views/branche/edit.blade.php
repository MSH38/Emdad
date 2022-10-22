@extends('layouts.back-end.app-seller')

@section('title',\App\CPU\translate('branche edit'))

@push('css_or_js')
    <link href="{{asset('assets/back-end/css/tags-input.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/select2/css/select2.min.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        <form action="{{route('seller.branches.update',[$branche['id']])}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('branche_name')}}</label>
                                        <input type="text" value="{{$branche['branche_name']}}" name="branche_name"
                                               class="form-control" placeholder="branche_name"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('manager_name')}}</label>
                                        <input type="text" name="manager_name" class="form-control" value="{{$branche['manager_name']}}"  placeholder="Ex : manager_name">
                                    </div>
                                </div>
                               <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('phone_mobile')}}</label>
                                        <input type="text" name="phone_mobile" value="{{$branche['phone_mobile']}}" class="form-control"  maxlength="13"
                                               placeholder="********967"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('email')}}</label>
                                        <input type="text" name="email" value="{{$branche['email']}}" class="form-control"
                                               placeholder="mmm@gmail.com"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('manager_phone')}}</label>
                                        <input type="text" name="manager_phone" value="{{$branche['manager_phone']}}" class="form-control"  maxlength="13"
                                               placeholder="********967"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('menager_password')}}</label>
                                        <input type="text" name="menager_password" class="form-control" placeholder="Ex : xxxxxxxxxxx">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>{{\App\CPU\translate('deliveryman')}} {{\App\CPU\translate('branch_photo')}}</label><small style="color: red">* ( {{\App\CPU\translate('ratio')}} 1:1 )</small>
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
                                <label for="address">اكتب الموقع بالحقل أعلاة لتحديد الموقع</label>
                                <input class="form-control map-input {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{  $branche->address }}">
                                <input type="hidden" name="latitude" id="address-latitude" value="{{ $branche->latitude ?? '0' }}" />
                                <input type="hidden" name="longitude" id="address-longitude" value="{{ $branche->longitude ?? '0' }}" />
                                @if($errors->has('address'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('address') }}
                                    </div>
                                @endif
                                <span class="help-block">حدد الموقع او اقرب مكان لموقعك</span>
                            </div>
                            <div id="address-map-container" class="mb-2" style="width:100%;height:400px; ">
                                <div style="width: 100%; height: 100%" id="address-map"></div>
                            </div>



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
