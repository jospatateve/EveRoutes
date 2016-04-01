@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @if (isset($editroute)) 
                        Edit Route - {{ $editroute->name }}
                    @else
                        <div class="new-route-title">New Route</div>
                        <div class="new-route-buttons">
                            <button type="button" id="pastebutton" class="btn btn-default" data-toggle="modal" data-target="#pasteformdialog">
                                <i class="fa fa-btn fa-paste"></i>Paste
                            </button>
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
            $(this).parent().remove();
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
            $("#waypoint-form-" + system_name_form_index + " > div > input")
                .attr("id", "everoute-waypoints-" + system_name_form_index)
                .removeClass("input-error")
                .val("");
            $("#waypoint-form-" + system_name_form_index + " > button")
                .attr("id", "remove_system_name-" + system_name_form_index)
                .children(":first")
                    .removeClass("fa-plus")
                    .addClass("fa-minus");

            // Enable autocomplete for new input field
            $("#everoute-waypoints-" + system_name_form_index).autocomplete({
                source: "{{ url('/system/autocomplete') }}"
            });

            // Remove waypoint input field button
            $("#remove_system_name-" + system_name_form_index).click(function() {
                // Remove the cloned div
                $(this).parent().remove();
            });
        });

        // Cancel button
        $("#cancel-button").click(function() {
            window.location.href = "{{ url('/routes') }}";
            return false;
        });

        // Delete route button
        $("[id^=form-delete-everoute-]").submit(function() {
			var name = $(this).parent().prev().children(":first").text();
            return confirm("Are you sure you want to delete \"" + name + "\"?");
		});
    });
@endsection

@section('styles')
    span.glyphicon {
        cursor: pointer;
    }

    .panel-heading > .new-route-title {
        float: left;
    }

    .panel-heading > .new-route-buttons {
        text-align: right;
    }

    .input-error {
        border-color: #a94442;
        box-shadow: 0 0 5px #a94442;
    }
@endsection
