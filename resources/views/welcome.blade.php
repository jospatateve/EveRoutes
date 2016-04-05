@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-offset-2 col-sm-8">
            @if (Session::has('exception'))
                <div class="panel panel-danger">
                    <div class="panel-heading"><strong>Warning</strong></div>
                    <div class="panel-body">
                        <strong>{{ Session::get('exception') }}</strong>
                    </div>
                </div>
            @endif
            @if (Auth::guest())
                <div class="jumbotron">
                    <h1>Welcome <small>to EveRoutes</small></h1>
                    <br/>
                    <p>
                        <a href= "{{url('/login/eveonline')}}">
                            <img src="{{url('/images/ssologin.png')}}" alt="Login with Eve Online"/>
                        </a>
                    </p>
                </div>
            @else
                <div class="panel panel-default">
                    <div class="panel-heading">Welcome</div>
                    <div class="panel-body">
                        <ul>
                            <li><a href="{{ url('/location') }}">My Location</a></li>
                            <li><a href="{{ url('/routes') }}">My Routes</a></li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
