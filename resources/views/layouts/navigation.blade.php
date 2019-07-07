<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img class="rounded-circle img-sm" src="{{ Auth::user()->gravatar() }}" alt="{{ Auth::user()->name }}" />
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">{{ Str::title(Auth::user()->full_name) }}</span>
                        <span class="text-muted text-xs block">{{ Auth::user()->roles->first()->display_name }} <b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" href="{{ route('profile.edit', Auth::user() ) }}">Profile</a></li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i>&nbsp;{{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
                <div class="logo-element">P/P</div>
            </li>
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span class="nav-label">Dashboard</span></a>
            </li>
            @if (check_user_permissions(request(), "Blog@index"))
                <li class="{{ request()->routeIs(['blog.index', 'blog.create', 'blog.edit', 'blog.show']) ? 'active' : '' }}">
                    <a href="{{ route('blog.index') }}"><i class="fa fa-files-o"></i> <span class="nav-label">Blog</span></a>
                </li>
            @endif
            @if (check_user_permissions(request(), "Categories@index"))
                <li class="{{ request()->routeIs(['categories.index', 'categories.create', 'categories.edit']) ? 'active' : '' }}">
                    <a href="{{ route('categories.index') }}"><i class="fa fa-folder"></i> <span>Categories</span></a>
                </li>
            @endif
            @if (check_user_permissions(request(), "Users@index"))
                <li class="{{ request()->routeIs(['users.index', 'users.create', 'users.edit']) ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}"><i class="fa fa-users"></i> <span>Users</span></a>
                </li>
            @endif
        </ul>
    </div>
</nav>