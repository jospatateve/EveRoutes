@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                @if (Session::has('message'))
                    <div class="panel-heading">Error - Something went wrong</div>
                    <div class="panel-body">
                        <p>{{ Session::get('message') }}</p>
                    </div>
                @endif
                @if (Auth::guest())
                    <div class="panel-heading">Welcome - Log in to continue</div>
                    <div class="panel-body">
                        <a href= "{{url('/login/eveonline')}}">
                            <img src="{{url('ssologin.png')}}" alt="Login with Eve Online"/>
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
