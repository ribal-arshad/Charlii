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

        @can('book.access')
            @php($book_routes = ['manage.books', 'book.add', 'book.update', 'book.detail'])
            <li @class(['menu-item', 'active' => isRouteActive($book_routes)])>
                <a href="{{route('manage.books')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book"></i>
                    <div data-i18n="Books">Books</div>
                </a>
            </li>
        @endcan

        @can('premise.access')
            @php($premise_routes = ['manage.premises', 'premise.add', 'premise.update', 'premise.detail'])
            <li @class(['menu-item', 'active' => isRouteActive($premise_routes)])>
                <a href="{{route('manage.premises')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-building-house"></i>
                    <div data-i18n="Premises">Premises</div>
                </a>
            </li>
        @endcan

        @can('outline.access')
            @php($outline_routes = ['manage.outlines', 'outline.add', 'outline.update', 'outline.detail'])
            <li @class(['menu-item', 'active' => isRouteActive($outline_routes)])>
                <a href="{{route('manage.outlines')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-square"></i>
                    <div data-i18n="Outlines">Outlines</div>
                </a>
            </li>
        @endcan

        @can('chapter.access')
            @php($chapter_routes = ['manage.chapters', 'chapter.add', 'chapter.update', 'chapter.detail'])
            <li @class(['menu-item', 'active' => isRouteActive($chapter_routes)])>
                <a href="{{route('manage.chapters')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book-open"></i>
                    <div data-i18n="Chapters">Chapters</div>
                </a>
            </li>
        @endcan

        @can('card.access')
            @php($card_routes = ['manage.cards', 'card.add', 'card.update', 'card.detail'])
            <li @class(['menu-item', 'active' => isRouteActive($card_routes)])>
                <a href="{{route('manage.cards')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book-bookmark"></i>
                    <div data-i18n="Chapter Cards">Chapter Cards</div>
                </a>
            </li>
        @endcan
    </ul>
</aside>
