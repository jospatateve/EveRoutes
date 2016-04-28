@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Search a System
                </div>

                <div id="search-form-panel" class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    <!-- System Search Form -->
                    <form id="search-form" action="{{ url('/system') }}" method="GET" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- System Name -->
                        <div class="form-group">
                            <label for="system-name" class="col-sm-3 control-label">System</label>
                            <div class="col-sm-6">
                                @if (Auth::check())
                                    <div class="input-group">
                                        <input type="text" name="name" id="system-name" class="form-control" value="{{ old('name') ?: app('request')->input('name') ?: '' }}">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info" id="get_current_system">
                                                <span class="glyphicon glyphicon-home"></span>
                                            </button>
                                        </span>
                                    </div>
                                @else
                                    <input type="text" name="name" id="system-name" class="form-control" value="{{ old('name') ?: app('request')->input('name') ?: '' }}">
                                @endif
                            </div>
                        </div>

                        <!-- Search Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-search"></i>Search
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
                            <li>Security Class: {{ $system->getSecurityClass() }}</li>
                            <li>Security Status: {{ number_format($system->getSecurityStatus(), 2) }}</li>
                            <li>Sovereignty: {{ $system->isWH() ? '' : $system->getAlliance() }}</li>
                        </ul>
                    @else
                        <p>No system info to display.</p>
                    @endif
                    @if (isset($stats))
                        <!--<pre>{{ json_encode($stats->getJSON(), JSON_PRETTY_PRINT) }}</pre>-->
                    @endif
                    @if (isset($kill))
                        <ul>
                            <li>Latest kill: {{ $kill->getTime() }}</li>
                            <li>Time since latest kill: {{ number_format($kill->getTimeDiff() / 3600, 2) }} hours</li>
                            <li>Victim: {{ $kill->getVictim() }}</li>
                            <li>Attackers: {{ implode(', ', $kill->getAttackers()) }}</li>
                            <li>Final blow: {{ $kill->getFinalBlow() }}</li>
                            <li>Killmail: <a href="{{ $kill->getUrl() }}">zkillboard</a></li>
                        </ul>
                        <!--<pre>{{ json_encode($kill->getJSON(), JSON_PRETTY_PRINT) }}</pre>-->
                    @endif
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    function display_error_message(message) {
        $("#search-form-panel").prepend(
            "<div class=\"alert alert-danger\">" +
            "   <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>" +
            "   <strong>" + message + "</strong>" +
            "</div>"
        );
    }

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

        @if (Auth::check())
        // Get the current location
            $("#get_current_system").click(function() {
                $.getJSON(
                    "{{ url('/location/json') }}"
                ).done(function(json) {
                    if (json.valid) {
                        $("#system-name").val(json.location.name);
                    } else {
                        display_error_message("Unable to locate {{ Auth::user()->name }}.");
                    }
                }).fail(function(jqXHR) {
                    display_error_message("Unable to locate {{ Auth::user()->name }} (" + jqXHR.responseJSON.error + ")");
                });
            });
        @endif
    });
@endsection
