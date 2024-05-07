<nav class="navbar navbar-dark bg-primary navbar-expand fixed-bottom d-md-none d-lg-none d-xl-none p-0">
    <ul class="navbar-nav nav-justified w-100">
        <li class="nav-item {{ Request::segment(2) == 'dashboard' ? 'active' : '' }} mt-2">
            <span class="sidebar-icon text-white">
                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                    <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                </svg>
            </span>
            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                <span class="sidebar-text" style="font-size: 14px;margin-left: auto;margin-right: auto;">Dashboard</span>
            </a>
        </li>
        @if (session()->has('menus'))
          @foreach (session()->get('menus') as $item)
            @if (\Helper::isAsesi())
              @if (($key = array_search("Master Data", $item)) != true)
                <li class="nav-item {{ Request::segment(2) == $item['slug'] ? 'active' : '' }} mt-2">
                    <span>
                        <span class="sidebar-icon text-white">
                            @include('components/icons/'.$item['icon'])
                        </span>
                    </span>
                    <a href="{{ url('admin/' . $item['slug']) }}" class="nav-link d-flex justify-content-between">
                        <span class="sidebar-text" style="font-size: 14px;margin-left: auto;margin-right: auto;">{{ $item['title'] }}</span>
                    </a>
                </li>
              @endif
            @else
                <li class="nav-item {{ Request::segment(2) == $item['slug'] ? 'active' : '' }} mt-2">
                    <span>
                        <span class="sidebar-icon text-white">
                            @include('components/icons/'.$item['icon'])
                        </span>
                    </span>
                    <a href="{{ url('admin/' . $item['slug']) }}" class="nav-link d-flex justify-content-between">
                        <span class="sidebar-text" style="font-size: 14px;margin-left: auto;margin-right: auto;">{{ $item['title'] }}</span>
                    </a>
                </li>
            @endif
          @endforeach
        @endif
    </ul>
</nav>
