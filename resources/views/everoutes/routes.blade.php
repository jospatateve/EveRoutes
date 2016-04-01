<!-- Current Waypoints -->
@if (count($everoutes) > 0)
    <div class="panel panel-default">
        <div class="panel-heading">
            Current Routes
        </div>

        <div class="panel-body">
            @if (Session::has('loadedsuccess'))
                <div class="alert alert-success">
                    <strong>Route "{{ Session::get('loadedsuccess') }}" successfully loaded into EVE.</strong>
                </div>
            @endif
            @if (Session::has('exception'))
                <div class="alert alert-danger">
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
                            <td class="table-text">{{ $route->name }}</td>

                            <td class="text-right">
                                <!-- Route Load Button -->
                                <form id="form-load-everoute-{{ $route->id }}" action="{{ url('/route/'.$route->id.'/loadwaypoints') }}" method="GET">
                                    {{ csrf_field() }}
                                </form>

                                <!-- Route Edit Button -->
                                <form id="form-edit-everoute-{{ $route->id }}" action="{{ url('/route/'.$route->id.'/edit') }}" method="GET">
                                    {{ csrf_field() }}
                                </form>

                                <!-- Route Delete Button -->
                                <form id="form-delete-everoute-{{ $route->id }}" action="{{ url('/route/'.$route->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>

                                <div class="btn-group">
                                    <button type="submit" form="form-load-everoute-{{ $route->id }}" id="load-everoute-{{ $route->id }}" class="btn btn-default">
                                        <i class="fa fa-btn fa-play"></i>Load
                                    </button>
                                    <button type="submit" form="form-edit-everoute-{{ $route->id }}" id="load-everoute-{{ $route->id }}" class="btn btn-default">
                                        <i class="fa fa-btn fa-edit"></i>Edit
                                    </button>
                                    <button type="submit" form="form-delete-everoute-{{ $route->id }}" id="delete-everoute-{{ $route->id }}" class="btn btn-danger">
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
