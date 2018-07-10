<header class="app-header navbar">
    <a class="navbar-brand" href="{{route('home')}}"></a>
    <ul class="nav navbar-nav d-md-down-none mr-auto">

        <li class="nav-item px-3 {{ $current == 'home' ? 'active' : ''}}">
            <a href="{{route('home')}}">Home
                @if($current == 'home')
                    <span class="sr-only">({{trans('app.current')}})</span>
                @endif
            </a>
        </li>
        <li class="nav-item px-3 {{ $current == 'employee.dashboard_documents' ? 'active' : ''}}">
            <a href="{{route('employee.dashboard_documents.index')}}">{{trans('app.dashboard.main')}}
                @if($current == 'employee.dashboard_documents')
                    <span class="sr-only">({{trans('app.current')}})</span>
                @endif
            </a>
        </li>
    </ul>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown d-md-down-none px-5">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
               aria-expanded="false">{{ Auth::user()->first_name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">
                <a href="{{ route('logout') }}" class="dropdown-item"
                   onclick="event.preventDefault();
document.getElementById('logout-form').submit();">
                    {{trans('app.logout')}}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </li>
    </ul>
</header>