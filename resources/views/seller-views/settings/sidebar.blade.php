<div class="card">
    <div class="card-body">
        <ul class="navbar-nav navbar-nav-lg nav-tabs">
            <li class="navbar-vertical-aside-has-menu {{Request::is('seller/settings/alerts')?'active':''}}">
                <a class="js-navbar-vertical-aside-menu-link nav-link"
                   href="{{route('seller.settings.alerts')}}">
                    <i class="fa fa-bell nav-icon"></i>
                    <span
                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate text-capitalize">
                            التنبيهات
                    </span>
                </a>
            </li>
            <li class="navbar-vertical-aside-has-menu {{Request::is('seller/settings/operational-details')?'active':''}}">
                <a class="js-navbar-vertical-aside-menu-link nav-link"
                   href="{{route('seller.settings.operational_details')}}">
                    <i class="fa fa-file nav-icon"></i>
                    <span
                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate text-capitalize">
                            التفاصيل التشغيلية
                    </span>
                </a>
            </li>
            <li class="navbar-vertical-aside-has-menu {{Request::is('seller/settings/employees')?'active':''}}">
                <a class="js-navbar-vertical-aside-menu-link nav-link"
                   href="{{route('seller.settings.employees')}}">
                    <i class="fa fa-users nav-icon"></i>
                    <span
                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate text-capitalize">
                            الموظفين
                    </span>
                </a>
            </li>

            <li class="navbar-vertical-aside-has-menu {{Request::is('seller/settings/workTime')?'active':''}}">
                <a class="js-navbar-vertical-aside-menu-link nav-link"
                   href="{{route('seller.settings.workTime')}}">
                    <i class="fa fa-clock nav-icon"></i>
                    <span
                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate text-capitalize">
                            تجديد اوقات العمل
                    </span>
                </a>
            </li>

        </ul>
    </div>
</div>
