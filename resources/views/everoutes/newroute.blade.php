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
                <div class="col-sm-6"><div class="input-group">
                    <input type="text" name="waypoints[]" id="everoute-waypoints-" class="form-control" value="">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-success btn-add" id="add_system_name">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                    </span>
                </div></div>
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
 
 <!-- dialog containing the paste form -->
<div id="pasteformdialog" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Paste form</h4>
            </div>
            <div class="modal-body">
                <!-- Paste Route Form -->
                <form id="pasteform" action="/route/paste" method="POST" class="form-horizontal">
                    {{ csrf_field() }}

                    <!-- Route Name -->
                    <div class="form-group">
                        <label for="everoute-name" class="col-sm-3 control-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" id="everoute-name" class="form-control" value="{{ old('name') }}">
                        </div>
                    </div>

                    <!-- Route Waypoints -->
                    <div class="form-group">
                        <label for="everoute-waypointsdump" class="col-sm-3 control-label">Waypoints</label>
                        <div class="col-sm-9">
                            <textarea name="waypointsdump" id="everoute-waypointsdump" class="form-control" rows="10">{{ old('waypointsdump') }}</textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="pasteform" class="btn btn-primary">Ok</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
