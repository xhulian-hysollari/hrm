<header class="app-header navbar">
    <a class="navbar-brand" href="#"></a>
    {{--<button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">--}}
        {{--<span class="navbar-toggler-icon"></span>--}}
    {{--</button>--}}
    <ul class="nav navbar-nav d-md-down-none mr-auto">

        <li class="nav-item px-3">
            <a href="{{route('settings.index')}}" class="nav-link">{{trans('app.settings.main')}}
                @if($current == 'settings')
                    <span class="sr-only">({{trans('app.current')}})</span>
                @endif
            </a>
        </li>
        <li class="nav-item px-3">
            <a href="{{route('pim.index')}}" class="nav-link">{{trans('app.pim.main')}}
                @if($current == 'pim')
                    <span class="sr-only">({{trans('app.current')}})</span>
                @endif
            </a>
        </li>
        <li class="nav-item px-3">
            <a href="{{route('leave.index')}}" class="nav-link">{{trans('app.leave.main')}}
                @if($current == 'leave')
                    <span class="sr-only">({{trans('app.current')}})</span>
                @endif
            </a>
        </li>

        <li class="nav-item px-3">
            <a href="{{route('time.index')}}" class="nav-link">{{trans('app.time.main')}}
                @if($current == 'time')
                    <span class="sr-only">({{trans('app.current')}})</span>
                @endif
            </a>
        </li>

        <li class="nav-item px-3">
            <a href="{{route('recruitment.index')}}" class="nav-link">{{trans('app.recruitment.main')}}
                @if($current == 'recruitment')
                    <span class="sr-only">({{trans('app.current')}})</span>
                @endif
            </a>
        </li>

        <li class="nav-item px-3">
            <a href="{{route('admin.training.index')}}" class="nav-link">{{trans('app.training.main')}}
                @if($current == 'training')
                    <span class="sr-only">({{trans('app.current')}})</span>
                @endif
            </a>
        </li>

        <li class="nav-item px-3">
            <a href="{{route('discipline.index')}}" class="nav-link">{{trans('app.discipline.main')}}
                @if($current == 'discipline')
                    <span class="sr-only">({{trans('app.current')}})</span>
                @endif
            </a>
        </li>

        <li class="nav-item px-3">
            <a href="{{route('dashboard.index')}}" class="nav-link">{{trans('app.dashboard.main')}}
                @if($current == 'dashboard')
                    <span class="sr-only">({{trans('app.current')}})</span>
                @endif
            </a>
        </li>


    </ul>

    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown d-md-down-none">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
               aria-expanded="false">{{ Auth::user()->first_name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">

                <a href="{{ route('profile.index') }}" class="dropdown-item">
                    {{trans('app.profile.main')}}
                </a>
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