@extends('layouts.back-end.app-seller')

@section('title',\App\CPU\translate('Product List'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('seller.dashboard.index')}}">{{\App\CPU\translate('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('Products')}}</li>

            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row flex-between justify-content-between align-items-center flex-grow-1">
                            <div class="col-12 mb-1 col-md-4">
                                <h5>{{ \App\CPU\translate('Product')}} {{ \App\CPU\translate('Table')}} ({{ $products->total() }})</h5>

                            </div>


                            <div class="col-12 mb-1 col-md-5">
                                <form action="{{ url()->current() }}" method="GET">
                                    <!-- Search -->
                                    <div class="input-group input-group-merge input-group-flush">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                            placeholder="{{\App\CPU\translate('Search by Product Name')}}" aria-label="Search orders" value="{{ $search }}" required>
                                        <button type="submit" class="btn btn-primary" style="background: #645cb3;border:none">{{\App\CPU\translate('search')}}</button>
                                    </div>
                                    <!-- End Search -->
                                </form>
                            </div>
                            <div class="col-12 col-md-3">
                                <a href="{{route('seller.product.add-new')}}" class="btn btn-primary float-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}" style="background: #645cb3;border:none">
                                    <i class="tio-add-circle"></i>
                                    <span class="text">{{\App\CPU\translate('Add new product')}}</span>
                                </a>
                            </div>
                        </div>

                    </div>
                    <div class="card-body" style="padding: 0">
                        <div class="table-responsive">
                            <table id="datatable"
                                   style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                   class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                   style="width: 100%">
                                <thead class="thead-light">
                                <tr>
                                    {{-- <th>{{\App\CPU\translate('SL#')}}</th> --}}
                                    <th>{{\App\CPU\translate('Product Image')}}</th>
                                    <th>{{\App\CPU\translate('Product Name')}}</th>
                                    <th>{{\App\CPU\translate('item')}}</th>
                                    <th>{{\App\CPU\translate('Product Code')}}</th>
                                    <th>{{\App\CPU\translate('Product Size')}}</th>
                                    <th>{{\App\CPU\translate('available')}} </th>
                                    <th>{{\App\CPU\translate('purchase_price')}}</th>
                                    <th>{{\App\CPU\translate('selling_price')}}</th>
                                    <th style="width: 5px" class="text-center">{{\App\CPU\translate('Action')}}</th>
                                    {{-- <th>{{\App\CPU\translate('verify_status')}}</th> --}}
                                    {{-- <th>{{\App\CPU\translate('branches available')}}</th> --}}
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $k=>$p)
                                    <tr>
                                        {{-- <th scope="row">{{$products->firstitem()+ $k}}</th> --}}
                                        <td>
                                            <img class="avatar avatar-l avatar-4by3 {{Session::get('direction') === "rtl" ? 'ml-4' : 'mr-4'}}"
                                            onerror="this.src='{{asset('assets/front-end/img/image-place-holder.png')}}'"
                                            src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$p->thumbnail}}"
                                            alt="Image Description">
                                        </td>
                                        <td><a href="{{route('seller.product.view',[$p['id']])}}">
                                                {{\Illuminate\Support\Str::limit($p['name'],40)}}
                                            </a>
                                        </td>
                                        <td>
                                           {{ $p->brand->name }}
                                        </td>
                                        <td>
                                            {{ $p->sku }}
                                        </td>
                                        <td>
                                            {{ $p->product_size }}
                                        </td>

                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" class="status"
                                                id="{{$p['id']}}" {{$p->status == 1?'checked':''}}>
                                                <span class="slider round" ></span>
                                            </label>
                                        </td>
                                        <td>
                                            {{ number_format($p->purchase_price,2) }}
                                        </td>
                                        <td>
                                            <form action="{{ route('seller.product.updateProPrice',$p->id) }}" method="POST"
                                                id="update_product_price">
                                                @csrf
                                                <div class="d-flex">
                                                    <input type="number" name="unit_price" class="form-control rounded-pill" value="{{number_format($p->unit_price,2)}}">
                                                    <button type="button" onclick="check({{$p->id}})" class="btn"><i class="fa fa-check"></i></button>
                                                </div>
                                            </form>
                                        </td>
                                        {{-- <td>
                                            @if($p->request_status == 0)
                                                <label class="badge badge-warning">{{\App\CPU\translate('New Request')}}</label>
                                            @elseif($p->request_status == 1)
                                                <label class="badge badge-success">{{\App\CPU\translate('Approved')}}</label>
                                            @elseif($p->request_status == 2)
                                                <label class="badge badge-danger">{{\App\CPU\translate('Denied')}}</label>
                                            @endif
                                        </td> --}}
                                        {{-- <td>
                                            <label class="switch">
                                                <input type="checkbox" class="status_branch"
                                                       id="{{$p['id']}}" {{$p->status_branch == 1?'checked':''}}>
                                                <span class="slider round"></span>
                                            </label>
                                        </td> --}}
                                        <td>
                                            <a class="btn btn-sm text-white" style="background: #645cb3;border:none;border-radius:46%"
                                                title="{{\App\CPU\translate('view')}}"
                                                href="{{route('seller.product.view',[$p['id']])}}">
                                                <i class="fa fa-arrow-circle-left"></i>
                                            </a>
                                            {{-- <a  class="btn btn-primary btn-sm"
                                                title="{{\App\CPU\translate('Edit')}}"
                                                href="{{route('seller.product.edit',[$p['id']])}}">
                                                <i class="tio-edit"></i>
                                            </a> --}}

                                            <form action="{{route('seller.product.delete',[$p['id']])}}"
                                                  method="post" id="product-{{$p['id']}}">
                                                @csrf @method('delete')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Footer -->
                    <div class="card-footer">
                        {{$products->links()}}
                    </div>
                    @if(count($products)==0)
                        <div class="text-center p-4">
                            <img class="mb-3" src="{{asset('assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">
                            <p class="mb-0">{{\App\CPU\translate('No data to show')}}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Page level plugins -->
    <script src="{{asset('assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
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
                url: "{{route('seller.product.status-update')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                    if(data.success == true) {
                        toastr.success('Status updated successfully');
                    }
                    else if(data.success == false) {
                        toastr.error('{{\App\CPU\translate('Status updated failed. Product must be approved')}}');
                        location.reload();
                    }
                }
            });
        });
        $(document).on('change', '.status_branch', function () {
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
                url: "{{route('seller.product.status-branch-update')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                    if(data.success == true) {
                        toastr.success('{{\App\CPU\translate('Status updated successfully')}}');
                    }
                    else if(data.success == false) {
                        toastr.error('{{\App\CPU\translate('Status updated failed. Product must be approved')}}');
                        location.reload();
                    }
                }
            });
        });

        function check(id){
            Swal.fire({
                title: '{{\App\CPU\translate('Are you sure')}}',
                text: '',
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#377dff',
                cancelButtonText: 'الغاء',
                confirmButtonText: 'نعم',
                reverseButtons: true
            }).then((result) => {
                // for ( instance in CKEDITOR.instances ) {
                //     CKEDITOR.instances[instance].updateElement();
                // }
                if (result.value == true) {
                        $('#update_product_price').submit();
                    }
                // var formData = new FormData(document.getElementById('update_product_price'));
                // $.ajaxSetup({
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     }
                // });
                // $.ajax({
                //     url: "/seller/product/update-product-price/"+id,
                //     data: formData,
                //     method:'post',
                //     contentType: false,
                //     processData: false,
                //     success: function (data) {
                //         if (data.errors) {
                //             for (var i = 0; i < data.errors.length; i++) {
                //                 toastr.error(data.errors[i].message, {
                //                     CloseButton: true,
                //                     ProgressBar: true
                //                 });
                //             }
                //         } else {
                //             toastr.success('{{\App\CPU\translate('product updated successfully!')}}', {
                //                 CloseButton: true,
                //                 ProgressBar: true
                //             });
                //             $('#update_product_price').submit();
                //         }
                //     }
                // });
            })
        };
    </script>
@endpush
