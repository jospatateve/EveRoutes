@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                @if (isset($location))
                    <div class="panel-heading">My Location - {{ $location->getName() }}</div>
                    <div class="panel-body">
                        <ul>
                            <li>System: {{ $location->getName() }}</li>
                            <li>Security Status: {{ $location->getSecurityStatus() }}</li>
                            <li>Sovereignty: {{ $location->getAlliance() }}</li>
                        </ul>
                    </div>
                @else
                    <div class="panel-heading">My Location</div>
                    <div class="panel-body">
                        @if (isset($exception))
                            <div class="alert alert-danger">
                                <strong>{{ $exception }}</strong>
                            </div>
                        @endif
                        <p>Unable to locate {{ Auth::user()->name }}.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
