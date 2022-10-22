<!-- Header -->
<div class="card-header">
    <h5 class="card-header-title">
        <i class="tio-align-to-top"></i> {{\App\CPU\translate('top_selling_products')}}
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
                    <th>{{\App\CPU\translate('Product Image')}}</th>
                    <th>{{\App\CPU\translate('Product Code')}}</th>
                    <th>{{\App\CPU\translate('Product Name')}}</th>
                    <th>{{\App\CPU\translate('Product Size')}}</th>
                    <th>الكمية المطلوبة * سعر الواحدة</th>
                </thead>
                <tbody>
                    @foreach($top_sell as $key=>$item)
                        @if(isset($item->product))
                        <tr>
                            <td>
                                <img width="100"
                                src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$item->product['thumbnail']}}"
                                onerror="this.src='{{asset('assets/back-end/img/160x160/img2.jpg')}}'"
                                alt="{{$item->product->name}} image">
                            </td>
                            <td>{{ $item->product->sku }}</td>
                            <td> {{ $item->product->name }}</td>
                            <td>{{ $item->product->product_size }}</td>
                            <td>
                                {{ $item->qty }} * {{ number_format($item->product->unit_price) }} ريال
                            </td>
                        </tr>
                        @endif
                @endforeach

                @empty($top_sell)
                <tr>
                    <td colspan="6">
                        لا توجد طلبات
                    </td>
                </tr>
                @endempty

                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- End Body -->

{{--
@forelse ($top_sell as $order)
<tr>
    <td>
        <img width="100"
        src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$order->product['thumbnail']}}"
        onerror="this.src='{{asset('assets/back-end/img/160x160/img2.jpg')}}'"
        alt="{{$order->product->name}} image">
    </td>
    <td>{{ $order->product->sku }}</td>
    <td> {{ $order->product->name }}</td>
    <td>{{ $order->product->product_size }}</td>
    <td>
        {{ $order->qty }} * {{ number_format($order->product->unit_price) }} ريال
    </td>
</tr>
@empty

@endforelse --}}
