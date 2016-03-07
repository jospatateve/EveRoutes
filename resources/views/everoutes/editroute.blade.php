<!-- Edit Route Form -->
<form action="/route/{{ $editroute->id }}" method="POST" class="form-horizontal">
    {{ csrf_field() }}

    <!-- Route Name -->
    <div class="form-group">
        <label for="everoute-name" class="col-sm-3 control-label">Name</label>
        <div class="col-sm-6">
            <input type="text" name="name" id="everoute-name" class="form-control" value="{{ old('everoute') ?: $editroute->name }}">
        </div>
    </div>

    <!-- Route Waypoints -->
    <div class="form-group">
        @foreach ($editroutewaypoints as $index => $waypoint)
            @if ($index == 0)
	            <div id="waypoint-form-">
                    <label for="everoute-waypoints-" class="col-sm-3 control-label">Waypoints</label>
                    <div class="col-sm-6">
                        <input type="text" name="waypoints[]" id="everoute-waypoints-" class="form-control" value="{{ old('everoute') ?: $waypoint }}">
                    </div>
                    <button type="button" class="btn btn-default" id="add_system_name">
                        <i class="fa fa-btn fa-plus"></i>
                    </button>
                </div>
                <div id="waypoints-form">
            @else
	                <div id="waypoints-form-{{ $waypoint }}-{{ $index }}">
                        <label for="everoute-waypoints-{{ $waypoint }}-{{ $index }}" class="col-sm-3 control-label">
                            <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" name="waypoints[]" id="everoute-waypoints-{{ $waypoint }}-{{ $index }}" class="form-control" value="{{ old('everoute') ?: $waypoint }}">
                        </div>
                        <button type="button" class="btn btn-default" id="remove_system_name-{{ $waypoint }}-{{ $index }}">
                            <i class="fa fa-btn fa-minus"></i>
                        </button>
                    </div>
            @endif
        @endforeach
                </div>
    </div>

    <!-- Edit Route and Cancel Buttons -->
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
            <button type="submit" class="btn btn-default">
                <i class="fa fa-btn fa-save"></i>Save Route
            </button>
            <button type="button" class="btn btn-default" id="cancel-button">
                Cancel
            </button>
        </div>
    </div>
</form>
