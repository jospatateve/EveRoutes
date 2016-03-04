<!-- New Route Form -->
<form action="/route" method="POST" class="form-horizontal">
    {{ csrf_field() }}

    <!-- Route Name -->
    <div class="form-group">
        <label for="everoute-name" class="col-sm-3 control-label">Name</label>
        <div class="col-sm-6">
            <input type="text" name="name" id="everoute-name" class="form-control" value="{{ old('everoute') }}">
        </div>
    </div>

    <!-- Route Waypoints -->
    <div class="form-group">
        <label for="everoute-waypoints" class="col-sm-3 control-label">Waypoints</label>
        <div class="col-sm-6" id="dynamic_waypoint">
            <input type="text" name="waypoints[]" id="everoute-waypoints" class="form-control" value="{{ old('everoute') }}">
        </div>
        <input type="button" class="btn btn-default" id="remove_system_name" value="+">
    </div>

    <!-- Add Route Button -->
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
            <button type="submit" class="btn btn-default">
                <i class="fa fa-btn fa-plus"></i>Add Route
            </button>
        </div>
    </div>
</form>
