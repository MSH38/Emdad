<div class="card">
    <div class="card-body d-flex justify-content-between">
        <div>
            <h1>{{ count($orders) }} طلبات</h1>
        </div>
        <div class="d-lg-block d-md-none d-sm-none">
            <form action="{{ url()->current() }}" method="GET">
                <!-- Search -->
                <div class="input-group input-group-merge input-group-flush">
                    <input id="datatableSearch_" type="search" name="search" class="form-control"
                        placeholder="{{\App\CPU\translate('search')}}" aria-label="Search orders" value="{{ $search }}" required>
                    <button type="submit" class="btn"><i class="tio-search"></i></button>
                </div>
                <!-- End Search -->
            </form>
        </div>

        <div class="d-flex justify-content-between w-50" >
            <div>
                <h3 class="active" ><a href="{{ route('seller.orders.list','all') }}" style="color:#888 !important">طلبات الشراء</a></h3>
                <div class="{{Request::is('seller/orders/list/all')?'activation':''}}"></div>
            </div>
            <div>
                <h3 class=""><a href=" {{ route('seller.orders.list','today') }}" style="color:#888 !important">الشحنات الحالية</a></h3>
                <div class="{{Request::is('seller/orders/list/today')?'activation':''}}"></div>

            </div>
            <div>
                <h3 class="pl-3"><a href="{{ route('seller.orders.list','last') }}" style="color:#888 !important">الشحنات السابقة</a></h3>
                <div class="{{Request::is('seller/orders/list/last')?'activation':''}}"></div>
            </div>
        </div>
    </div>
</div>
