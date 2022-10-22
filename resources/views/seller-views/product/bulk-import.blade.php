@extends('layouts.back-end.app-seller')

@section('title', \App\CPU\translate('Product Bulk Import'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('seller.dashboard.index')}}">{{\App\CPU\translate('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page"><a
                        href="{{route('seller.product.list')}}">{{\App\CPU\translate('Product')}}</a>
                </li>
                <li class="breadcrumb-item">{{\App\CPU\translate('bulk_import')}} </li>
            </ol>
        </nav>

        <!-- Content Row -->
        <div class="row" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">تحميل ملف المنتجات</div>
                    <div class="card-body d-flex justify-content-between">
                        <p>قم بتحميل ملف يحتوى على كشف بجميع منتجاتك ثم قم بالتعديل المطلوب</p>
                        <a href="{{asset('assets/product_bulk_format.xlsx')}}" download=""
                            class="btn btn-secondary"><i class="fa fa-file-download"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <form class="product-form" action="{{route('seller.product.bulk-import')}}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="card mt-2 rest-part">
                        <div class="card-header">
                            <h4>رفع ملف التعديلات</h4>

                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="file" name="products_file">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-footer">
                        <div class="row">
                            <div class="col-md-12" style="padding-top: 20px">
                                <button type="submit" class="btn btn-primary">{{\App\CPU\translate('Submit')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')

<script>
    $('input[type="file"]').on('change',function(e){
    $('#upload_'+$(this).attr('rand_key')).remove();
    var rand_key = (Math.random() + 1).toString(36).substring(7);
    $(this).attr('rand_key',rand_key);
    if(e.target.files.length){
        $(this).attr('rand_key',rand_key);
        $('<div class="col-12 py-2 px-0" id="upload_'+rand_key+'"></div>').insertAfter(this);
        $.each(e.target.files,(key,value)=>{
            $('#upload_'+rand_key).append('<div class="row d-flex m-0   btn" style="border:1px solid rgb(136 136 136 / 17%);max-width: 100%;padding: 5px;width: 220px;background: rgb(142 142 142 / 6%);margin-bottom:10px!important"><div style="max-height: 35px;overflow: hidden;display:flex;flex-flow: nowrap;" class="p-0 align-items-center">\
                <span class="d-inline-block font-small " style="line-height: 1.2;opacity: 0.7;border-radius: 12px;overflow:hidden;width:71px">\
                    <span class="fal fa-cloud-download p-2 font-2 me-2" style="background:rgb(129 129 129 / 24%);border-radius: 12px;"></span>\
                </span>\
                <span style="direction: ltr;position: relative;top: -2px;height:14px;overflow:hidden" class="d-inline-block naskh font-small"> '+value.name+' </span>\
                    <span class="d-inline-block font-small px-2" style="position: relative;font-weight: bold;"> '+(Math.round(value.size/1000000 * 100) / 100).toFixed(2)+'M </span>\
                </div>\
            </div>')});
    }
});
</script>
@endpush
