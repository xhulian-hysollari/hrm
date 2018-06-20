<header class="app-header navbar">
    <a class="navbar-brand" href="{{route('home')}}"></a>
    <ul class="nav navbar-nav d-md-down-none mr-auto">
        <li class="nav-item px-3 {{ $current == 'visitor' ? 'active' : ''}}">
            <a href="{{route('visitor.index')}}"> {{trans('app.visitor.main')}}
                @if($current == 'visitor')
                    <span class="sr-only">({{trans('app.current')}})</span>
                @endif
            </a>
        </li>
        @if(\Illuminate\Support\Facades\Auth::user()->role === 1)
            <li class="nav-item px-3 {{ $current == 'visitor' ? 'active' : ''}}">
                <a href="{{route('pim.index')}}"> {{trans('app.go_back')}}
                    @if($current == 'visitor')
                        <span class="sr-only">({{trans('app.current')}})</span>
                    @endif
                </a>
            </li>
        @endif
    </ul>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown d-md-down-none">
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