
@php
    $products = App\Model\Product::where('added_by','admin')->latest()->paginate(12);

@endphp
<div class="card-body" >

    <div class="table-responsive">
        <table class="table">
            <thead>
                <th>{{\App\CPU\translate('Product Image')}}</th>
                <th>{{\App\CPU\translate('Product Name')}}</th>
                <th>{{\App\CPU\translate('Product Quantity')}}</th>
                <th>{{\App\CPU\translate('Product Add')}}</th>
                <th>{{\App\CPU\translate('Product Size')}}</th>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>
                            <img class="avatar avatar-l avatar-4by3 {{Session::get('direction') === "rtl" ? 'ml-4' : 'mr-4'}}"
                            onerror="this.src='{{asset('assets/front-end/img/image-place-holder.png')}}'"
                            src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$product->thumbnail}}"
                            alt="Image Description">
                        </td>
                        <td>{{ $product->name }}</td>
                        <td> {{ $product->unit_numbers }} {{ $product->unit }} </td>
                        <td>
                            <button class="btn btn-primary">{{\App\CPU\translate('Add')}}</button>
                        </td>
                        <td>
                            <button class="btn btn-light">{{\App\CPU\translate('Add Anather Size')}}</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="card-footer">
    {{$products->links()}}
</div>
