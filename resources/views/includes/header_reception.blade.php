<nav class="navbar navbar-default">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">{{ trans('app.toggle_nav') }}</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{route('employee.home')}}" style="padding:0">
                <img src="http://forcontact.com/wp-content/uploads/2018/01/logo_Forcontact_nuovo_Google-e1516734469445.png" style="height: 50px;">
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <!-- MENU ITEMS GO HERE -->
            <ul class="nav navbar-nav">
                <li class="{{ $current == 'visitor' ? 'active' : ''}}">
                    <a href="{{route('visitor.index')}}"> {{trans('app.visitor')}}
                        @if($current == 'visitor')
                            <span class="sr-only">({{trans('app.current')}})</span>
                        @endif
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->first_name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                                {{trans('app.logout')}}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>