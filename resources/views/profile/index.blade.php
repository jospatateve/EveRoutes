@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Information</div>
                <div class="panel-body">
                    @if (Session::has('exception'))
                        <div class="alert alert-danger">
                            <strong>Failed to get user information ({{ Session::get('exception') }}).</strong>
                        </div>
                    @endif
                    @if (isset($userinfo))
				        <!--<pre>{{ json_encode($userinfo, JSON_PRETTY_PRINT) }}</pre>-->
                        <ul>
                            <li>Name: {{ $userinfo['name'] }}</li>
                            <li>Id: {{ $userinfo['id'] }}</li>
                            <li>Gender: {{ $userinfo['gender'] ? 'male' : 'female' }}</li>
                            <li>Corporation: {{ $userinfo['corporation']['name'] }}</li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
