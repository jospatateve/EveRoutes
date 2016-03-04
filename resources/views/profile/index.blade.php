@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Information - {{ $userinfo['name'] }}</div>
                <div class="panel-body">
				    <!--<pre>{{ json_encode($userinfo, JSON_PRETTY_PRINT) }}</pre>-->
                    <ul>
                        <li>Name: {{ $userinfo['name'] }}</li>
                        <li>Id: {{ $userinfo['id'] }}</li>
                        <li>Gender: {{ $userinfo['gender'] ? 'male' : 'female' }}</li>
                        <li>Corporation: {{ $userinfo['corporation']['name'] }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection