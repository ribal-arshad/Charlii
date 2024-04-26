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
        @php($dashboard = ['dashboard'])
        <li @class(['menu-item', 'active'=>isRouteActive($dashboard)])>
            <a href="{{route('dashboard')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>
        @php($routesForPackage = ['package', 'package.add', 'package.update', 'package.detail', 'Package.option', 'Package.option.add', 'Package.option.update', 'Package.option.detail', 'coupon', 'coupon.add', 'coupon.update', 'coupon.detail'])
        <li @class(['menu-item', 'open'=>isRouteActive($routesForPackage)])>
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-package"></i>
                <div data-i18n="Package Management">Package Management</div>
            </a>
            <ul class="menu-sub">
                @can('package.access')
                    @php($package = ['package', 'package.add', 'package.update', 'package.detail'])
                    <li @class(['menu-item','active'=>isRouteActive($package)])>
                        <a href="{{route('package')}}" class="menu-link">
                            <div data-i18n="Package">Packages</div>
                        </a>
                    </li>
                @endcan
                @can('Package_option.access')
                    @php($Package_option = ['Package.option', 'Package.option.add', 'Package.option.update', 'Package.option.detail'])
                    <li @class(['menu-item','active'=>isRouteActive($Package_option)])>
                        <a href="{{route('Package.option')}}" class="menu-link">
                            <div data-i18n="Package Option">Package Options</div>
                        </a>
                    </li>
                @endcan
                    @can('coupon.access')
                        @php($coupon = ['coupon', 'coupon.add', 'coupon.update', 'coupon.detail'])
                        <li @class(['menu-item','active' =>isRouteActive($coupon)])>
                            <a href="{{route('coupon')}}" class="menu-link">
                                <div data-i18n="Coupon">Coupons</div>
                            </a>
                        </li>
                    @endcan
            </ul>
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

        @can('timeline.access')
            @php($timeline_routes = ['manage.timelines', 'timeline.add', 'timeline.update', 'timeline.detail'])
            <li @class(['menu-item', 'active' => isRouteActive($timeline_routes)])>
                <a href="{{route('manage.timelines')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-time"></i>
                    <div data-i18n="Timelines">Timelines</div>
                </a>
            </li>
        @endcan

        @can('timeline.event.type.access')
            @php($timelineEventType_routes = ['manage.timeline.event.types', 'timeline.event.type.add', 'timeline.event.type.update', 'timeline.event.type.detail'])
            <li @class(['menu-item', 'active' => isRouteActive($timelineEventType_routes)])>
                <a href="{{route('manage.timeline.event.types')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-calendar-event"></i>
                    <div data-i18n="Timeline Event Types">Timeline Event Types</div>
                </a>
            </li>
        @endcan

        @can('planner.access')
            @php($planner_routes = ['manage.planners', 'planner.add', 'planner.update', 'planner.detail'])
            <li @class(['menu-item', 'active' => isRouteActive($planner_routes)])>
                <a href="{{route('manage.planners')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-paper-plane"></i>
                    <div data-i18n="Plot Planners">Plot Planners</div>
                </a>
            </li>
        @endcan

        @can('group.access')
            @php($group_routes = ['manage.groups', 'group.add', 'group.update', 'group.detail'])
            <li @class(['menu-item', 'active' => isRouteActive($group_routes)])>
                <a href="{{route('manage.groups')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Groups">Groups</div>
                </a>
            </li>
        @endcan
    </ul>
</aside>
