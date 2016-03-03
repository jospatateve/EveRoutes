@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                @if (isset($location))
                    <div class="panel-heading">My Location - {{ $location['name'] }}</div>
                    <div class="panel-body">
					    <!--<pre>{{ json_encode($location, JSON_PRETTY_PRINT) }}</pre>-->
                        <ul>
                            <li>System: {{ $location['name'] }}</li>
                            <li>Security Status: {{ $location['securityStatus'] }}</li>
                            <li>Sovereignty: {{ $location['sovereignty']['name'] }}</li>
                        </ul>
                    </div>
                @else
                    <div class="panel-heading">My Location</div>
                    <div class="panel-body">
                        <p>Unable to locate {{ Auth::user()->name }}.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
