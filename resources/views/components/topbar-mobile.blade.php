<nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark ps-0 pe-2 pb-0">
    <div class="container-fluid px-0">
      <div class="d-flex justify-content-between w-100" id="navbarSupportedContent">
        <div class="d-flex align-items-center">
        </div>
        <!-- Navbar links -->
        <ul class="navbar-nav align-items-center">
          <li class="nav-item dropdown">
            <a class="nav-link text-dark notification-bell @if(count(session('notifications')['data']) > 0) unread @endif dropdown-toggle" data-unread-notifications="true"
              href="#" role="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
              <svg class="icon icon-sm text-gray-900 icon-bell" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                </path>
              </svg>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-center mt-2 py-0">
              <div class="list-group list-group-flush">
                <a href="#" class="text-center text-primary fw-bold border-bottom border-light py-3">Notifications</a>
                @foreach (session('notifications')['data'] as $item)
                  @if (!empty($item['content']['title']))
                    <a href="{{ route('admin.notification.show', ['id' => $item['id']]) }}" class="list-group-item list-group-item-action border-bottom" {{ empty($item['read_at'])  ? 'style=background-color:#F2F4F6' : ''  }}>
                      <div class="row align-items-center">
                        <div class="col ps-0 ms-2">
                          <div class="d-flex justify-content-between align-items-center">
                            <div>
                              <h4 class="h6 mb-0 text-small">{{ $item['content']['title'] }}</h4>
                            </div>
                            <div class="text-end">
                              <small class="text-danger">{{ \Carbon\Carbon::parse($item['created_at'])->diffForHumans() }}</small>
                            </div>
                          </div>
                          <p class="font-small mt-1 mb-0">{{ $item['content']['body'] }}</p>
                        </div>
                      </div>
                    </a>
                  @endif
                @endforeach
                <a href="{{ route('admin.notification.index') }}" class="dropdown-item text-center fw-bold rounded-bottom py-3">
                  <svg class="icon icon-xxs text-gray-400 me-1" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                    <path fill-rule="evenodd"
                      d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                      clip-rule="evenodd"></path>
                  </svg>
                  View all
                </a>
              </div>
            </div>
          </li>
          <li class="nav-item dropdown ms-lg-3">
            <a class="nav-link dropdown-toggle pt-1 px-0" href="#" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              <div class="media d-flex align-items-center">
                <img class="avatar rounded-circle" alt="Image placeholder" src="{{ session()->get('user.data.profile_picture') ? session()->get('user.data.profile_picture').'?stream' : asset('admin/assets/img/team/profile-picture-1.jpg') }}">
                <div class="media-body ms-2 text-dark align-items-center d-none d-lg-block">
                  <span
                    class="mb-0 font-small fw-bold text-gray-900">{{ session()->get('user.data.name') }}</span>
                </div>
              </div>
            </a>
            <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1">
              <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.profile') }}">
                <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                    clip-rule="evenodd"></path>
                </svg>
                My Profile
              </a>
              <div role="separator" class="dropdown-divider my-1"></div>
              <a class="dropdown-item d-flex align-items-center link-logout">
                logout
              </a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
