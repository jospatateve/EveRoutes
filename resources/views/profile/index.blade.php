@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Information</div>
                <div class="panel-body">
                    @if (isset($exception))
                        <div class="alert alert-danger">
                            <strong>Failed to get user information ({{ $exception }}).</strong>
                        </div>
                    @endif
                    @if (isset($userinfo))
                        <p style="float:left;width:300px">
                            <img src="{{ $userinfo->getPortrait() }}"/>
                            <img src="{{ $userinfo->getCorporationLogo() }}"/>
                        </p>
                        <ul>
                            <li>Name: {{ $userinfo->getName() }}</li>
                            <li>Id: {{ $userinfo->getId() }}</li>
                            <li>Gender: {{ $userinfo->getGender() }}</li>
                            <li>Corporation: {{ $userinfo->getCorporation() }}</li>
                        </ul>
                    @endif
                </div>
            </div>
            @if (isset($userstats))
                <div class="panel panel-default">
                    <div class="panel-heading">Statistics</div>
                    <div class="panel-body">
                        <pre>{{ json_encode($userstats->getJSON(), JSON_PRETTY_PRINT) }}</pre>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
