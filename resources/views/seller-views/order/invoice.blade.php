<html lang="ar" dir="rtl">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{\App\CPU\translate('invoice')}}</title>
    <meta http-equiv="Content-Type" content="text/html;"/>
    <meta charset="UTF-8">

    <style>
        *{
            padding: 0;
            margin: 0;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            box-shadow: 4px 4px 4px #fafafa
        }
        th, td {
        padding: 15px;
        }


    </style>
</head>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<body>

@php
    use App\Model\BusinessSetting;
    use App\Model\Seller;
    $company_phone =BusinessSetting::where('type', 'company_phone')->first()->value;
    $company_email =BusinessSetting::where('type', 'company_email')->first()->value;
    $company_name =BusinessSetting::where('type', 'company_name')->first()->value;
    $company_web_logo =BusinessSetting::where('type', 'company_web_logo')->first()->value;
    $company_mobile_logo =BusinessSetting::where('type', 'company_mobile_logo')->first()->value;
    $sellerId = auth('seller')->id();
    $sellerGST = Seller::findOrFail($sellerId)->gst;
    $address = json_decode($order->shipping_address_data)->address;
@endphp




<nav style="height: 50px;background: #5435b8;border-radius: 10px">
    {{-- <h1 style="color: white;padding: 10px;"> --}}
        <img src="http://localhost/sare/storage/public/company/2022-06-20-62b0d4a963f4e.png" style="height: 45px;width: 130px;border-radius: 10px;padding:2px 2px 0 0" alt="">
    {{-- </h1> --}}
</nav>
<section>
    <div style="display: inline-block;padding: 10px;">
        <h2>فاتورة نقدية &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{date('Y-m-d')}}</h2>
        {{-- <h2>17-10-2022</h2> --}}
    </div>

    <table>
        <tr>
            <th><strong>العميل</strong></th>
            <td>{{ $order->customer->f_name }} {{ $order->customer->l_name }}</td>
            <th><strong>رقم الطلب</strong></th>
            <td>#{{ $order->id }}</td>
            <th><strong>اسم التاجر</strong></th>
            <td>{{ $order->seller->f_name }} {{ $order->seller->l_name }}</td>
        </tr>
        <tr>
            <th><strong>رقم الجوال</strong></th>
            <td>{{ $order->customer->phone }}</td>
            <th><strong>رقم الشحنة</strong></th>
            <td>{{ $order->third_party_delivery_tracking_id }}</td>
            <th><strong>العنوان</strong></th>
            <td>{{ $address }}</td>
        </tr>

    </table>

    <div style="padding: 10px;">
        <h2>المنتجات</h2>
    </div>

    <table style="text-align: right;">
        <thead class="thead-light">
        <tr>
            <th>اسم المنتج</th>
            <th>حجم المنتج</th>
            <th>الكمية</th>
            <th>السعر الوحدة</th>
            <th>المبلغ </th>
        </tr>
        </thead>
        <tbody>
            @foreach($order->details as $key=>$details)
            <tr>
                <td>{{$details->product->name}}</td>
                <td>{{$details->product->product_size}}</td>
                <td>
                    {{ $details->qty }}
                </td>
                <td>
                    {{ number_format($details->product->unit_price,2) }} ريال
                </td>
                <td>
                    {{ number_format($details->price,2) }} ريال
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>




{{-- <div class="first" style="display: block; height:auto !important;background-color: #E6E6E6">
    <table class="content-position">
        <tr>
            <th style="text-align: left">
                <img height="70" width="200" src="{{asset("storage/public/company/$company_web_logo")}}"
                     alt="">
            </th>
            <th style="text-align: right">
                <h1 style="color: #030303; margin-bottom: 0px; font-size: 30px;text-transform: capitalize">{{\App\CPU\translate('invoice')}}</h1>
                @if($order['seller_is']!='admin' && $order['seller']->gst != null)
                    <h5 style="color: #030303; margin-bottom: 0px;text-transform: capitalize">{{\App\CPU\translate('GST')}}
                        : {{ $order['seller']->gst }}</h5>
                @endif
            </th>
        </tr>
    </table>

    <table class="bs-0">
        <tr>
            <th class="bg-primary content-position-y" style="padding-right: 0; height: 44px; text-align: left">
                <div>
                    <span class="h4 inline text-white text-uppercase">{{\App\CPU\translate('invoice')}} # </span>
                    <span class="inline">
                        <span class="h4 text-white" style="display: inline">{{ $order->id }}</span>
                    </span>
                </div>
            </th>
            <th class="bg-secondary content-position-y" style="text-align: right; height: 44px;">
                <span class="h4 inline"
                      style="color: #030303;padding-right: 15px;">{{\App\CPU\translate('date')}} : </span>
                <span class="inline h4">
                    <strong style="color: #030303; ">{{date('d-m-Y h:i:s a',strtotime($order['created_at']))}}</strong>
                </span>
            </th>
        </tr>
    </table>
</div> --}}
{{--<hr>--}}
{{--<table>--}}
{{-- <div class="row">
    <section>
        <table class="content-position-y" style="width: 100%">
            <tr>
                @if ($order->shippingAddress)
                    <td valign="top">
                        <span class="h2" style="margin: 0px;">{{\App\CPU\translate('shipping_to')}}: </span>
                        <div class="h4 montserrat-normal-600">
                            <p style=" margin-top: 6px; margin-bottom:0px;">{{$order->customer !=null? $order->customer['f_name'].' '.$order->customer['l_name']:\App\CPU\translate('name_not_found')}}</p>
                            <p style=" margin-top: 6px; margin-bottom:0px;">{{$order->customer !=null? $order->customer['email']:\App\CPU\translate('email_not_found')}}</p>
                            <p style=" margin-top: 6px; margin-bottom:0px;">{{$order->customer !=null? $order->customer['phone']:\App\CPU\translate('phone_not_found')}}</p>
                            <p style=" margin-top: 6px; margin-bottom:0px;">{{$order->shippingAddress ? $order->shippingAddress['address'] : ""}}</p>
                            <p style=" margin-top: 6px; margin-bottom:0px;">{{$order->shippingAddress ? $order->shippingAddress['city'] : ""}} {{$order->shippingAddress ? $order->shippingAddress['zip'] : ""}}</p>

                        </div>
                    </td>
                @else
                    <td valign="top">
                        <span class="h2" style="margin: 0px;">{{\App\CPU\translate('customer_info')}}: </span>
                        <div class="h4 montserrat-normal-600">
                            <p style=" margin-top: 6px; margin-bottom:0px;">{{$order->customer['f_name'].' '.$order->customer['l_name']}}</p>
                            @if ($order->customer['id']!=0)
                            <p style=" margin-top: 6px; margin-bottom:0px;">{{$order->customer !=null? $order->customer['email']:\App\CPU\translate('email_not_found')}}</p>
                            <p style=" margin-top: 6px; margin-bottom:0px;">{{$order->customer !=null? $order->customer['phone']:\App\CPU\translate('phone_not_found')}}</p>
                            @endif
                        </div>
                    </td>
                @endif
                @if ($order->billingAddress)
                    <td valign="top">
                        <span class="h2" >{{\App\CPU\translate('billing_address')}}: </span>
                        <div class="h4 montserrat-normal-600">
                            <p style=" margin-top: 6px; margin-bottom:0px;">{{$order->billingAddress ? $order->billingAddress['contact_person_name'] : ""}}</p>
                            <p style=" margin-top: 6px; margin-bottom:0px;">{{$order->billingAddress ? $order->billingAddress['phone'] : ""}}</p>
                            <p style=" margin-top: 6px; margin-bottom:0px;">{{$order->billingAddress ? $order->billingAddress['address'] : ""}}</p>
                            <p style=" margin-top: 6px; margin-bottom:0px;">{{$order->billingAddress ? $order->billingAddress['city'] : ""}} {{$order->billingAddress ? $order->billingAddress['zip'] : ""}}</p>

                        </div>
                    </td>
                @endif
            </tr>
        </table>
    </section>
</div> --}}
{{--</table>--}}

{{-- <br> --}}

{{-- <div class="row" style="margin: 20px 0; display:block; height:auto !important ;">
    <div class=" content-height content-position-y" style="">
        <table class="customers bs-0">
            <thead>
            <tr class="for-th">
                <th class="for-th bg-primary">{{\App\CPU\translate('no.')}}</th>
                <th class="for-th bg-primary">{{\App\CPU\translate('item_description')}}</th>
                <th class="for-th bg-secondary for-th-font-bold" style="color: black">
                    {{\App\CPU\translate('unit_price')}}
                </th>
                <th class="for-th for-th-font-bold" style="color: black">
                    {{\App\CPU\translate('qty')}}
                </th>
                <th class="for-th for-th-font-bold" style="color: black">
                    {{\App\CPU\translate('total')}}
                </th>
            </tr>
            </thead>
            @php
                $subtotal=0;
                $total=0;
                $sub_total=0;
                $total_tax=0;
                $total_shipping_cost=0;
                $total_discount_on_product=0;
                $main_total=0;
                $ext_discount=0;
            @endphp
            <tbody>
            @foreach($order->details as $key=>$details)

                @php $subtotal=($details['price'])*$details->qty @endphp
                <tr class="for-tb" style=" border: 1px solid #D8D8D8;margin-top: 5px">
                    <td class="for-tb for-th-font-bold">{{$key+1}}</td>
                    <td class="for-tb">
                        {{$details['product']?$details['product']->name:''}}
                        <br>
                        {{\App\CPU\translate('variation')}} : {{$details['variant']}}
                    </td>
                    <td class="for-tb for-th-font-bold">{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($details['price']))}}</td>
                    <td class="for-tb">{{$details->qty}}</td>
                    <td class="for-tb for-th-font-bold">{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($subtotal))}}</td>
                </tr>

                @php
                    $sub_total+=$details['price']*$details['qty'];
                    $total_tax+=$details['tax'];
                    $total_shipping_cost+=$details->shipping ? $details->shipping->cost :0;
                    $total_discount_on_product+=$details['discount'];
                    $total+=$subtotal;
                    $main_total = $sub_total+$total_tax+$total_shipping_cost -$total_discount_on_product;

                @endphp
            @endforeach
            </tbody>

        </table>
    </div>
</div>
@php


        if ($order['extra_discount_type'] == 'percent') {
            $ext_discount = ($sub_total / 100) * $order['extra_discount'];
        } else {
            $ext_discount = $order['extra_discount'];
        }

@endphp
@php($shipping=$order['shipping_cost'])
<div class="content-position-y" style=" display:block; height:auto !important;margin-top: 40px">
    <table style="width: 100%;">
        <tr>
            <th style="text-align: left; vertical-align: text-top;width:30%;">
                <h4 style="color: #130505 !important; margin:0px;">{{\App\CPU\translate('payment_details')}}</h4>
                <h5 style="color: #414141 !important ; padding-top:5px;">{{ str_replace('_',' ',$order->payment_method) }}</h5>
                <p style="color: #414141 !important ; padding-top:5px;">{{$order->payment_status}}, {{date('y-m-d',strtotime($order['created_at']))}}</p>
                @if ($order->delivery_type !=null)
                    <h4 style="color: #130505 !important; margin:0px;text-transform: capitalize;">{{\App\CPU\translate('delivery_info')}} </h4>
                    @if ($order->delivery_type == 'self_delivery')
                        <p style="color: #414141 !important ; padding-top:5px;">
                            <span style="text-transform: capitalize">
                                {{\App\CPU\translate('self_delivery')}}
                            </span>
                            <br>
                            <span style="text-transform: capitalize">
                                {{\App\CPU\translate('delivery_man_name')}} : {{$order->delivery_man['f_name'].' '.$order->delivery_man['l_name']}}
                            </span>
                            <br>
                            <span style="text-transform: capitalize">
                                {{\App\CPU\translate('delivery_man_phone')}} : {{$order->delivery_man['phone']}}
                            </span>
                        </p>
                    @else
                    <p style="color: #414141 !important ; padding-top:5px;">
                        <span>
                            {{$order->delivery_service_name}}
                        </span>
                        <br>
                        <span>
                            {{\App\CPU\translate('tracking_id')}} : {{$order->third_party_delivery_tracking_id}}
                        </span>
                    </p>
                    @endif
                @endif
            </th>

            <th style="text-align: right;width:70%;">
                <table style="width: 96%;margin-left:41%; display: inline " class="text-right sm-padding strong bs-0">
                    <tbody>

                    <tr>
                        <th class="gry-color text-left"><b>{{\App\CPU\translate('sub_total')}}</b></th>
                        <td>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($sub_total))}}</td>

                    </tr>
                    <tr>
                        <th class="gry-color text-left text-uppercase"><b>{{\App\CPU\translate('tax')}}</b></th>
                        <td>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($total_tax))}}</td>
                    </tr>
                    @if ($order->order_type=='default_type')
                    <tr>
                        <th class="gry-color text-left"><b>{{\App\CPU\translate('shipping')}}</b></th>
                        <td>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($shipping))}}</td>
                    </tr>
                    @endif
                    <tr>
                        <th class="gry-color text-left"><b>{{\App\CPU\translate('coupon_discount')}}</b></th>
                        <td>- {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($order->discount_amount))}}</td>
                    </tr>
                    @if ($order->order_type=='POS')
                        <tr>
                            <th class="gry-color text-left"><b>{{\App\CPU\translate('extra_discount')}}</b></th>
                            <td>
                                - {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($ext_discount))}} </td>
                        </tr>
                    @endif
                    <tr class="border-bottom">
                        <th class="gry-color text-left"><b>{{\App\CPU\translate('discount_on_product')}}</b></th>
                        <td>- {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($total_discount_on_product))}}</td>
                    </tr>
                    <tr style="background-color: #2D7BFF">
                        <th class="text-left"><b class="text-white">{{\App\CPU\translate('total')}}</b></th>
                        <td class="text-white">{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($order->order_amount))}}</td>
                    </tr>
                    </tbody>
                </table>
            </th>
        </tr>
    </table>
</div>
<br>

<br><br><br>

<div class="row">
    <section>
        <table style="width: 100%">
            <tr>
                <th class="content-position-y bg-primary"
                    style="padding-top:10px; padding-bottom:10px;text-align: left; width: 50%">
                    <div class="text-white" style="padding-top:5px; padding-bottom:2px;"><i  class="fa fa-phone text-white"></i> {{\App\CPU\translate('phone')}} : {{\App\Model\BusinessSetting::where('type','company_phone')->first()->value}}</div>
                    <div class="text-white" style="padding-top:5px; padding-bottom:2px;"><i  class="fa fa-globe text-white" aria-hidden="true"></i>  {{\App\CPU\translate('website')}} : {{url('/')}}</div>
                    <div class="text-white" style="padding-top:5px; padding-bottom:2px;"><i  class="fa fa-envelope text-white" aria-hidden="true"></i>  {{\App\CPU\translate('email')}} : {{$company_email}}</div>
                </th>
                <th class="bg-secondary content-position-y" style="text-align: right; ">

                </th>
            </tr>
        </table>
    </section>
</div> --}}




</body>
</html>
