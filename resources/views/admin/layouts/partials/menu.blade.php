<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.dashboard.index') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img width="58" height="40" src="{{ asset('assets/nafu/nafu-logo.png') }}" alt="Nafu Services"
                    style="object-fit:contain;background:#333f23;border-radius:20px;padding:5px 7px">
            </span>
            <span class="app-brand-text demo menu-text fw-bold">NAFU</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        @if (userHasPermission('admin.dashboard.index'))
            <li class="menu-item {{ request()->routeIs('admin.dashboard.index') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-smart-home"></i>
                    <div>Dashboards</div>
                </a>
            </li>
        @endif
        <!-- /. Dashboards -->
        
        <!-- E-COMMERCE -->
        @if (userHasAnyPermission(['admin.ecom_orders.index', 'admin.ecom_products.index', 'admin.ecom_coupons.index', 'admin.ecom_inventory.index']))
            <li class="menu-header small"><span class="menu-header-text">E-COMMERCE</span></li>
            @if (userHasPermission('admin.ecom_orders.index'))
                <li class="menu-item {{ request()->routeIs('admin.ecom_orders*') ? 'active' : '' }}">
                    <a href="{{ route('admin.ecom_orders.index') }}" class="menu-link">
                        <i class="menu-icon ti ti-shopping-cart"></i>
                        <div>Orders</div>
                    </a>
                </li>
            @endif
            @if (userHasPermission('admin.ecom_customers.index') || true)
                <li class="menu-item {{ request()->routeIs('admin.ecom_customers*') ? 'active' : '' }}">
                    <a href="{{ route('admin.ecom_customers.index') }}" class="menu-link">
                        <i class="menu-icon ti ti-users"></i>
                        <div>Customers</div>
                    </a>
                </li>
            @endif
            @if (userHasPermission('admin.ecom_products.index'))
                <li class="menu-item {{ request()->routeIs('admin.ecom_products*') ? 'active' : '' }}">
                    <a href="{{ route('admin.ecom_products.index') }}" class="menu-link">
                        <i class="menu-icon ti ti-box"></i>
                        <div>Products</div>
                    </a>
                </li>
            @endif
            @if (userHasPermission('admin.ecom_inventory.index'))
                <li class="menu-item {{ request()->routeIs('admin.ecom_inventory*') ? 'active' : '' }}">
                    <a href="{{ route('admin.ecom_inventory.index') }}" class="menu-link">
                        <i class="menu-icon ti ti-building-warehouse"></i>
                        <div>Inventory</div>
                    </a>
                </li>
            @endif
            @if (userHasPermission('admin.ecom_coupons.index'))
                <li class="menu-item {{ request()->routeIs('admin.ecom_coupons*') ? 'active' : '' }}">
                    <a href="{{ route('admin.ecom_coupons.index') }}" class="menu-link">
                        <i class="menu-icon ti ti-ticket"></i>
                        <div>Coupons</div>
                    </a>
                </li>
            @endif
            @if (userHasPermission('admin.ecom_bundles.index'))
                <li class="menu-item {{ request()->routeIs('admin.ecom_bundles*') ? 'active' : '' }}">
                    <a href="{{ route('admin.ecom_bundles.index') }}" class="menu-link">
                        <i class="menu-icon ti ti-packages"></i>
                        <div>Bundles</div>
                    </a>
                </li>
            @endif
            @if (userHasPermission('admin.ecom_legal.index') || true)
                <li class="menu-item {{ request()->routeIs('admin.ecom_legal*') ? 'active' : '' }}">
                    <a href="{{ route('admin.ecom_legal.index') }}" class="menu-link">
                        <i class="menu-icon ti ti-scale"></i>
                        <div>Legal Policies</div>
                    </a>
                </li>
            @endif
        @endif

        @if (userHasAnyPermission(['admin.projects.index']))
            <li class="menu-header small"><span class="menu-header-text">PROJECTS</span></li>
            <li class="menu-item {{ request()->routeIs('admin.projects*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle"><i class="menu-icon ti ti-briefcase"></i><div>Projects</div></a>
                <ul class="menu-sub">
                    @if (userHasPermission('admin.projects.create'))<li class="menu-item"><a href="{{ route('admin.projects.create') }}" class="menu-link"><div>Create project</div></a></li>@endif
                    <li class="menu-item"><a href="{{ route('admin.projects.index') }}" class="menu-link"><div>Project list</div></a></li>
                </ul>
            </li>
        @endif
        @if (userHasAnyPermission(['admin.services.index']))
            <li class="menu-header small"><span class="menu-header-text">SERVICES</span></li>
            <li class="menu-item {{ request()->routeIs('admin.services*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle"><i class="menu-icon ti ti-layout-grid"></i><div>Services</div></a>
                <ul class="menu-sub">
                    @if (userHasPermission('admin.services.create'))
                        <li class="menu-item {{ request()->routeIs('admin.services.create') ? 'active' : '' }}"><a href="{{ route('admin.services.create') }}" class="menu-link"><div>Create service</div></a></li>
                    @endif
                    <li class="menu-item {{ request()->routeIs('admin.services.index') || request()->routeIs('admin.services.edit') ? 'active' : '' }}"><a href="{{ route('admin.services.index') }}" class="menu-link"><div>Service list</div></a></li>
                </ul>
            </li>
        @endif

        @if (userHasAnyPermission(['admin.news.index']))
            <li class="menu-header small"><span class="menu-header-text">NEWS</span></li>
            <li class="menu-item {{ request()->routeIs('admin.news*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon ti ti-news"></i>
                    <div>News</div>
                </a>
                <ul class="menu-sub">
                    @if (userHasPermission('admin.news.create'))
                        <li class="menu-item {{ request()->routeIs('admin.news.create') ? 'active' : '' }}">
                            <a href="{{ route('admin.news.create') }}" class="menu-link"><div>Create article</div></a>
                        </li>
                    @endif
                    <li class="menu-item {{ request()->routeIs('admin.news.index') || request()->routeIs('admin.news.edit') ? 'active' : '' }}">
                        <a href="{{ route('admin.news.index') }}" class="menu-link"><div>Article list</div></a>
                    </li>
                </ul>
            </li>
        @endif
        @if (userHasAnyPermission(['admin.contacts.index']))
            <li class="menu-header small"><span class="menu-header-text">CUSTOMERS</span></li>
            <li class="menu-item {{ request()->routeIs('admin.contacts*') ? 'active' : '' }}">
                <a href="{{ route('admin.contacts.index') }}" class="menu-link">
                    <i class="menu-icon ti ti-messages"></i>
                    <div>Enquiries</div>
                </a>
            </li>
        @endif
        <!-- Categories -->
        @if (userHasAnyPermission([
            ]))
            <li class="menu-header small">
                <span class="menu-header-text" data-i18n="CATEGORIES">CATEGORIES</span>
            </li>
            <li
                class="menu-item {{ request()->routeIs('admin.departments*')
                    ? 'active open'
                    : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-category"></i>
                    <div data-i18n="Categories">Categories</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('admin.dashboard.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-smart-home"></i>
                            <div>Dashboards</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        <!-- /. Categories -->

        <!-- Systems -->
        @if (userHasAnyPermission([
                'admin.systems.generals',
                'admin.systems.apis',
                'admin.systems.edit',
                'admin.users.index',
                'admin.roles.index',
                'admin.coach-systems.edit',
            ]))
            <li class="menu-header small">
                <span class="menu-header-text" data-i18n="SYSTEM SETTINGS">SYSTEM SETTINGS</span>
            </li>
            <li
                class="menu-item {{ request()->routeIs('admin.systems*') |
                request()->routeIs('admin.roles*') |
                request()->routeIs('admin.users*') |
                request()->routeIs('admin.coach-systems*')
                    ? 'active open'
                    : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-settings"></i>
                    <div data-i18n="System settings">System settings</div>
                </a>
                <ul class="menu-sub">
                    @if (userHasAnyPermission(['admin.users.index', 'admin.roles.index']))
                        <li
                            class="menu-item {{ request()->routeIs('admin.roles*') | request()->routeIs('admin.user*') ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons ti ti-shopping-cart"></i>
                                <div data-i18n="Access control">Access control</div>
                            </a>
                            <ul class="menu-sub">
                                @if (userHasPermission('admin.users.index'))
                                    <li class="menu-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                                        <a href="{{ route('admin.users.index') }}" class="menu-link">
                                            <div data-i18n="User list">User list</div>
                                        </a>
                                    </li>
                                @endif

                                @if (userHasPermission('admin.roles.index'))
                                    <li class="menu-item {{ request()->routeIs('admin.roles*') ? 'active' : '' }}">
                                        <a href="{{ route('admin.roles.index') }}" class="menu-link">
                                            <div data-i18n="Role list">Role list</div>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (userHasAnyPermission([
                            'admin.systems.generals',
                            'admin.systems.pages',
                            'admin.systems.apis',
                            'admin.systems.edit',
                            'admin.coach-systems.generals',
                            'admin.coach-systems.apis',
                            'admin.coach-systems.edit',
                        ]))
                        <li
                            class="menu-item {{ request()->routeIs('admin.systems*') | request()->routeIs('admin.coach-systems*') ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons ti ti-shopping-cart"></i>
                                <div data-i18n="General settings">General settings</div>
                            </a>
                            <ul class="menu-sub">


                                @if (userHasPermission('admin.systems.generals'))
                                        <li class="menu-item {{ request()->routeIs('admin.systems.generals') ? 'active' : '' }}">
                                            <a href="{{ route('admin.systems.generals') }}" class="menu-link">
                                                <div data-i18n="General">General</div>
                                            </a>
                                        </li>
                                @endif
                                @if (userHasPermission('admin.systems.pages'))
                                    <li class="menu-item {{ request()->routeIs('admin.systems.pages') ? 'active' : '' }}">
                                        <a href="{{ route('admin.systems.pages') }}" class="menu-link">
                                            <div data-i18n="Pages">Pages</div>
                                        </a>
                                    </li>
                                @endif
                                {{-- @if (userHasPermission('admin.systems.apis'))
                                    <li
                                        class="menu-item {{ request()->routeIs('admin.systems.apis') ? 'active' : '' }}">
                                        <a href="{{ route('admin.systems.apis') }}" class="menu-link">
                                            <div data-i18n="APIs">APIs</div>
                                        </a>
                                    </li>
                                @endif --}}

                                @if (userHasPermission('admin.systems.socials'))
                                    <li
                                        class="menu-item {{ request()->routeIs('admin.systems.socials') ? 'active' : '' }}">
                                        <a href="{{ route('admin.systems.socials') }}" class="menu-link">
                                            <div data-i18n="Social media">Social media</div>
                                        </a>
                                    </li>
                                @endif
                                {{--
                                @if (userHasPermission('admin.systems.config-contracts'))
                                    <li
                                        class="menu-item {{ request()->routeIs('admin.systems.config-contracts') ? 'active' : '' }}">
                                        <a href="{{ route('admin.systems.config-contracts') }}" class="menu-link">
                                            <div data-i18n="Contract">Hợp đồng</div>
                                        </a>
                                    </li>
                                @endif --}}
                                {{-- @if (userHasPermission('admin.systems.config-shareholders'))
                                    <li
                                        class="menu-item {{ request()->routeIs('admin.systems.config-shareholders') ? 'active' : '' }}">
                                        <a href="{{ route('admin.systems.config-shareholders') }}" class="menu-link">
                                            <div data-i18n="shareholder">shareholder</div>
                                        </a>
                                    </li>
                                @endif --}}



                                {{-- @if (userHasPermission('admin.systems.notifications'))
                                    <li
                                        class="menu-item {{ request()->routeIs('admin.systems.notifications') ? 'active' : '' }}">
                                        <a href="{{ route('admin.systems.notifications') }}" class="menu-link">
                                            <div data-i18n="Notifications">Notifications</div>
                                        </a>
                                    </li>
                                @endif --}}
                            </ul>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
        <!-- /. Systems -->
    </ul>
</aside>
