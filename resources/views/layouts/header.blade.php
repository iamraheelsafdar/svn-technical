<aside class="sidebar position-relative" id="side_nav" aria-label="Sidebar navigation">
    <header class="header-box px-2 pt-3 pb-4 d-flex justify-content-between bg-white mb-3">
        <img id="logoPreview"
             src="{{ isset($siteSetting) && $siteSetting->logo ? asset('storage/' . $siteSetting->logo) : asset('assets/img/siteLogo.png') }}"
             alt="Logo Preview"
             class="img-fluid site-logo d-block m-auto">
        <button class="btn d-md-none d-block close-btn px-1 py-0 text-danger close-menu" aria-label="Close sidebar">
            <i class="bi bi-x-circle"></i>
        </button>
    </header>

    <nav>
        <ul class="list-unstyled px-2">
            <li class="{{ request()->routeIs('dashboardView') ? 'active' : '' }}">
                <a href="{{route('dashboardView')}}" class="text-decoration-none px-3 py-3 d-block" title="Dashboard">
                    <i class="bi bi-house-door-fill"></i> Dashboard
                </a>
            </li>
            <li class="{{ request()->routeIs('enrollmentsPage') || request()->routeIs('addEnrollmentPage') || request()->routeIs('updateEnrollmentView') ? 'active' : '' }}">
                <a href="{{route('enrollmentsPage')}}" class="text-decoration-none px-3 py-3 d-block" title="Dashboard">
                    <i class="bi bi-mortarboard-fill"></i> Enrollment
                </a>
            </li>
            <li class="{{ request()->routeIs('centersPage') || request()->routeIs('addCenterPage') || request()->routeIs('updateCenterView') ? 'active' : '' }}">
                <a href="{{route('centersPage')}}" class="text-decoration-none px-3 py-3 d-block" title="Centers">
                    <i class="bi bi-people-fill"></i> Centers
                </a>
            </li>
            <li class="{{request()->routeIs('coursesPage') || request()->routeIs('addCoursePage') || request()->routeIs('updateCourseView') || request()->routeIs('addSubjectPage') || request()->routeIs('updateSubjectView') ? 'active' : '' }}">
                <a href="{{route('coursesPage')}}"
                   class="text-decoration-none px-3 py-3 d-block d-flex justify-content-between"
                   title="Courses">
                    <span><i class="bi bi-pencil-fill"></i> Courses</span>
                    {{--                                            <span class="bg-dark rounded-pill text-white py-0 px-2">2</span>--}}
                </a>
            </li>
            <li class="{{request()->routeIs('prefixesPage') || request()->routeIs('addPrefixPage') || request()->routeIs('updatePrefixView') ? 'active' : '' }}">
                <a href="{{route('prefixesPage')}}" class="text-decoration-none px-3 py-3 d-block" title="Services">
                    <i class="bi bi-sliders2-vertical"></i> Prefixes
                </a>
            </li>
            <li>
                <a href="#" class="text-decoration-none px-3 py-3 d-block" title="Services">
                    <i class="bi bi-briefcase-fill"></i> Services
                </a>
            </li>
        </ul>
    </nav>
    <div class="mt-auto position-absolute bottom-0 w-100">
        <a href="{{route('siteSettingPage')}}" class="text-decoration-none px-3 py-3 d-block bg-white text-dark border"
           title="Site Settings">
            Site Settings <i class="bi bi-gear-wide-connected float-end "></i>
        </a>

        <a href="{{route('logout')}}" class="text-decoration-none px-3 py-3 d-block bg-danger text-white"
           title="Logout">
            Logout <i class="bi bi-box-arrow-right float-end "></i>
        </a>
    </div>
</aside>



