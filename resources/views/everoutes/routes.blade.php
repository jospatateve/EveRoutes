<!-- Current Waypoints -->
@if (count($everoutes) > 0)
    <div class="panel panel-default">
        <div class="panel-heading">
            Current Routes
        </div>

        <div class="panel-body">
            @if (Session::has('loadedsuccess'))
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Route "{{ Session::get('loadedsuccess') }}" successfully loaded into EVE.</strong>
                </div>
            @endif
            @if (Session::has('exception'))
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Failed to load route ({{ Session::get('exception') }}).</strong>
                </div>
            @endif

            <table class="table table-striped">
                 <thead>
                    <th>Route</th>
                    <th>&nbsp;</th>
                </thead>
                <tbody>
                    @foreach ($everoutes as $route)
                        <tr>
                            <td class="table-text">
                                <a href="{{ url('/route/'.$route->id) }}">{{ $route->name }}</a>
                            </td>

                            <td class="text-right">
                                <form id="form-load-everoute-{{ $route->id }}" action="{{ url('/route/'.$route->id.'/loadwaypoints') }}" method="GET">
                                    {{ csrf_field() }}
                                </form>

                                <form id="form-edit-everoute-{{ $route->id }}" action="{{ url('/route/'.$route->id.'/edit') }}" method="GET">
                                    {{ csrf_field() }}
                                </form>

                                <form id="form-delete-everoute-{{ $route->id }}" action="{{ url('/route/'.$route->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>

                                <!-- Confirm delete dialog -->
                                <div id="confirm-delete-{{ $route->id }}" class="text-left modal fade" role="dialog">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Confirm delete</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete the route "{{ $route->name }}"?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" form="form-delete-everoute-{{ $route->id }}" class="btn btn-primary">Yes</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="btn-group">
                                    <button type="submit" form="form-load-everoute-{{ $route->id }}" id="load-everoute-{{ $route->id }}" class="btn btn-default">
                                        <i class="fa fa-btn fa-play"></i>Load
                                    </button>
                                    <button type="submit" form="form-edit-everoute-{{ $route->id }}" id="load-everoute-{{ $route->id }}" class="btn btn-default">
                                        <i class="fa fa-btn fa-edit"></i>Edit
                                    </button>
                                    <button type="button" data-toggle="modal" data-target="#confirm-delete-{{ $route->id }}" id="delete-everoute-{{ $route->id }}" class="btn btn-danger">
                                        <i class="fa fa-btn fa-trash"></i>Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="panel panel-default">
        <div class="panel-heading">
            Current Routes
        </div>

        <div class="panel-body">
            <p>No routes found.</p>
        </div>
    </div>
@endif
