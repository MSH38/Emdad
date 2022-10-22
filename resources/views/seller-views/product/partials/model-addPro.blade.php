<div class="modal fade bd-example-modal-lg" id="modaldemo7" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
            <div class="row">
                <div class="col-md-4 col-12 p-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <img src="" width="100" alt="" class="mx-auto d-block" id="product_image">
                                <h3 id="product_name"></h3>
                                <h4 id="unit_num" class="text-muted"></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-12 p-3">
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <form action="{{ route('seller.product.addProductModel') }}" method="POST" id="product_form">
                                    @csrf
                                    <h3>السعر الاساسى</h3>
                                    <div class="form-group d-flex justify-content-between">
                                        <div class="d-flex" style="width: 100%">
                                            <input type="text" name="unit_price" class="form-control rounded-pill w-50" value="" placeholder="سعر البيع" id="product_price">
                                            <input type="text" name="purchase_price" class="form-control rounded-pill mr-1 w-50" placeholder="سعر الشراء">
                                            <input type="hidden" name="product_id" value="" id="product_id">
                                            <span class="text-muted pt-2 pr-2">ريال</span>
                                        </div>
                                        <button type="button" onclick="check()" class="btn btn-primary rounded-pill" style="width: 50%">اضافة المنتج</button>
                                    </div>
                                </form>
                                <form action="{{ route('seller.product.addMultiPriceProductModel') }}" method="POST"  id="product_form2">
                                    @csrf
                                    <h3 for="">تغير السعر حسب الحجم</h3>
                                    <div class="d-flex">
                                        <div class="form-group" style="width: 135px;">
                                            <input type="hidden" name="product_id" value="" id="product_id2">
                                            <input type="hidden" name="unit_price" value="" id="unit_price2">
                                            <label for="">الكمية من</label>
                                            <input type="text" name="from_qty" class="form-control rounded-pill w-50">

                                        </div>
                                        <div class="form-group" style="width: 135px;">
                                            <label for="">الكمية الى</label>
                                            <input type="text" name="to_qty" class="form-control rounded-pill w-50">
                                        </div>
                                        <div class="form-group" style="width: 135px;">
                                            <label for="">سعر البيع</label>
                                            <input type="text" name="unit_price" class="form-control rounded-pill w-50">
                                            <span class="text-muted pt-2 pr-2">ريال</span>
                                        </div>
                                        <div class="form-group" style="width: 135px;">
                                            <label for="">سعر الشراء</label>
                                            <input type="text" name="purchase_price" class="form-control rounded-pill w-50">
                                            <span class="text-muted pt-2 pr-2">ريال</span>
                                        </div>
                                    </div>
                                    <button type="button" onclick="checkPro()" class="btn btn-success rounded-pill" style="width: 100%">اضافة المنتج</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      </div>
    </div>
  </div>
