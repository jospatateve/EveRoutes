@foreach (old('waypoints') as $index => $waypoint)
    @if ($index == 0)
        <div id="waypoint-form-">
            <label for="everoute-waypoints-" class="col-sm-3 control-label">Waypoints</label>
            <div class="col-sm-6"><div class="input-group">
                <input type="text" name="waypoints[]" id="everoute-waypoints-" class="form-control {{ $errors->has('waypoints.'.$index) ? 'input-error' : ''}}" value="{{ $waypoint }}">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-success btn-add {{ $errors->has('waypoints.'.$index) ? 'input-error' : ''}}" id="add_system_name">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </span>
            </div></div>
        </div>
        <div id="waypoints-form">
    @else
            <div id="waypoint-form-{{ $waypoint }}-{{ $index }}">
                <label for="everoute-waypoints-{{ $waypoint }}-{{ $index }}" class="col-sm-3 control-label">
                    <span class="glyphicon glyphicon-resize-vertical"></span>
                </label>
                <div class="col-sm-6"><div class="input-group">
                    <input type="text" name="waypoints[]" id="everoute-waypoints-{{ $waypoint }}-{{ $index }}" class="form-control {{ $errors->has('waypoints.'.$index) ? 'input-error' : ''}}" value="{{ $waypoint }}">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-danger btn-remove {{ $errors->has('waypoints.'.$index) ? 'input-error' : ''}}" id="remove_system_name-{{ $waypoint }}-{{ $index }}">
                            <span class="glyphicon glyphicon-minus"></span>
                        </button>
                    </span>
                </div></div>
            </div>
    @endif
@endforeach
        </div>
