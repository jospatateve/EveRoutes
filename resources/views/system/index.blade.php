@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Search a System
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    <!-- System Search Form -->
                    <form id="search-form" action="/system" method="GET" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- System Name -->
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">System</label>
                            <div class="col-sm-6">
                                <input type="text" name="name" id="system-name" class="form-control" value="{{ old('name') ?: app('request')->input('name') ?: '' }}">
                            </div>
                        </div>

                        <!-- Search Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    @if (isset($system)) 
                        System Info - {{ $system->getName() }}
                    @else
                        System Info
                    @endif
                </div>

                <div class="panel-body">
                    @if (isset($exception))
                        <div class="alert alert-danger">
                            <strong>{{ $exception }}</strong>
                        </div>
                    @endif
                    @if (isset($system))
                        <ul>
                            <li>System: {{ $system->getName() }}</li>
                            <li>Id: {{ $system->getId() }}</li>
                            <li>Security Status: {{ number_format($system->getSecurityStatus(), 2) }}</li>
                            <li>Sovereignty: {{ $system->isWH() ? 'Wormhole' : $system->getAlliance() }}</li>
                        </ul>
                    @else
                        <p>No system info to display.</p>
                    @endif
                    @if (isset($stats))
                        <!--<pre>{{ json_encode($stats, JSON_PRETTY_PRINT) }}</pre>-->
                    @endif
                    @if (isset($kill))
                        <ul>
                            <li>Latest kill: {{ $kill['killTime'] }}</li>
                            <li>Victim: {{ $kill['victim']['characterName'] }}</li>
                            <li>Attackers: {{ implode(', ', array_map(function($v) { return $v['characterName']; }, $kill['attackers'])) }}</li>
                            <li>Killmail: <a href="https://zkillboard.com/kill/{{ $kill['killID'] }}/">zkillboard</a></li>
                        </ul>
                        <!--<pre>{{ json_encode($kill, JSON_PRETTY_PRINT) }}</pre>-->
                    @endif
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    $(function() {
        // Autocomplete
        $("#system-name").autocomplete({
            source: "/system/autocomplete",
            select: function(event, ui) {
                $(this).val(ui.item.value);
                $("#search-form").submit();
                return false;
            }
        });
    });
@endsection
