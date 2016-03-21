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
                    <div class="panel-heading">Yearly Statistics</div>
                    <div class="panel-body">
                        <div id="yearlystats">
                            @foreach ($userstats->getYearlyStats() as $year => $yearstats)
                                <h3>{{ $year }}</h3>
                                <div>
                                    <ul>
                                        <li>Time played: {{ $yearstats->getTimePlayed()->format('%a days %h hours %i minutes') }}</li>
                                        <li>Times logged on: {{ number_format($yearstats->getTimesLoggedOn()) }}</li>
                                    </ul>
                                    <ul>
                                        <li>Damage Taken: {{ number_format($yearstats->getDamageTaken()) }}</li>
                                        <li>Damage Dealt: {{ number_format($yearstats->getDamageDealt()) }}</li>
                                        <li>Losses: {{ number_format($yearstats->getNumberOfLosses()) }}</li>
                                        <li>Kills: {{ number_format($yearstats->getNumberOfKills()) }}</li>
                                    </ul>
                                    <ul>
                                        <li>Number of jumps: {{ number_format($yearstats->getNumberOfJumps()) }}</li>
                                        <li>Number of warps: {{ number_format($yearstats->getNumberOfWarps()) }}</li>
                                        <li>Distance warped: {{ number_format($yearstats->getDistanceTraveled()) }} au</li>
                                    </ul>
                                    <ul>
                                        <li>Cans hacked successfully: {{ number_format($yearstats->getNumberOfCansHacked()) }}</li>
                                        <li>Hacking success rate: {{ sprintf("%.2f%%", $yearstats->getHackingSuccessRate() * 100) }}</li>
                                        <li>Times cloaked: {{ number_format($yearstats->getNumberOfCloakActivations()) }}</li>
                                    </ul>
                                    <!--<pre>{{ json_encode($yearstats->getJSON(), JSON_PRETTY_PRINT) }}</pre>-->
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
$(function() {
    $("#yearlystats").accordion({
        collapsible: true,
        active: false
    });
});
@endsection
