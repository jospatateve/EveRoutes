<!-- Edit Route Form -->
<form action="/route/{{ $editroute->id }}" method="POST" class="form-horizontal">
    {{ csrf_field() }}

    <!-- Route Name -->
    <div class="form-group">
        <label for="everoute-name" class="col-sm-3 control-label">Name</label>
        <div class="col-sm-6">
            <input type="text" name="name" id="everoute-name" class="form-control {{ $errors->has('name') ? 'input-error' : ''}}" value="{{ old('name') ?: $editroute->name }}">
        </div>
    </div>

    <!-- Route Waypoints -->
    <div class="form-group">
        @if (count(old('waypoints')) > 0)
            @include('everoutes.oldroute')
        @elseif (count($editroutewaypoints) == 0)
            <div id="waypoint-form-">
                <label for="everoute-waypoints-" class="col-sm-3 control-label">Waypoints</label>
                <div class="col-sm-6">
                    <input type="text" name="waypoints[]" id="everoute-waypoints-" class="form-control {{ $errors->has('waypoints.'.$index) ? 'input-error' : ''}}" value="">
                </div>
                <button type="button" class="btn btn-default" id="add_system_name">
                    <span class="glyphicon glyphicon-plus"></span>
                </button>
            </div>
            <div id="waypoints-form">
        @else
            @foreach ($editroutewaypoints as $index => $waypoint)
                @if ($index == 0)
	                <div id="waypoint-form-">
                        <label for="everoute-waypoints-" class="col-sm-3 control-label">Waypoints</label>
                        <div class="col-sm-6">
                            <input type="text" name="waypoints[]" id="everoute-waypoints-" class="form-control {{ $errors->has('waypoints.'.$index) ? 'input-error' : ''}}" value="{{ $waypoint }}">
                        </div>
                        <button type="button" class="btn btn-default" id="add_system_name">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                    </div>
                    <div id="waypoints-form">
                @else
                    <div id="waypoints-form-{{ $waypoint }}-{{ $index }}">
                        <label for="everoute-waypoints-{{ $waypoint }}-{{ $index }}" class="col-sm-3 control-label">
                            <span class="glyphicon glyphicon-resize-vertical"></span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" name="waypoints[]" id="everoute-waypoints-{{ $waypoint }}-{{ $index }}" class="form-control" value="{{ old('everoute') ?: $waypoint }}">
                        </div>
                        <button type="button" class="btn btn-default" id="remove_system_name-{{ $waypoint }}-{{ $index }}">
                            <span class="glyphicon glyphicon-minus"></span>
                        </button>
                    </div>
                @endif
            @endforeach
            </div>
        @endif
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
