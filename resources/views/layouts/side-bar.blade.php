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

        @php($user_routes = ['manage.users', 'user.add', 'user.update', 'user.detail'])
        <li @class(['menu-item', 'active' => isRouteActive($user_routes)])>
            <a href="{{route('manage.users')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Manage Users">Manage Users</div>
            </a>
        </li>

        @php($roles_routes = ['manage.roles', 'role.update', 'role.detail', 'role.add'])
        <li @class(['menu-item', 'active' => isRouteActive($roles_routes)])>
            <a href="{{route('manage.roles')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-voice"></i>
                <div data-i18n="Roles">Roles</div>
            </a>
        </li>

    </ul>
</aside>
