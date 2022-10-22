@extends('layouts.back-end.app-seller')

@section('title', \App\CPU\translate('Add Shipping'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('seller.dashboard.index')}}">{{\App\CPU\translate('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('shipping_method')}}</li>

            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 ">
                {{-- <div class="card" style="height: 200px;">
                    <div class="card-header text-capitalize">
                        <h4>{{\App\CPU\translate('choose_shipping_method')}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-capitalize" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                <select class="form-control text-capitalize" name="shippingCategory" onchange="seller_shipping_type(this.value);"
                                            style="width: 100%">
                                    <option value="0" selected disabled>---{{\App\CPU\translate('select')}}---</option>
                                    <option value="order_wise" {{$shippingType=='order_wise'?'selected':'' }} >{{\App\CPU\translate('order_wise')}} </option>
                                    <option  value="category_wise" {{$shippingType=='category_wise'?'selected':'' }} >{{\App\CPU\translate('category_wise')}}</option>
                                    <option  value="product_wise" {{$shippingType=='product_wise'?'selected':'' }}>{{\App\CPU\translate('product_wise')}}</option>
                                </select>
                            </div>
                            <div class="col-12 mt-2" id="product_wise_note">
                                <p class="m-2" style="color: red;">{{\App\CPU\translate('note')}}: {{\App\CPU\translate("Please_make_sure_all_the product's_delivery_charges_are_up_to_date.")}}</p>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="card">
                    <div class="card-header">
                        <a href="" class="btn btn-primary">اضافة موصل</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable"
                                   style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                   class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                   style="width: 100%">
                                <thead class="thead-light">
                                <tr>
                                    <th>صورة الموصل</th>
                                    <th>اسم الموصل</th>
                                    <th>المنطقة</th>
                                    <th>عدد الطلبات</th>
                                    <th>المرتجع</th>
                                    <th>الرصيد</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <img class="avatar avatar-l avatar-4by3 {{Session::get('direction') === "rtl" ? 'ml-4' : 'mr-4'}}"
                                            src="data:image/png;base64,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">
                                        </td>
                                        <td>
                                            <a href="{{ route('seller.business-settings.shipping-method.profile') }}">
                                                محمد عبد الصمد
                                            </a>
                                        </td>
                                        <td>
                                           منطقة صنعاء
                                        </td>
                                        <td>
                                            5
                                        </td>
                                        <td>
                                            2
                                        </td>
                                        <td>
                                            <span class="bg-light rounded-pill p-2">
                                                {{number_format(20000,2)}} ريال
                                            </span>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content Row -->
        {{-- <div id="order_wise_shipping">
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="h3 mb-0 text-black-50 text-capitalize">{{\App\CPU\translate('add_order_wise_shipping')}} </h1>
                        </div>
                        <div class="card-body">
                            <form action="{{route('seller.business-settings.shipping-method.add')}}" method="post"
                                  style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                @csrf
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="title">{{\App\CPU\translate('title')}}</label>
                                            <input type="text" name="title" class="form-control" placeholder="">
                                        </div>

                                        <div class="col-md-3">
                                            <label for="duration">{{\App\CPU\translate('duration')}}</label>
                                            <input type="text" name="duration" class="form-control"
                                                   placeholder="{{\App\CPU\translate('Ex')}} : 4-6 {{\App\CPU\translate('days')}}">
                                        </div>

                                        <div class="col-md-3">
                                            <label for="cost">{{\App\CPU\translate('cost')}}</label>
                                            <input type="number" min="0" max="1000000" name="cost" class="form-control" placeholder="{{\App\CPU\translate('Ex')}} : 10 $">
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer" style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 0">
                                    <button type="submit" class="btn btn-primary float-right">{{\App\CPU\translate('Submit')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 20px">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="text-capitalize">{{\App\CPU\translate('order_wise_shipping_method')}}  <span style="color: red;">({{ $shipping_methods->total() }})</span></h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                   class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                   style="width: 100%">
                                <thead class="thead-light">
                                <tr>
                                    <th>{{\App\CPU\translate('sl#')}}</th>
                                    <th>{{\App\CPU\translate('title')}}</th>
                                    <th>{{\App\CPU\translate('duration')}}</th>
                                    <th>{{\App\CPU\translate('cost')}}</th>
                                    <th>{{\App\CPU\translate('status')}}</th>
                                    <th scope="col" style="width: 50px">{{\App\CPU\translate('action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($shipping_methods as $k=>$method)
                                    <tr>
                                        <th scope="row">{{$shipping_methods->firstItem()+$k}}</th>
                                        <td>{{$method['title']}}</td>
                                        <td>
                                            {{$method['duration']}}
                                        </td>
                                        <td>
                                            {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($method['cost']))}}
                                        </td>

                                        <td>
                                            <label class="switch">
                                                    <input type="checkbox" class="status"
                                                           id="{{$method['id']}}" {{$method->status == 1?'checked':''}}>
                                                    <span class="slider round"></span>
                                                </label>
                                        </td>
                                        <td>

                                            <a  class="btn btn-primary btn-sm"
                                                title="{{\App\CPU\translate('Edit')}}"
                                                href="{{route('seller.business-settings.shipping-method.edit',[$method['id']])}}">
                                                <i class="tio-edit"></i>
                                            </a>
                                            <a  class="btn btn-danger btn-sm delete"
                                                title="{{\App\CPU\translate('Delete')}}"
                                                style="cursor: pointer;"
                                                id="{{ $method['id'] }}">
                                                <i class="tio-add-to-trash"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <div class="card-footer">
                        {!! $shipping_methods->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-2" id="update_category_shipping_cost">
            <div class="card-header text-capitalize">
                <h4>{{\App\CPU\translate('update_category_shipping_cost')}}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="col-12">
                        <table class="table table-bordered" width="100%" cellspacing="0"
                            style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                            <thead>
                                <tr>
                                    <th scope="col">{{\App\CPU\translate('sl#')}}</th>
                                    <th scope="col">{{\App\CPU\translate('category_name')}}</th>
                                    <th scope="col">{{\App\CPU\translate('cost_per_product')}}</th>
                                    <th scope="col">{{\App\CPU\translate('multiply_with_QTY')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form action="{{route('seller.business-settings.category-shipping-cost.store')}}" method="POST">
                                    @csrf
                                    @foreach ($all_category_shipping_cost as $key=>$item)
                                        <tr>
                                            <td>
                                                {{$key+1}}
                                            </td>
                                            <td>
                                                {{$item->category!=null?$item->category->name:\App\CPU\translate('not_found')}}
                                            </td>
                                            <td>
                                                <input type="hidden" class="form-control" name="ids[]" value="{{$item->id}}">
                                                <input type="number" class="form-control" min="0" step="0.01" name="cost[]" value="{{\App\CPU\BackEndHelper::usd_to_currency($item->cost)}}">
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" name="multiplyQTY[]"
                                                        id="" value="{{$item->id}}" {{$item->multiply_qty == 1?'checked':''}}>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="4">
                                            <button type="submit" class="btn btn-primary ">{{\App\CPU\translate('Update')}}</button>
                                        </td>
                                    </tr>
                                </form>
                            </tbody>

                        </table>


                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection

@push('script')
<script>
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
            let shipping_type = '{{$shippingType}}';

            if(shipping_type==='category_wise')
            {
                $('#product_wise_note').hide();
                $('#order_wise_shipping').hide();
                $('#update_category_shipping_cost').show();

            }else if(shipping_type==='order_wise'){
                $('#product_wise_note').hide();
                $('#update_category_shipping_cost').hide();
                $('#order_wise_shipping').show();
            }else{

                $('#update_category_shipping_cost').hide();
                $('#order_wise_shipping').hide();
                $('#product_wise_note').show();
            }
        });
        $(document).on('change', '.status', function () {
            var id = $(this).attr("id");
            if ($(this).prop("checked") == true) {
                var status = 1;
            } else if ($(this).prop("checked") == false) {
                var status = 0;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('seller.business-settings.shipping-method.status-update')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function () {
                    toastr.success('{{\App\CPU\translate('order wise shipping method Status updated successfully')}}');
                }
            });
        });
        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            Swal.fire({
                title: '{{\App\CPU\translate('Are you sure delete this ?')}}',
                text: "{{\App\CPU\translate('You wont be able to revert this!')}}",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{\App\CPU\translate('Yes, delete it!')}}'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('seller.business-settings.shipping-method.delete')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function () {
                            toastr.success('{{\App\CPU\translate('Shipping Method deleted successfully')}}');
                            location.reload();
                        }
                    });
                }
            })
        });
    </script>
    <script>
        function seller_shipping_type(val)
        {
            console.log("val");
            if(val==='category_wise')
            {
                $('#product_wise_note').hide();
                $('#order_wise_shipping').hide();
                $('#update_category_shipping_cost').show();
            }else if(val==='order_wise'){
                $('#product_wise_note').hide();
                $('#update_category_shipping_cost').hide();
                $('#order_wise_shipping').show();
            }else{
                $('#update_category_shipping_cost').hide();
                $('#order_wise_shipping').hide();
                $('#product_wise_note').show();
            }

            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{route('seller.business-settings.shipping-type.store')}}",
                    method: 'POST',
                    data: {
                        shippingType: val
                    },
                    success: function (data) {
                        toastr.success('{{\App\CPU\translate('shipping_method_updated_successfully!!')}}');
                    }
                });
        }
    </script>
@endpush
