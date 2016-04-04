@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-info">
                <div class="panel-heading"><strong>Information</strong></div>
                <div class="panel-body">
                    <strong>Not implemented yet.</strong>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
				{{ $route->name }} - Preview
                </div>

                <div class="panel-body">
                    <ul class="list-group">
                        @foreach ($waypoints as $route)
                            <li class="list-group-item">
                                <ul>
                                    @foreach ($route as $waypoint)
                                        <li>{{ $waypoint }}</li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
