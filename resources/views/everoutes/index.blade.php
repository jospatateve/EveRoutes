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
        // Autocomplete
        $("#everoute-waypoints-").autocomplete({
            source: "/system/autocomplete",
            minLength: 1,
            select: function(event, ui) {
                $("#everoute-waypoints").val(ui.item.value);
            }
        });

        // Unique index to keep track of waypoint input field count
        var system_name_form_index = 0;

		// Add waypoint input field button
        $("#add_system_name").click(function(){
            // Increment index since a new form is being created
            ++system_name_form_index;

            // Clone the form and position it
            $("#waypoint-form-").clone().attr("id", "waypoint-form-" + system_name_form_index).appendTo("#waypoints-form");

            // Update label, input field and delete button
            $("#waypoint-form-" + system_name_form_index).find("label").eq(0).attr("for", "everoute-waypoints-" + system_name_form_index);
            $("#waypoint-form-" + system_name_form_index).find("label").eq(0).html("");
            $("#waypoint-form-" + system_name_form_index).find("input").eq(0).attr("id", "everoute-waypoints-" + system_name_form_index);
            $("#waypoint-form-" + system_name_form_index).find("input").eq(0).val("");
            $("#waypoint-form-" + system_name_form_index).find("input").eq(1).attr("id", "remove_system_name-" + system_name_form_index);
            $("#waypoint-form-" + system_name_form_index).find("input").eq(1).attr("value", "-");

            // Enable autocomplete for new input field
            $("#everoute-waypoints-" + system_name_form_index).autocomplete({
                source: "/system/autocomplete",
                minLength: 1,
                select: function(event, ui) {
                   $("#everoute-waypoints").val(ui.item.value);
                }
            });

            // Remove waypoint input field button
            $("#remove_system_name-" + system_name_form_index).click(function(){
               // Remove the cloned div
               $(this).parent().remove();
            });
        });
    });
@endsection
