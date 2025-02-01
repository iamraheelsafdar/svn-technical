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
            @if(in_array(auth()->user()->role, ['Admin', 'Center']))
                <li class="{{ request()->routeIs('dashboardView') ? 'active' : '' }}">
                    <a href="{{ route('dashboardView') }}" class="text-decoration-none px-3 py-3 d-block"
                       title="Dashboard">
                        <i class="bi bi-house-door-fill"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="#" class="text-decoration-none px-3 py-3 d-block" title="Services">
                        <i class="bi bi-person-workspace"></i> Students
                    </a>
                </li>
            @endif

            @if(auth()->user()->role == 'Admin')
                <li class="{{ request()->routeIs(['enrollmentsPage', 'addEnrollmentPage', 'updateEnrollmentView']) ? 'active' : '' }}">
                    <a href="{{ route('enrollmentsPage') }}" class="text-decoration-none px-3 py-3 d-block"
                       title="Enrollment">
                        <i class="bi bi-mortarboard-fill"></i> Enrollment
                    </a>
                </li>
                <li class="{{ request()->routeIs(['centersPage', 'addCenterPage', 'updateCenterView']) ? 'active' : '' }}">
                    <a href="{{ route('centersPage') }}" class="text-decoration-none px-3 py-3 d-block" title="Centers">
                        <i class="bi bi-people-fill"></i> Centers
                    </a>
                </li>
                <li class="{{ request()->routeIs(['coursesPage', 'addCoursePage', 'updateCourseView', 'addSubjectPage', 'updateSubjectView']) ? 'active' : '' }}">
                    <a href="{{ route('coursesPage') }}"
                       class="text-decoration-none px-3 py-3 d-block d-flex justify-content-between" title="Courses">
                        <span><i class="bi bi-pencil-fill"></i> Courses</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs(['prefixesPage', 'addPrefixPage', 'updatePrefixView']) ? 'active' : '' }}">
                    <a href="{{ route('prefixesPage') }}" class="text-decoration-none px-3 py-3 d-block"
                       title="Prefixes">
                        <i class="bi bi-sliders2-vertical"></i> Prefixes
                    </a>
                </li>
            @endif
        </ul>
    </nav>
    <div class="mt-auto position-absolute bottom-0 w-100">
        @if(auth()->user()->role == 'Admin')
            <a href="{{route('siteSettingPage')}}"
               class="text-decoration-none px-3 py-3 d-block bg-white text-dark border"
               title="Site Settings">
                Site Settings <i class="bi bi-gear-wide-connected float-end "></i>
            </a>
        @endif

        <a href="{{route('logout')}}" class="text-decoration-none px-3 py-3 d-block bg-danger text-white"
           title="Logout">
            Logout <i class="bi bi-box-arrow-right float-end "></i>
        </a>
    </div>
</aside>



