<!-- Header -->
<div class="card-header">
    <h5 class="card-header-title">
        <i class="tio-shopping-cart"></i> اخر الطلبات
    </h5>
    <i class="tio-gift" style="font-size: 45px"></i>
</div>
<!-- End Header -->

<!-- Body -->
<div class="card-body">
    <div class="row">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>{{\App\CPU\translate('Product Name')}}</th>
                    <th>{{\App\CPU\translate('Order Number')}}</th>
                    <th>{{\App\CPU\translate('Product Quantity')}}</th>
                    <th>{{\App\CPU\translate('Order Status')}}</th>
                    <th>{{\App\CPU\translate('Amount')}}</th>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>
                                <a href="{{route('seller.product.view',$order->product_id)}}">
                                    {{ $order->product->name }}
                                </a>
                            </td>
                            <td>{{ $order->order->order_group_id }}</td>
                            <td> {{ $order->qty }}</td>
                            <td>
                                @if ($order->order->order_status == 'pending')
                                    <span class="badge badge-primary">قيد التنفيذ</span>
                                @elseif ($order->order->order_status == 'confirmed')
                                    <span class="badge badge-warning">تمت الموافقة عليه</span>
                                @elseif ($order->order->order_status == 'out_for_delivery')
                                    <span class="badge badge-info">فى الطريق</span>
                                @elseif ($order->order->order_status == 'delivered')
                                    <span class="badge badge-success">تم التوصيل</span>
                                @elseif ($order->order->order_status == 'canceled')
                                    <span class="badge badge-danger">تم الالغاء</span>
                                @endif
                            </td>
                            <td>
                                {{ number_format($order->order->order_amount) }} ريال
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                لا توجد طلبات
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- End Body -->
