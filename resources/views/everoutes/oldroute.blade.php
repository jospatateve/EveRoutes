@foreach (old('waypoints') as $index => $waypoint)
    @if ($index == 0)
        <div id="waypoint-form-">
            <label for="everoute-waypoints-" class="col-sm-3 control-label">Waypoints</label>
            <div class="col-sm-6">
                <input type="text" name="waypoints[]" id="everoute-waypoints-" class="form-control" value="{{ $waypoint }}">
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