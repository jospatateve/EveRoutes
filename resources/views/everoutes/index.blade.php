@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-offset-2 col-sm-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @if (isset($editroute)) 
                            Edit Route - {{ $editroute->name }}
                        @else
                            <div class="row">
                                <div class="col-sm-6">New Route</div>
                                <div class="col-sm-6 text-right">
                                    <button type="button" id="pastebutton" class="btn btn-default" data-toggle="modal" data-target="#pasteformdialog">
                                        <i class="fa fa-btn fa-paste"></i>Paste
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="panel-body">
                        <!-- Display Validation Errors -->
                        @include('common.errors')

                        <!-- Form to Add or Update Route -->
                        @if (isset($editroute)) 
                            @include('everoutes.editroute')
                        @else
                            @include('everoutes.newroute')
                        @endif
                    </div>
                </div>

                @include('everoutes.routes')
 
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    $(function() {
        // Drag-drop sort
        $("#waypoints-form").sortable();

        // Autocomplete
        $("[id^=everoute-waypoints-]").autocomplete({
            source: "{{ url('/system/autocomplete') }}"
        });

        // Remove waypoint input field button
        $("[id^=remove_system_name-]").click(function() {
            // Remove the cloned div
            $(this).parent().parent().parent().parent().remove();
        });

        // Unique index to keep track of waypoint input field count
        var system_name_form_index = 0;

		// Add waypoint input field button
        $("#add_system_name").click(function() {
            // Increment index since a new form is being created
            ++system_name_form_index;

            // Clone the form and position it
            $("#waypoint-form-").clone().attr("id", "waypoint-form-" + system_name_form_index).appendTo("#waypoints-form");

            // Update label, input field and delete button
            $("#waypoint-form-" + system_name_form_index + " > label")
                .attr("for", "everoute-waypoints-" + system_name_form_index)
                .html("<span class=\"glyphicon glyphicon-resize-vertical\"></span>");
            $("#waypoint-form-" + system_name_form_index + " > div > div > input")
                .attr("id", "everoute-waypoints-" + system_name_form_index)
                .removeClass("input-error")
                .val("");
            $("#waypoint-form-" + system_name_form_index + " > div > div > span > button")
                .attr("id", "remove_system_name-" + system_name_form_index)
                .removeClass("input-error btn-add btn-success")
                .addClass("btn-remove btn-danger")
                .html("<span class=\"glyphicon glyphicon-minus\"></span>");

            // Enable autocomplete for new input field
            $("#everoute-waypoints-" + system_name_form_index).autocomplete({
                source: "{{ url('/system/autocomplete') }}"
            });

            // Remove waypoint input field button
            $("#remove_system_name-" + system_name_form_index).click(function() {
                // Remove the cloned div
                $(this).parent().parent().parent().parent().remove();
            });
        });

        // Cancel button
        $("#cancel-button").click(function() {
            window.location.href = "{{ url('/routes') }}";
            return false;
        });
    });
@endsection

@section('styles')
    .input-error {
        border-color: #a94442;
        box-shadow: 0 0 5px #a94442;
    }

    div[id^=waypoint-form-] {
        overflow: hidden;
        width: 100%;
    }

    div[id^=waypoint-form-] > label > span.glyphicon {
        cursor: pointer;
    }

    div[id^=waypoint-form-] > div > div > span > button > span.glyphicon {
        font-size: 12px;
    }

    #waypoints-form > div[id^=waypoint-form-] {
        margin-top: 5px;
    }
@endsection
