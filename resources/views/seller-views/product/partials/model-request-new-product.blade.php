<div class="modal fade example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="row">
                <div class="col-12 p-3">
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <form action="{{ route('seller.product.sendRequestProModel') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group pt-3">
                                        <div style="width: 100%">
                                            <input type="text" name="indastry_name" class="form-control rounded-pill"
                                                placeholder="اسم الشركة المصنعة">
                                        </div>
                                        <div class="pt-3" style="width: 100%">
                                            <input type="text" name="product_name" class="form-control rounded-pill"
                                                placeholder="اسم المنتج">
                                        </div>
                                        <div class="pt-3" style="width: 100%">
                                            <input type="text" name="product_type" class="form-control rounded-pill"
                                                placeholder="نوع المنتج">
                                        </div>
                                        <div class="pt-3" style="width: 100%">
                                            <select class="form-control rounded-pill" name="product_size">
                                                <option selected>وحدة المنتج</option>
                                                @foreach (App\Model\Product::SIZE as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="pt-3" style="width: 100%">
                                            <input type="text" name="qty_in_unit" class="form-control rounded-pill"
                                                placeholder="الكمية فى كل وحدة">
                                        </div>
                                        <div class="pt-3" style="width: 100%">
                                            <input type="text" name="product_price" class="form-control rounded-pill"
                                                placeholder="سعر المنتج">
                                        </div>
                                        <div class="pt-3" style="width: 100%">
                                            <input type="text" name="purchase_price" class="form-control rounded-pill"
                                                placeholder="سعر الشراء">
                                        </div>
                                        <div class="pt-3" style="width: 100%">
                                            <input type="text" name="qty_in_stock" class="form-control rounded-pill"
                                                placeholder="الكمية المتواجدة بالمستودع">
                                        </div>

                                        <div  class="p-2 border border-dashed mx-auto d-block mt-3"  style="width: 150px;max-width:430px;">
                                            <div class="row" id="thumbnail2"></div>
                                        </div>

                                    </div>
                                    <button type="submit" class="btn btn-primary rounded-pill"
                                        style="width: 100%;background: #645cb3;border:none">ارسال الطلب</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
