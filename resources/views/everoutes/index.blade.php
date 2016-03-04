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
        $("#everoute-waypoints").autocomplete({
            source: "/system/autocomplete",
            minLength: 1,
            select: function(event, ui) {
                $("#everoute-waypoints").val(ui.item.value);
            }
        });

        //Unique index to keep track of form count
        var system_name_form_index=0;
		//Add button
        $("#add_system_name").click(function(){
            //Increment index since a new form is being created
            system_name_form_index++;
            //Clone the form and position it
            $(this).parent().before($("#col-sm-6").clone().attr("id","col-sm-6" + system_name_form_index));
            //Make the clone visible
            $("#col-sm-6" + system_name_form_index).css("display","inline");
            //For each input fields contained in the cloned form...
            $("#col-sm-6" + system_name_form_index + " :input").each(function(){
                //Modify the name attribute by adding the index number at the end of it
                $(this).attr("name",$(this).attr("name") + system_name_form_index);
                //Modify the id attribute by adding the index number at the end of it
                $(this).attr("id",$(this).attr("id") + system_name_form_index);
            });
			//Remove button
            $("#remove_system_name" + system_name_form_index).click(function(){
                //Remove the cloned div
                $(this).closest("div").remove();
            });
        });
    });
@endsection
