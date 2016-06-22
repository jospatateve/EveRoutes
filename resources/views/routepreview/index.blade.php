@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Route options
                </div>

                <div id="options-form-panel" class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    <!-- Route options form -->
                    <form id="route-options-form" action="{{ url('/route/'.$route->id) }}" method="GET" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- System Name -->
                        <div class="form-group">
                            <label for="system-name" class="col-sm-3 control-label">Start system</label>
                            <div class="col-sm-6"><div class="input-group">
                                <input type="text" name="from" id="system-name" class="form-control" value="{{ old('from') ?: app('request')->input('from') ?: '' }}">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-info" id="get_current_system">
                                        <span class="glyphicon glyphicon-home"></span>
                                    </button>
                                </span>
                            </div></div>
                        </div>

                        <!-- Route Preference -->
                        <div class="form-group">
                            <label for="system-name" class="col-sm-3 control-label">Route Options</label>
                            <div class="col-sm-6"><div class="input-group">
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-default {{ (empty(app('request')->input('type')) || (app('request')->input('type') == '0')) ? 'active' : ''}}">
                                        <input type="radio" name="type" value="0" {{ (app('request')->input('type') == '0') ? 'checked' : ''}}> Fastest
                                    </label>
                                    <label class="btn btn-default {{ (app('request')->input('type') == '1') ? 'active' : ''}}">
                                        <input type="radio" name="type" value="1" {{ (app('request')->input('type') == '1') ? 'checked' : ''}}> Safest
                                    </label>
                                    <label class="btn btn-default {{ (app('request')->input('type') == '2') ? 'active' : ''}}">
                                        <input type="radio" name="type" value="2" {{ (app('request')->input('type') == '2') ? 'checked' : ''}}> Prefer Lowsec/0.0
                                    </label>
                                </div>
                            </div></div>
                        </div>

                        <!-- Search Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-search"></i>Go
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if (isset($waypoints) && !(count($errors) > 0))
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row vertical-center">
                            <div class="col-sm-10">
                                <h3>{{ $route->name }} <small>Preview</small></h3>
                            </div>
                            <div class="col-sm-2 text-right">
                                <button type="button" id="load-everoute-{{ $route->id }}" class="btn btn-default">
                                    <i class="fa fa-btn fa-play"></i>Load
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="preview-panel" class="panel-body">
                        @if (isset($exception))
                            <div class="alert alert-danger">
                                <strong>{{ $exception }}</strong>
                            </div>
                        @endif

                        <table class="table table-striped table-counted">
                             <thead>
                                <th>#</th>
                                <th>Waypoint</th>
                                <th>Security</th>
                                <th>Kills (1 hour)</th>
                                <th>Last kill (ago)</th>
                                <th>Sovereignty (ihub)</th>
                                <th>Links</th>
                            </thead>
                            <tbody>
                                @foreach ($waypoints as $waypoint)
                                    <tr>
                                        <td class="table-text"></td>
                                        <td class="table-text {{ in_array($waypoint->getName(), $systems) ? 'strong' : '' }}">
                                            {{ $waypoint->getName() }}
                                        </td>
                                        <td class="table-text">
                                            <span class="label {{ ($waypoint->getSecurityStatus() <= 0.0) ? 'label-danger' : (($waypoint->getSecurityStatus() < 0.5) ? 'label-warning' : 'label-success') }}">{{ round($waypoint->getSecurityStatus(), 2) }}</span>
                                        </td>
                                        @if (isset($kills) && array_key_exists($waypoint->getId(), $kills))
                                            <td class="table-text">
                                                <span class="label {{ $kills[$waypoint->getId()]['hour']->isEmpty() ? 'label-success' : (($kills[$waypoint->getId()]['hour']->getCount() > 2) ? 'label-danger' : 'label-warning') }}">{{ $kills[$waypoint->getId()]['hour']->getCount() }}</span>
                                            </td>
                                            <td class="table-text">
                                                {{ $kills[$waypoint->getId()]['latest']->getTimeDiffFormatted() }}
                                            </td>
                                        @endif
                                        <td class="table-text">
                                            @if (!$waypoint->isWH() && !empty($waypoint->getAlliance()))
                                                {{ $waypoint->getAlliance() }}
                                            @endif
                                        </td>
                                        <td class="table-text">
                                            <a href="https://zkillboard.com/system/{{ $waypoint->getId() }}/"><span class="label label-default">zkillboard</span></a>
                                            <a href="https://evemaps.dotlan.net/system/{{ $waypoint->getName() }}/"><span class="label label-default">dotlan</span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="panel-footer">
                        <div class="text-right">Calculated route in {{ round($time, 2) }} seconds.</div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
    function display_error_message(parent, message) {
        parent.prepend(
            "<div class=\"alert alert-danger\">" +
            "   <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>" +
            "   <strong>" + message + "</strong>" +
            "</div>"
        );
    }

    function display_success_message(parent, message) {
        parent.prepend(
            "<div class=\"alert alert-success\">" +
            "   <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>" +
            "   <strong>" + message + "</strong>" +
            "</div>"
        );
    }

    $(function() {
        // Autocomplete
        $("#system-name").autocomplete({
            source: "/system/autocomplete",
            /*select: function(event, ui) {
                $(this).val(ui.item.value);
                $("#route-options-form").submit();
                return false;
            }*/
        });

        // Get the current location
        $("#get_current_system").click(function() {
            $.getJSON(
                "{{ url('/location/json') }}"
            ).done(function(json) {
                if (json.valid) {
                    $("#system-name").val(json.location.name);
                } else {
                    display_error_message($("#options-form-panel"), "Unable to locate {{ Auth::user()->name }}.");
                }
            }).fail(function(jqXHR) {
                display_error_message($("#options-form-panel"), "Unable to locate {{ Auth::user()->name }} (" + jqXHR.responseJSON.error + ")");
            });
        });

        // Load waypoints button
        $("#load-everoute-{{ $route->id }}").click(function() {
            $.getJSON(
                "{{ url('/route/'.$route->id.'/loadwaypoints/json') }}"
            ).done(function(json) {
                display_success_message($("#preview-panel"), "Route \"" + json.loadedsuccess + "\" successfully loaded into EVE.");
            }).fail(function(jqXHR) {
                display_error_message($("#preview-panel"), "Failed to load route (" + jqXHR.responseJSON.exception + ").");
            });
        });
    });
@endsection

@section('styles')
    table.table-counted {
        counter-reset: rowNumber;
    }

    table.table-counted tbody tr {
        counter-increment: rowNumber;
    }

    table.table-counted tbody tr td:first-child::before {
        content: counter(rowNumber);
        min-width: 1em;
        margin-right: 0.5em;
    }

    .strong {
        font-weight: bold;
    }

    .vertical-center {
        max-height: 100%;
        max-height: 100vh;
        display: flex;
        align-items: center;
    }
@endsection
