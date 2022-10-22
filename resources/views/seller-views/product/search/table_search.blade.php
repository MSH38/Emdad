<div class="card-body" >

    <div class="table-responsive">
        <table class="table">
            <thead>
                <th>{{\App\CPU\translate('Product Image')}}</th>
                <th>{{\App\CPU\translate('Product Name')}}</th>
                <th>{{\App\CPU\translate('Product Size')}}</th>
                <th>{{\App\CPU\translate('Product Add')}}</th>
                <th>{{\App\CPU\translate('Product Size')}}</th>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>
                            <img class="avatar avatar-l avatar-4by3 {{Session::get('direction') === "rtl" ? 'ml-4' : 'mr-4'}}"
                            onerror="this.src='{{asset('assets/front-end/img/image-place-holder.png')}}'"
                            src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$product->thumbnail}}"
                            alt="Image Description">
                        </td>
                        <td>{{ $product->name }}</td>
                        <td> {{ $product->product_size }} </td>
                        <td>
                            <button class="btn btn-primary" style="background: #645cb3;border:none" onclick="productView({{ $product->id }})" data-toggle="modal" data-target=".bd-example-modal-lg">{{\App\CPU\translate('Add')}}</button>
                        </td>
                        <td>
                            <button class="btn btn-light" onclick="productSize({{ $product->id }})" data-toggle="modal" data-target=".bd-example-modal">{{\App\CPU\translate('Add Anather Size')}}</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <button class="btn btn-primary" data-toggle="modal" data-target=".example-modal" style="background: #645cb3;border:none">{{\App\CPU\translate('Send Request Add Product')}}</button>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card-footer">
    {{$products->links()}}
</div>
