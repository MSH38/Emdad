@extends('layouts.back-end.app-seller')
@section('title', \App\CPU\translate('Order List'))

@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
        .activation{
            height: 3px;
            background: #645cb3;
        }
    </style>
@endpush

@section('content')
    <!-- Page Heading -->
    <div class="content container-fluid">
        <div class="row align-items-center mb-3">
            <div class="col-sm">
                <h1 class="page-header-title">{{\App\CPU\translate('Orders')}} <span
                        class="badge badge-soft-dark ml-2">{{$orders->total()}}</span>
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @include('seller-views.order.oreder_header')
            </div>
        </div>

        <div class="row" style="margin-top: 20px">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row  justify-content-between align-items-center flex-grow-1">
                            <div class="col-12 col-sm-6 col-md-4">
                                <h5>{{\App\CPU\translate('order_table')}} </h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 0">
                        <div class="table-responsive">
                            <table id="datatable" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                   class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                   style="width: 100%">
                                <thead class="thead-light">
                                <tr>
                                    <th>{{\App\CPU\translate('the remaining time')}}</th>
                                    <th>{{\App\CPU\translate('Order')}}</th>
                                    <th>{{\App\CPU\translate('Date To Delivery')}}</th>
                                    <th>{{\App\CPU\translate('Time To Delivery')}}</th>
                                    <th>{{\App\CPU\translate('Status')}}</th>
                                    <th>{{\App\CPU\translate('Amount')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $k=>$order)
                                    @php
                                        $to = \Carbon\Carbon::parse($order->created_at->modify('+'.$order->daysToDelivery.' day')->format('Y-m-d'));
                                        $now = \Carbon\Carbon::parse(date('Y-m-d'));
                                        $days = $now->diffInDays($to);
                                    @endphp
                                    <tr>
                                        <td>
                                            {{$days}} يوم
                                        </td>
                                        <td>
                                            <a href="{{route('seller.orders.details',$order['id'])}}">#{{$order['id']}}</a>
                                        </td>
                                        <td>{{$to->format('Y-m-d')}}</td>
                                        <td>{{ date('h:i') }} {{date('a') == 'am' ? 'ص' : 'م'}}</td>
                                        <td>
                                            @if ($order->order_status == 'pending')
                                                <span class="badge badge-primary">طلب جديد</span>
                                            @elseif ($order->order_status == 'processing')
                                                <span class="badge badge-warning">قيد التحضير</span>
                                            @elseif ($order->order_status == 'confirmed')
                                                <span class="badge badge-success">مؤكد</span>
                                            @elseif ($order->order_status == 'canceled')
                                                <span class="badge badge-danger">تم رفض الطلب</span>
                                            @elseif ($order->order_status == 'out_for_delivery')
                                                <span class="badge badge-info">جاهز للاستلام</span>
                                            @elseif ($order->order_status == 'delivered')
                                                <span class="badge badge-success">تم التوصيل</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ number_format($order->order_amount,2) }} ريال
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Footer -->
                     <div class="card-footer">
                        {{$orders->links()}}
                    </div>
                    @if(count($orders)==0)
                        <div class="text-center p-4">
                            <img class="mb-3" src="{{asset('assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">
                            <p class="mb-0">{{\App\CPU\translate('No data to show')}}</p>
                        </div>
                    @endif
                    <!-- End Footer -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Page level plugins -->
    <script src="{{asset('assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
