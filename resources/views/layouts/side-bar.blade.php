<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" style="background: white !important;">

    <div class="app-brand demo">
        <a href="{{route('dashboard')}}" class="app-brand-link">
              <span class="app-brand-logo demo">
               <img src="{{asset('assets/img/logo/logo.png')}}">
              </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2" style="color: #516377">CHARLII</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx menu-toggle-icon d-none d-xl-block fs-4 align-middle"></i>
            <i class="bx bx-x d-block d-xl-none bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item">
            <a href="{{route('dashboard')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        @can('manage.users')
        @php($user_routes = ['manage.users', 'user.add', 'user.update', 'user.detail'])
        <li @class(['menu-item', 'active' => isRouteActive($user_routes)])>
            <a href="{{route('manage.users')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Manage Users">Manage Users</div>
            </a>
        </li>
        @endcan

        @can('role.access')
        @php($roles_routes = ['manage.roles', 'role.update', 'role.detail', 'role.add'])
        <li @class(['menu-item', 'active' => isRouteActive($roles_routes)])>
            <a href="{{route('manage.roles')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-voice"></i>
                <div data-i18n="Roles">Roles</div>
            </a>
        </li>
        @endcan

        @can('user.gallery.access')
            @php($gallery_routes = ['manage.user.gallery', 'user.gallery.add', 'user.gallery.update', 'user.gallery.detail'])
            <li @class(['menu-item', 'active' => isRouteActive($gallery_routes)])>
                <a href="{{route('manage.user.gallery')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-image-alt"></i>
                    <div data-i18n="User Gallery">User Gallery</div>
                </a>
            </li>
        @endcan

        @can('color.access')
            @php($color_routes = ['manage.colors', 'color.add', 'color.update', 'color.detail'])
            <li @class(['menu-item', 'active' => isRouteActive($color_routes)])>
                <a href="{{route('manage.colors')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-color-fill"></i>
                    <div data-i18n="Colors">Colors</div>
                </a>
            </li>
        @endcan

        @can('calendar.access')
            @php($calendar_routes = ['manage.calendars', 'calendar.add', 'calendar.update', 'calendar.detail'])
            <li @class(['menu-item', 'active' => isRouteActive($calendar_routes)])>
                <a href="{{route('manage.calendars')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-calendar"></i>
                    <div data-i18n="Calendars">Calendars</div>
                </a>
            </li>
        @endcan

        @can('series.access')
            @php($series_routes = ['manage.series', 'series.add', 'series.update', 'series.detail'])
            <li @class(['menu-item', 'active' => isRouteActive($series_routes)])>
                <a href="{{route('manage.series')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-movie"></i>
                    <div data-i18n="Series">Series</div>
                </a>
            </li>
        @endcan
    </ul>
</aside>
