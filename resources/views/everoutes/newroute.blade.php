<div id="formtabs">
    <ul>
        <li><a href="#directinputform">Manual Input</a></li>
        <li><a href="#pasteform">Paste Waypoints</a></li>
    </ul>
    <div id="directinputform">
        <!-- New Route Form -->
        <form action="/route" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <!-- Route Name -->
            <div class="form-group">
                <label for="everoute-name" class="col-sm-3 control-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" name="name" id="everoute-name" class="form-control {{ $errors->has('name') ? 'input-error' : ''}}" value="{{ old('name') }}">
                </div>
            </div>

            <!-- Route Waypoints -->
            <div class="form-group">
                @if (count(old('waypoints')) > 0)
                    @include('everoutes.oldroute')
                @else
	                <div id="waypoint-form-">
                        <label for="everoute-waypoints-" class="col-sm-3 control-label">Waypoints</label>
                        <div class="col-sm-6">
                            <input type="text" name="waypoints[]" id="everoute-waypoints-" class="form-control {{ $errors->has('waypoints.0') ? 'input-error' : ''}}" value="">
                        </div>
                        <button type="button" class="btn btn-default" id="add_system_name">
                            <i class="fa fa-btn fa-plus"></i>
                        </button>
                    </div>
                    <div id="waypoints-form">
                    </div>
                @endif
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
    </div>
    <div id="pasteform">
        <!-- Paste Route Form -->
        <form action="/route/paste" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <!-- Route Name -->
            <div class="form-group">
                <label for="everoute-name" class="col-sm-3 control-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" name="name" id="everoute-name" class="form-control" value="{{ old('name') }}">
                </div>
            </div>

            <!-- Route Waypoints -->
            <div class="form-group">
                <label for="everoute-waypointsdump" class="col-sm-3 control-label">Waypoints</label>
                <div class="col-sm-6">
                    <textarea name="waypointsdump" id="everoute-waypointsdump" class="form-control">{{ old('waypointsdump') }}</textarea>
                </div>
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
    </div>
</div>
