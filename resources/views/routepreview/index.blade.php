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
                    <form id="route-options-form" action="/route/{{ $route->id }}" method="GET" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- System Name -->
                        <div class="form-group">
                            <label for="system-name" class="col-sm-3 control-label">Start system</label>
                            <div class="col-sm-6"><div class="input-group">
                                <input type="text" name="from" id="system-name" class="form-control" value="{{ old('from') ?: app('request')->input('from') ?: '' }}">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-success btn-add" id="get_current_system">
                                        <span class="glyphicon glyphicon-home"></span>
                                    </button>
                                </span>
                            </div></div>
                        </div>


                        <!-- Search Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-play"></i>Go
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if (isset($waypoints) && !(count($errors) > 0))
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $route->name }} - Preview
                    </div>

                    <div class="panel-body">
                        @if (isset($exception))
                            <div class="alert alert-danger">
                                <strong>{{ $exception }}</strong>
                            </div>
                        @endif

                        <table class="table table-striped table-counted">
                             <thead>
                                <th>Route</th>
                                <th>Security Class</th>
                                <th>Security Status</th>
                                <th>Sovereignty</th>
                            </thead>
                            <tbody>
                                @foreach ($waypoints as $route)
                                    @foreach ($route as $index => $waypoint)
                                        @if ($index > 0)
                                            <tr>
                                                <td class="table-text {{ ($index == count($route)-1) ? 'strong' : '' }}">{{ $waypoint->getName() }}</td>
                                                <td class="table-text">{{ $waypoint->getSecurityClass() }}</td>
                                                <td class="table-text">{{ round($waypoint->getSecurityStatus(), 2) }}</td>
                                                <td class="table-text">{{ $waypoint->isWH() ? '' : $waypoint->getAlliance() }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
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
    function display_error_message(message) {
        $("#options-form-panel").prepend(
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
                $("#route-options-form").submit();
                return false;
            }
        });

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
@endsection
