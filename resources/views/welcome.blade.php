@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if (Session::has('exception'))
                <div class="panel panel-danger">
                    <div class="panel-heading"><strong>Warning</strong></div>
                    <div class="panel-body">
                        <strong>{{ Session::get('exception') }}</strong>
                    </div>
                </div>
            @endif
            <div class="panel panel-default">
                @if (Auth::guest())
                    <div class="panel-heading">Welcome - Log in to continue</div>
                    <div class="panel-body">
                        <a href= "{{url('/login/eveonline')}}">
                            <img src="{{url('/images/ssologin.png')}}" alt="Login with Eve Online"/>
                        </a>
                    </div>
                @else
                    <div class="panel-heading">Welcome</div>
                    <div class="panel-body">
                        <ul>
                            <li><a href="{{ url('/location') }}">My Location</a></li>
                            <li><a href="{{ url('/routes') }}">My Routes</a></li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
