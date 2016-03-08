@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @if (isset($editroute)) 
                        Edit Route - {{ $editroute->name }}
                    @else
                        New Route
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
            source: "/system/autocomplete"
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
            $("#waypoint-form-" + system_name_form_index).find("label").eq(0).attr("for", "everoute-waypoints-" + system_name_form_index);
            $("#waypoint-form-" + system_name_form_index).find("label").eq(0).html("<span class=\"ui-icon ui-icon-arrowthick-2-n-s\"></span>");
            $("#waypoint-form-" + system_name_form_index).find("input").eq(0).attr("id", "everoute-waypoints-" + system_name_form_index);
            $("#waypoint-form-" + system_name_form_index).find("input").eq(0).val("");
            $("#waypoint-form-" + system_name_form_index).find("button").eq(0).attr("id", "remove_system_name-" + system_name_form_index);
            $("#waypoint-form-" + system_name_form_index).find("button").eq(0).html("<i class=\"fa fa-btn fa-minus\"></i>");

            // Enable autocomplete for new input field
            $("#everoute-waypoints-" + system_name_form_index).autocomplete({
                source: "/system/autocomplete"
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
    });
@endsection

@section('styles')
    span.ui-icon {
        background-image: url({{ url('/jquery-ui/images/ui-icons_454545_256x240.png') }});
        display: inline-block;
        cursor: pointer;
    }

    form.inline {
        display: inline;
    }
@endsection
