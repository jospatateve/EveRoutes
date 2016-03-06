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
    <div id="waypoints-form" class="form-group">
        @foreach ($editroutewaypoints as $index => $waypoint)
            @if ($index == 0)
	            <div id="waypoint-form-">
                    <label for="everoute-waypoints-" class="col-sm-3 control-label">Waypoints</label>
                    <div class="col-sm-6">
                        <input type="text" name="waypoints[]" id="everoute-waypoints-" class="form-control" value="{{ old('everoute') ?: $waypoint }}">
                    </div>
                    <input type="button" class="btn btn-default" id="add_system_name" value="+">
                </div>
            @else
	            <div id="waypoints-form-{{ $waypoint }}">
                    <label for="everoute-waypoints-{{ $waypoint }}" class="col-sm-3 control-label"></label>
                    <div class="col-sm-6">
                        <input type="text" name="waypoints[]" id="everoute-waypoints-{{ $waypoint }}" class="form-control" value="{{ old('everoute') ?: $waypoint }}">
                    </div>
                    <input type="button" class="btn btn-default" id="remove_system_name-{{ $waypoint }}" value="-">
                </div>
            @endif
        @endforeach
    </div>

    <!-- Add Route Button -->
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
            <button type="submit" class="btn btn-default">
                <i class="fa fa-btn fa-plus"></i>Edit Route
            </button>
        </div>
    </div>
</form>
