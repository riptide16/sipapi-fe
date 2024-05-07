<nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-lg-none">
    <a class="navbar-brand me-lg-5" href="{{ route('admin.dashboard') }}">
        <img class="navbar-brand-dark" src="{{ asset('images/logo.png') }}" />
        <img class="navbar-brand-light" src="{{ asset('images/logo.png') }}" />
    </a>
    @if (\Helper::isAdmin())
        <div class="d-flex align-items-center">
            <button class="navbar-toggler d-lg-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    @else
        @include('components.topbar-mobile')
    @endif
</nav>
