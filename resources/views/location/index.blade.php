@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                @if (isset($location))
                    <div class="panel-heading">My Location - {{ $location['name'] }}</div>
                    <div class="panel-body">
					    {{ json_encode($location) }}
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
