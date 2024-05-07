<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" style="max-width: 210px !important" data-simplebar>
    <div class="sidebar-inner px-2 pt-3">
      <div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
        {{-- <div class="d-flex align-items-center">
          <div class="avatar-lg me-4">
            <img src="{{ asset('admin/assets/img/team/profile-picture-3.jpg') }}" class="card-img-top rounded-circle border-white"
              alt="Bonnie Green">
          </div>
          <div class="d-block">
            <h2 class="h5 mb-3">Hi, Jane</h2>
            <a href="/login" class="btn btn-secondary btn-sm d-inline-flex align-items-center">
              <svg class="icon icon-xxs me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
              </svg>
              Sign Out
            </a>
          </div> --}}
        </div>
        {{-- <div class="collapse-close none">
          <a href="#sidebarMenu" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu"
            aria-expanded="true" aria-label="Toggle navigation">
            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
            </svg>
          </a>
        </div> --}}
      </div>
      <ul class="nav flex-column pt-3 pt-md-0">
        <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}" class="nav-link d-flex align-items-center">
            <span class="sidebar-icon me-3">
              <img src="{{ asset('images/logo.png') }}" height="100%" width="100%" alt="{{ config('app.name') }}">
            </span>
          </a>
        </li>
        <li class="nav-item {{ Request::segment(2) == 'dashboard' ? 'active' : '' }}">
          <a href="{{ route('admin.dashboard') }}" class="nav-link">
            <span class="sidebar-icon"> <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
              </svg></span></span>
            <span class="sidebar-text" style="font-size: 14px">Dashboard</span>
          </a>
        </li>
        {{-- dikomen sementara --}}
        {{-- <li class="nav-item">
          <span
            class="nav-link {{ Request::segment(1) !== 'bootstrap-tables' ? 'collapsed' : '' }} d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse" data-bs-target="#submenu-app">
            <span>
              <span class="sidebar-icon"><svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd"
                    d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm-1 9v-1h5v2H5a1 1 0 01-1-1zm7 1h4a1 1 0 001-1v-1h-5v2zm0-4h5V8h-5v2zM9 8H4v2h5V8z"
                    clip-rule="evenodd"></path>
                </svg></span>
              <span class="sidebar-text">Multiple Menu</span>
            </span>
            <span class="link-arrow"><svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                  clip-rule="evenodd"></path>
              </svg></span>
          </span>
          <div class="multi-level collapse {{ Request::segment(1) == 'bootstrap-tables' ? 'show' : '' }}" role="list"
            id="submenu-app" aria-expanded="false">
            <ul class="flex-column nav">
              <li class="nav-item {{ Request::segment(1) == 'bootstrap-tables' ? 'active' : '' }}">
                <a class="nav-link" href="#">
                  <span class="sidebar-text">Menu 1</span>
                </a>
              </li>
            </ul>
          </div>
        </li> --}}
        {{-- @if (session('user.data.role.name') == 'assessee' || session('user.data.role.name') == 'asesi')
          <li class="nav-item {{ Request::segment(2) == 'institutions' ? 'active' : '' }}">
            <a href="{{ route('admin.institutions.index') }}" class="nav-link d-flex justify-content-between">
              <span>
                <span class="sidebar-icon">
                  <x-icons.user/>
                </span>
                <span class="sidebar-text">Data Kelembagaan </span>
              </span>
              <span class="sidebar-text">Data Kelembagaan </span>
            </span>
          </a>
        </li> --}}
        @if (session()->has('menus'))
          @foreach (session()->get('menus') as $item)
            @if (\Helper::isAsesi())
              @if (($key = array_search("Master Data", $item)) != true)
                <li class="nav-item {{ Request::segment(2) == $item['slug'] ? 'active' : '' }}">
                  <a href="{{ url('admin/' . $item['slug']) }}" class="nav-link d-flex justify-content-between">
                    <span>
                      <span class="sidebar-icon">
                        @include('components/icons/'.$item['icon'])
                      </span>
                      <span class="sidebar-text" style="font-size: 14px">{{ $item['title'] }}</span>
                    </span>
                  </a>
                </li>
              @endif
            @else
              <li class="nav-item {{ Request::segment(2) == $item['slug'] ? 'active' : '' }}">
                <a href="{{ url('admin/' . $item['slug']) }}" class="nav-link d-flex justify-content-between">
                  <span>
                    <span class="sidebar-icon">
                        @include('components/icons/'.$item['icon'])
                    </span>
                    <span class="sidebar-text" style="font-size: 14px">{{ $item['title'] }}</span>
                  </span>
                </a>
              </li>
            @endif
          @endforeach
        @endif
        <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>
      </ul>
    </div>
  </nav>
