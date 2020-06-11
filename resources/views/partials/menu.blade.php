<div class="sidebar">
    <p>
        <img src={{ asset("assets/images/humanpictos.svg")}} class="icon-logo">
    </p>
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item" style="margin-top: 0px !important;">

                <a href="{{ route("admin.home") }}" class="nav-link {{ request()->is('admin.home') || request()->is('admin/home/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-tachometer-alt nav-icon">

                    </i>
{{--                    {{ trans('cruds.match.title') }}--}}
                    Dashboard
                </a>
            </li>

            @can('match_access')
                <li class="nav-item">
                    <a href="{{ route("admin.matches.index") }}" class="nav-link {{ request()->is('admin/matches') || request()->is('admin/matches/*') ? 'active' : '' }}">
                        <i class="fa-fw nav-icon fa fa-futbol-o">

                        </i>
                        {{ trans('cruds.match.title_singular') }}
                    </a>
                </li>
            @endcan


            @can('user_access')
                <li class="nav-item">
                    <a href="{{ route("admin.bonuses.index") }}" class="nav-link {{ request()->is('admin/bonuses') || request()->is('admin/bonuses/*') ? 'active' : '' }}">
                        <i class="fas fa-gift nav-icon">

                        </i>
                        {{ trans('cruds.bonus.title_singular') }}
                    </a>
                </li>
            @endcan

            @can('user_access')
                <li class="nav-item">
                    <a href="{{ route("admin.players.index") }}" class="nav-link {{ request()->is('admin/players') || request()->is('admin/players/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-user-friends nav-icon">

                        </i>
                        {{ trans('cruds.player.title_singular') }}

                    </a>
                </li>
            @endcan

            @can('user_access')
                <li class="nav-item">
                    <a href="{{ route("admin.bookings.index") }}" class="nav-link {{ request()->is('admin/bookings') || request()->is('admin/bookings/*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-check nav-icon">

                        </i>
                        {{ trans('cruds.booking.title_singular') }}
                    </a>
                </li>
            @endcan

{{--            @can('user_access')--}}
{{--                <li class="nav-item">--}}
{{--                    <a href="{{ route("admin.payments.index") }}" class="nav-link {{ request()->is('admin/payments') || request()->is('admin/payments/*') ? 'active' : '' }}">--}}
{{--                        <i class="fas fa-money-check-alt nav-icon">--}}

{{--                        </i>--}}
{{--                        payment--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            @endcan--}}


            @can('user_access')
                <li class="nav-item">
                    <a href="{{ route("admin.activities.index") }}" class="nav-link {{ request()->is('admin/activities') || request()->is('admin/activities/*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line nav-icon">

                        </i>
                        {{ trans('cruds.activity.title_singular') }}
                    </a>
                </li>
            @endcan

            @can('user_access')
                <li class="nav-item">
                    <a href="{{ route("admin.transactions.index") }}" class="nav-link {{ request()->is('admin/transactions') || request()->is('admin/transactions/*') ? 'active' : '' }}">
                        <i class="fas fa-history nav-icon">

                        </i>
                        Transaction
                    </a>
                </li>
            @endcan



{{--            @can('user_management_access')--}}
{{--                <li class="nav-item nav-dropdown">--}}
{{--                    <a class="nav-link  nav-dropdown-toggle" href="#">--}}
{{--                        <i class="fa-fw fas fa-users nav-icon">--}}

{{--                        </i>--}}
{{--                        {{ trans('cruds.userManagement.title') }}--}}
{{--                    </a>--}}
{{--                    <ul class="nav-dropdown-items">--}}
{{--                        @can('permission_access')--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">--}}
{{--                                    <i class="fa-fw fas fa-unlock-alt nav-icon">--}}

{{--                                    </i>--}}
{{--                                    {{ trans('cruds.permission.title') }}--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endcan--}}
{{--                        @can('role_access')--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">--}}
{{--                                    <i class="fa-fw fas fa-briefcase nav-icon">--}}

{{--                                    </i>--}}
{{--                                    {{ trans('cruds.role.title') }}--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endcan--}}
{{--                        @can('user_access')--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">--}}
{{--                                    <i class="fa-fw fas fa-user nav-icon">--}}

{{--                                    </i>--}}
{{--                                    {{ trans('cruds.user.title') }}--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endcan--}}
{{--                    </ul>--}}
{{--                </li>--}}
{{--            @endcan--}}

{{--            @can('category_access')--}}
{{--                <li class="nav-item">--}}
{{--                    <a href="{{ route("admin.categories.index") }}" class="nav-link {{ request()->is('admin/categories') || request()->is('admin/categories/*') ? 'active' : '' }}">--}}
{{--                        <i class="fa-fw fas fa-tags nav-icon">--}}

{{--                        </i>--}}
{{--                        {{ trans('cruds.category.title') }}--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            @endcan--}}
{{--            @can('shop_access')--}}
{{--                <li class="nav-item">--}}
{{--                    <a href="{{ route("admin.shops.index") }}" class="nav-link {{ request()->is('admin/shops') || request()->is('admin/shops/*') ? 'active' : '' }}">--}}
{{--                        <i class="fa-fw fas fa-shopping-basket nav-icon">--}}

{{--                        </i>--}}
{{--                        {{ trans('cruds.shop.title') }}--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            @endcan--}}


            @can('user_access')
                <li class="nav-item">
                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-user-shield nav-icon">

                        </i>
                        {{ trans('cruds.user.title_singular') }}
                    </a>
                </li>
            @endcan


            <li class="nav-item mt-5">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>

    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
