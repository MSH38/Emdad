<style>
    .navbar-vertical .nav-link {
        color: #041562;

    }

    .navbar .nav-link:hover {
        color: #041562;
    }

    .navbar .active > .nav-link, .navbar .nav-link.active, .navbar .nav-link.show, .navbar .show > .nav-link {
        color: #F14A16;
    }

    .navbar-vertical .active .nav-indicator-icon, .navbar-vertical .nav-link:hover .nav-indicator-icon, .navbar-vertical .show > .nav-link > .nav-indicator-icon {
        color: #F14A16;
    }

    .nav-subtitle {
        display: block;
        color: #041562;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .03125rem;
    }

    .side-logo {
        background-color: #ffffff;
    }

    .nav-sub {
        background-color: #ffffff!important;
    }

    .nav-indicator-icon {
        margin-left: {{Session::get('direction') === "rtl" ? '6px' : ''}};
    }
</style>
<div id="sidebarMain" class="d-none">
    <aside
        style="background: #ffffff!important; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
        class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
        <div class="navbar-vertical-container">
            <div class="navbar-vertical-footer-offset" style="padding-bottom: 0">
                <div class="navbar-brand-wrapper justify-content-between side-logo">
                    <!-- Logo -->
                    @php($shop=\App\Model\Shop::where(['seller_id'=>auth('seller')->id()])->first())
                    <a class="navbar-brand" href="{{route('seller.dashboard.index')}}" aria-label="Front">
                        @if (isset($shop))
                            <!--<img onerror="this.src='http://localhost/sare/storage/public/company/2022-06-20-62b0d4a963f4e.png'"-->
                            <!--    class="navbar-brand-logo-mini for-seller-logo"-->
                            <!--    src="{{asset("storage/public/shop/$shop->image")}}" alt="Logo">-->
                            <h1 style="color: #645cb3;font-weight:bold;font-size: 30px;">امداد</h1>
                        @else
                            <img class="navbar-brand-logo-mini for-seller-logo"
                                src="http://localhost/sare/storage/public/company/2022-06-20-62b0d4a963f4e.png" alt="Logo" style="width: 5rem !important;height: 4rem !important">
                        @endif
                    </a>
                    <!-- End Logo -->

                    <!-- Navbar Vertical Toggle -->
                    <button type="button"
                            class="js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs btn-ghost-dark">
                        <i class="tio-clear tio-lg"></i>
                    </button>
                    <!-- End Navbar Vertical Toggle -->
                </div>

                <!-- Content -->
                <div class="navbar-vertical-content">
                    <div class="pt-3 pr-3 pb-3">
                        {{-- <div class="avatar avatar-sm avatar-circle">
                            <img class="avatar-img"
                                 onerror="this.src='{{asset('assets/back-end/img/160x160/img1.jpg')}}'"
                                 src="{{asset('storage/public/seller/')}}/{{auth('seller')->user()->image}}"
                                 alt="Image Description">
                            <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                        </div> --}}
                        {{-- <h4 class="pr-3 pt-1">{{auth('seller')->user()->f_name}} {{auth('seller')->user()->l_name}}</h4> --}}

                        <p><strong>الاسم:</strong>{{auth('seller')->user()->f_name}} {{auth('seller')->user()->l_name}}</p>
                        <p><strong>الوظيفة:</strong>Admin</p>
                        <p><strong>رقم الجوال:</strong>{{auth('seller')->user()->phone}}</p>
                    </div>
                    <ul class="navbar-nav navbar-nav-lg nav-tabs">
                        <!-- Dashboards -->
                        <li class="navbar-vertical-aside-has-menu {{Request::is('seller')?'show':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('seller.dashboard.index')}}">
                                <i class="tio-home-vs-1-outlined nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\translate('Dashboard')}}
                                </span>
                            </a>
                        </li>
                        <!-- End Dashboards -->
                        @php($seller = auth('seller')->user())
                        <!-- POS -->
                        @php($sellerId = $seller->id)
                        @php($seller_pos=\App\Model\BusinessSetting::where('type','seller_pos')->first()->value)
                        @if ($seller_pos==1)
                            @if ($seller->pos_status == 1)
                                <li class="nav-item">
                                    <small
                                        class="nav-subtitle">{{\App\CPU\translate('pos')}} {{\App\CPU\translate('system')}} </small>
                                    <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                                </li>

                                <li class="navbar-vertical-aside-has-menu {{Request::is('admin/pos/*')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:">
                                        <i class="tio-shopping nav-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{\App\CPU\translate('POS')}}</span>
                                    </a>
                                    <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                        style="display: {{Request::is('seller/pos/*')?'block':'none'}}">
                                        <li class="nav-item {{Request::is('seller/pos/')?'active':''}}">
                                            <a class="nav-link " href="{{route('seller.pos.index')}}"
                                            title="{{\App\CPU\translate('pos')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span
                                                    class="text-truncate">{{\App\CPU\translate('pos')}}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{Request::is('seller/pos/orders')?'active':''}}">
                                            <a class="nav-link " href="{{route('seller.pos.orders')}}" title="{{\App\CPU\translate('orders')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate">{{\App\CPU\translate('orders')}}
                                                <span class="badge badge-info badge-pill ml-1">
                                                    {{\App\Model\Order::where(['seller_is'=>'seller'])->where(['seller_id'=>$sellerId])->where('order_type','POS')->where(['order_status'=>'delivered'])->count()}}
                                                </span>
                                            </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        @endif

                        <!-- End POS -->



                        <!-- Pages -->
                        <li class="navbar-vertical-aside-has-menu {{Request::is('seller/orders*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:">
                                <i class="fa fa-bell nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\translate('Notifications')}} Not Complete
                                </span>
                            </a>

                            {{-- <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('seller/order*')?'block':'none'}}">

                                <li class="nav-item {{Request::is('seller/orders/list/all')?'active':''}}">
                                    <a class="nav-link " href="{{route('seller.orders.list',['all'])}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('All')}}</span>
                                        <span
                                            class="badge badge-info badge-pill {{Session::get('direction') === "rtl" ? 'mr-1' : 'ml-1'}}">
                                            {{ \App\Model\Order::where('order_type','default_type')->where(['seller_is'=>'seller'])->where(['seller_id'=>$sellerId])->count()}}
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('seller/orders/list/pending')?'active':''}}">
                                    <a class="nav-link " href="{{route('seller.orders.list',['pending'])}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('Pending')}}</span>
                                        <span
                                            class="badge badge-soft-info badge-pill {{Session::get('direction') === "rtl" ? 'mr-1' : 'ml-1'}}">
                                            {{ \App\Model\Order::where('order_type','default_type')->where(['seller_is'=>'seller'])->where(['seller_id'=>$sellerId])->where(['order_status'=>'pending'])->count()}}
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('seller/orders/list/confirmed')?'active':''}}">
                                    <a class="nav-link " href="{{route('seller.orders.list',['confirmed'])}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('confirmed')}}</span>
                                        <span
                                            class="badge badge-soft-info badge-pill {{Session::get('direction') === "rtl" ? 'mr-1' : 'ml-1'}}">
                                            {{ \App\Model\Order::where('order_type','default_type')->where(['seller_is'=>'seller'])->where(['seller_id'=>$sellerId])->where(['order_status'=>'confirmed'])->count()}}
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('seller/orders/list/processing')?'active':''}}">
                                    <a class="nav-link " href="{{route('seller.orders.list',['processing'])}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('Processing')}}</span>
                                        <span
                                            class="badge badge-warning badge-pill {{Session::get('direction') === "rtl" ? 'mr-1' : 'ml-1'}}">
                                            {{ \App\Model\Order::where('order_type','default_type')->where(['seller_is'=>'seller'])->where(['seller_id'=>$sellerId])->where(['order_status'=>'processing'])->count()}}
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('seller/orders/list/out_for_delivery')?'active':''}}">
                                    <a class="nav-link " href="{{route('seller.orders.list',['out_for_delivery'])}}"
                                       title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('out_for_delivery')}}</span>
                                        <span
                                            class="badge badge-warning badge-pill {{Session::get('direction') === "rtl" ? 'mr-1' : 'ml-1'}}">
                                            {{ \App\Model\Order::where('order_type','default_type')->where(['seller_is'=>'seller'])->where(['seller_id'=>$sellerId])->where(['order_status'=>'out_for_delivery'])->count()}}
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('seller/orders/list/delivered')?'active':''}}">
                                    <a class="nav-link " href="{{route('seller.orders.list',['delivered'])}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('Delivered')}}</span>
                                        <span
                                            class="badge badge-success badge-pill {{Session::get('direction') === "rtl" ? 'mr-1' : 'ml-1'}}">
                                            {{ \App\Model\Order::where('order_type','default_type')->where(['seller_is'=>'seller'])->where(['seller_id'=>$sellerId])->where(['order_status'=>'delivered'])->count()}}
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('seller/orders/list/returned')?'active':''}}">
                                    <a class="nav-link " href="{{route('seller.orders.list',['returned'])}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('Returned')}}</span>
                                        <span
                                            class="badge badge-soft-danger badge-pill {{Session::get('direction') === "rtl" ? 'mr-1' : 'ml-1'}}">
                                            {{ \App\Model\Order::where('order_type','default_type')->where(['seller_is'=>'seller'])->where(['seller_id'=>$sellerId])->where(['order_status'=>'returned'])->count()}}
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('seller/orders/list/failed')?'active':''}}">
                                    <a class="nav-link " href="{{route('seller.orders.list',['failed'])}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('Failed')}}</span>
                                        <span
                                            class="badge badge-danger badge-pill {{Session::get('direction') === "rtl" ? 'mr-1' : 'ml-1'}}">
                                            {{ \App\Model\Order::where('order_type','default_type')->where(['seller_is'=>'seller'])->where(['seller_id'=>$sellerId])->where(['order_status'=>'failed'])->count()}}
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('seller/orders/list/canceled')?'active':''}}">
                                    <a class="nav-link " href="{{route('seller.orders.list',['canceled'])}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('canceled')}}</span>
                                        <span
                                            class="badge badge-danger badge-pill {{Session::get('direction') === "rtl" ? 'mr-1' : 'ml-1'}}">
                                            {{ \App\Model\Order::where('order_type','default_type')->where(['seller_is'=>'seller'])->where(['seller_id'=>$sellerId])->where(['order_status'=>'canceled'])->count()}}
                                        </span>
                                    </a>
                                </li>
                            </ul> --}}
                        </li>
                        <!-- End Pages -->

                        <!-- Pages -->
                        <li class="navbar-vertical-aside-has-menu {{(Request::is('seller/product*'))?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:">
                                <i class="fa fa-cube nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    السلع والعروض
                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{(Request::is('seller/product*'))?'block':''}}">
                                <li class="nav-item {{Request::is('seller/product/list')?'active':''}}">
                                    <a class="nav-link " href="{{route('seller.product.list')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('Products')}}</span>
                                    </a>
                                </li>
                                {{-- <li class="nav-item {{Request::is('seller/product/stock-limit-list/in_house')?'active':''}}">
                                    <a class="nav-link " href="{{route('seller.product.stock-limit-list',['in_house', ''])}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('stock_limit_products')}}</span>
                                    </a>
                                </li> --}}
                                @php($mainSeller=\App\Model\Seller::where(['id'=>auth('seller')->id(), 'seller_parent'=>0])->first())
                                    @if (!isset($mainSeller))
                                    <li class="nav-item {{Request::is('seller/product/list-haad')?'active':''}}">
                                        <a class="nav-link " href="{{route('seller.product.list-haad')}}">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">إستيراد من منتجاتنا</span>
                                        </a>
                                    </li>
                                @endif
                                <li class="nav-item {{Request::is('seller/product/bulk-import')?'active':''}}">
                                    <a class="nav-link " href="{{route('seller.product.bulk-import')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('bulk_import')}}</span>
                                    </a>
                                </li>

                            </ul>
                        </li>


                        {{--<li class="navbar-vertical-aside-has-menu {{Request::is('seller/brand*')?'active':''}}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:">
                                    <i class="tio-apple-outlined nav-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{\App\CPU\translate('brands')}}</span>
                                </a>
                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                    style="display: {{Request::is('seller/brand*')?'block':'none'}}">
                                    <li class="nav-item {{Request::is('seller/brand/add-new')?'active':''}}">
                                        <a class="nav-link " href="{{route('seller.brand.add-new')}}">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">{{\App\CPU\translate('add_new')}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{Request::is('seller/brand/list')?'active':''}}">
                                        <a class="nav-link " href="{{route('seller.brand.list')}}">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">{{\App\CPU\translate('List')}}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li> --}}

                        <!-- End Pages -->


                        <!-- Pages -->
                        <li class="navbar-vertical-aside-has-menu {{Request::is('seller/orders*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:">
                                <i class="fa fa-file nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\translate('orders_buy')}}
                                </span>
                            </a>

                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('seller/order*')?'block':'none'}}">

                                <li class="nav-item {{Request::is('seller/orders/list/all')?'active':''}}">
                                    <a class="nav-link " href="{{route('seller.orders.list','all')}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('All')}}</span>
                                        <span
                                            class="badge badge-info badge-pill {{Session::get('direction') === "rtl" ? 'mr-1' : 'ml-1'}}">
                                            {{ \App\Model\Order::where('order_type','default_type')->where(['seller_is'=>'seller'])->where(['seller_id'=>$sellerId])->count()}}
                                        </span>
                                    </a>
                                </li>

                                {{-- <li class="nav-item {{Request::is('seller/orders/list/pending')?'active':''}}">
                                    <a class="nav-link " href="{{route('seller.orders.list',['pending'])}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('Pending')}}</span>
                                        <span
                                            class="badge badge-soft-info badge-pill {{Session::get('direction') === "rtl" ? 'mr-1' : 'ml-1'}}">
                                            {{ \App\Model\Order::where('order_type','default_type')->where(['seller_is'=>'seller'])->where(['seller_id'=>$sellerId])->where(['order_status'=>'pending'])->count()}}
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('seller/orders/list/confirmed')?'active':''}}">
                                    <a class="nav-link " href="{{route('seller.orders.list',['confirmed'])}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('confirmed')}}</span>
                                        <span
                                            class="badge badge-soft-info badge-pill {{Session::get('direction') === "rtl" ? 'mr-1' : 'ml-1'}}">
                                            {{ \App\Model\Order::where('order_type','default_type')->where(['seller_is'=>'seller'])->where(['seller_id'=>$sellerId])->where(['order_status'=>'confirmed'])->count()}}
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('seller/orders/list/processing')?'active':''}}">
                                    <a class="nav-link " href="{{route('seller.orders.list',['processing'])}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('Processing')}}</span>
                                        <span
                                            class="badge badge-warning badge-pill {{Session::get('direction') === "rtl" ? 'mr-1' : 'ml-1'}}">
                                            {{ \App\Model\Order::where('order_type','default_type')->where(['seller_is'=>'seller'])->where(['seller_id'=>$sellerId])->where(['order_status'=>'processing'])->count()}}
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('seller/orders/list/out_for_delivery')?'active':''}}">
                                    <a class="nav-link " href="{{route('seller.orders.list',['out_for_delivery'])}}"
                                       title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('out_for_delivery')}}</span>
                                        <span
                                            class="badge badge-warning badge-pill {{Session::get('direction') === "rtl" ? 'mr-1' : 'ml-1'}}">
                                            {{ \App\Model\Order::where('order_type','default_type')->where(['seller_is'=>'seller'])->where(['seller_id'=>$sellerId])->where(['order_status'=>'out_for_delivery'])->count()}}
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('seller/orders/list/delivered')?'active':''}}">
                                    <a class="nav-link " href="{{route('seller.orders.list',['delivered'])}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('Delivered')}}</span>
                                        <span
                                            class="badge badge-success badge-pill {{Session::get('direction') === "rtl" ? 'mr-1' : 'ml-1'}}">
                                            {{ \App\Model\Order::where('order_type','default_type')->where(['seller_is'=>'seller'])->where(['seller_id'=>$sellerId])->where(['order_status'=>'delivered'])->count()}}
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('seller/orders/list/returned')?'active':''}}">
                                    <a class="nav-link " href="{{route('seller.orders.list',['returned'])}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('Returned')}}</span>
                                        <span
                                            class="badge badge-soft-danger badge-pill {{Session::get('direction') === "rtl" ? 'mr-1' : 'ml-1'}}">
                                            {{ \App\Model\Order::where('order_type','default_type')->where(['seller_is'=>'seller'])->where(['seller_id'=>$sellerId])->where(['order_status'=>'returned'])->count()}}
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('seller/orders/list/failed')?'active':''}}">
                                    <a class="nav-link " href="{{route('seller.orders.list',['failed'])}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('Failed')}}</span>
                                        <span
                                            class="badge badge-danger badge-pill {{Session::get('direction') === "rtl" ? 'mr-1' : 'ml-1'}}">
                                            {{ \App\Model\Order::where('order_type','default_type')->where(['seller_is'=>'seller'])->where(['seller_id'=>$sellerId])->where(['order_status'=>'failed'])->count()}}
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('seller/orders/list/canceled')?'active':''}}">
                                    <a class="nav-link " href="{{route('seller.orders.list',['canceled'])}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('canceled')}}</span>
                                        <span
                                            class="badge badge-danger badge-pill {{Session::get('direction') === "rtl" ? 'mr-1' : 'ml-1'}}">
                                            {{ \App\Model\Order::where('order_type','default_type')->where(['seller_is'=>'seller'])->where(['seller_id'=>$sellerId])->where(['order_status'=>'canceled'])->count()}}
                                        </span>
                                    </a>
                                </li> --}}
                            </ul>
                        </li>
                        <!-- End Pages -->




                        @php($mainSeller=\App\Model\Seller::where(['id'=>auth('seller')->id(), 'seller_parent'=>0])->first())
                        @if (isset($mainSeller))
				        <li class="navbar-vertical-aside-has-menu {{(Request::is('seller/branches/list'))?'active':''}}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                   href="javascript:">
                                    <i class="tio-shop nav-icon"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        <span class="text-truncate">{{\App\CPU\translate('Branche')}}</span>
                                    </span>
                                </a>
                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                    style="display: {{(Request::is('seller/branches/list') || Request::is('seller/branches/list'))?'block':''}}">
                                    <li class="nav-item {{Request::is('seller/branches/list')?'active':''}}">
                                        <a class="nav-link " href="{{route('seller.branches.list')}}">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">{{\App\CPU\translate('list')}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{Request::is('seller/branches/list')?'active':''}}">
                                        <a class="nav-link " href="{{route('seller.branches.add')}}">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">{{\App\CPU\translate('branche_add_new')}}</span>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endif
{{--
                        <li class="navbar-vertical-aside-has-menu {{Request::is('seller/refund*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                               href="javascript:">
                                <i class="tio-receipt-outlined nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\translate('refund_request_list')}}
                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('seller/refund*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('seller/refund/list/pending')?'active':''}}">
                                    <a class="nav-link"
                                       href="{{route('seller.refund.list',['pending'])}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                          {{\App\CPU\translate('pending')}}
                                            <span class="badge badge-soft-danger badge-pill ml-1">
                                                {{\App\Model\RefundRequest::whereHas('order', function ($query) {
                                                    $query->where('seller_is', 'seller')->where('seller_id',auth('seller')->id());
                                                        })->where('status','pending')->count()}}
                                            </span>
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('seller/refund/list/approved')?'active':''}}">
                                    <a class="nav-link"
                                       href="{{route('seller.refund.list',['approved'])}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                           {{\App\CPU\translate('approved')}}
                                            <span class="badge badge-soft-info badge-pill ml-1">
                                                {{\App\Model\RefundRequest::whereHas('order', function ($query) {
                                                    $query->where('seller_is', 'seller')->where('seller_id',auth('seller')->id());
                                                        })->where('status','approved')->count()}}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('seller/refund/list/refunded')?'active':''}}">
                                    <a class="nav-link"
                                       href="{{route('seller.refund.list',['refunded'])}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                           {{\App\CPU\translate('refunded')}}
                                            <span class="badge badge-success badge-pill ml-1">
                                                {{\App\Model\RefundRequest::whereHas('order', function ($query) {
                                                    $query->where('seller_is', 'seller')->where('seller_id',auth('seller')->id());
                                                        })->where('status','refunded')->count()}}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('seller/refund/list/rejected')?'active':''}}">
                                    <a class="nav-link"
                                       href="{{route('seller.refund.list',['rejected'])}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                           {{\App\CPU\translate('rejected')}}
                                            <span class="badge badge-danger badge-pill ml-1">
                                                {{\App\Model\RefundRequest::whereHas('order', function ($query) {
                                                    $query->where('seller_is', 'seller')->where('seller_id',auth('seller')->id());
                                                        })->where('status','rejected')->count()}}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}


                        {{-- <li class="navbar-vertical-aside-has-menu {{Request::is('seller/shop*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('seller.shop.view')}}">
                                <i class="tio-home nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\translate('my_shop')}}
                                </span>
                            </a>
                        </li> --}}


                        <!-- End Pages -->

                        @php($shippingMethod = \App\CPU\Helpers::get_business_settings('shipping_method'))
                        @if($shippingMethod=='sellerwise_shipping')
                            <li class="navbar-vertical-aside-has-menu {{Request::is('seller/business-settings/shipping-method*')?'active':''}}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                   href="{{route('seller.business-settings.shipping-method.add')}}">
                                    <i class="fa fa-cube nav-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate text-capitalize">
                                        {{\App\CPU\translate('shipping_method')}}
                                    </span>
                                </a>
                            </li>
                        @endif

                         <li class="navbar-vertical-aside-has-menu {{Request::is('seller/business-settings/withdraws*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('seller.business-settings.withdraw.list')}}">
                                <i class="fa fa-cube nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate text-capitalize">
                                        {{\App\CPU\translate('withdraws')}}
                                    </span>
                            </a>
                        </li>

                        <!-- End Pages -->

                        <li class="navbar-vertical-aside-has-menu {{Request::is('seller/business-settings/withdraws*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('seller.performance.index')}}">
                                <i class="fa fa-line-chart nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate text-capitalize">
                                        الاداء
                                    </span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('seller/business-settings/withdraws*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('seller.business-settings.withdraw.list')}}">
                                <i class="fa fa-info-circle nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate text-capitalize">
                                        المساعدة Not Complete
                                    </span>
                            </a>
                        </li>


                        <li class="navbar-vertical-aside-has-menu {{Request::is('seller/settings*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ route('seller.settings.index') }}">
                                <i class="fa fa-cog nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    الاعدادات
                                </span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('seller/business-settings/withdraws*')?'active':''}}">
                            <a class="dropdown-item" href="javascript:" onclick="Swal.fire({
                                title: '{{\App\CPU\translate('Do you want to logout')}}?',
                                showDenyButton: true,
                                showCancelButton: true,
                                confirmButtonColor: '#377dff',
                                cancelButtonColor: '#363636',
                                confirmButtonText: `Yes`,
                                denyButtonText: `Don't Logout`,
                                }).then((result) => {
                                if (result.value) {
                                location.href='{{route('seller.auth.logout')}}';
                                } else{
                                Swal.fire('Canceled', '', 'info')
                                }
                                })">
                                <i class="fa fa-sign-out nav-icon"></i>
                                <span class="text-truncate pr-2" title="Sign out">{{\App\CPU\translate('Sign out')}}</span>
                            </a>
                        </li>



                    {{-- <li class="navbar-vertical-aside-has-menu {{Request::is('seller/delivery-man*')?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                           href="javascript:">
                            <i class="tio-user nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            {{\App\CPU\translate('delivery-man')}}
                        </span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                            style="display: {{Request::is('seller/delivery-man*')?'block':'none'}}">
                            <li class="nav-item {{Request::is('seller/delivery-man/add')?'active':''}}">
                                <a class="nav-link " href="{{route('seller.delivery-man.add')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{\App\CPU\translate('add_new')}}</span>
                                </a>
                            </li>
                            <li class="nav-item {{Request::is('seller/delivery-man/list')?'active':''}}">
                                <a class="nav-link" href="{{route('seller.delivery-man.list')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{\App\CPU\translate('List')}}</span>
                                </a>
                            </li>
                            <li class="nav-item {{Request::is('seller/delivery-man/list')?'active':''}}">
                               <a class="js-navbar-vertical-aside-menu-link nav-link"
                           href="{{route('seller.zone.home')}}" title="{{\App\CPU\translate('zone')}}">
                            <i class="tio-city nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                {{\App\CPU\translate('delivery_zone')}}
                                </span>
                        </a>
                            </li>
                        </ul>
                    </li> --}}

                    </ul>
                </div>
                <!-- End Content -->
            </div>
        </div>
    </aside>
</div>

