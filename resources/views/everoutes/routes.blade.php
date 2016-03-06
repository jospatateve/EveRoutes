<!-- Current Waypoints -->
@if (count($everoutes) > 0)
    <div class="panel panel-default">
        <div class="panel-heading">
            Current Routes
        </div>

        <div class="panel-body">
            <table class="table table-striped task-table">
                 <thead>
                    <th>Route</th>
                    <th>&nbsp;</th>
                </thead>
                <tbody>
                    @foreach ($everoutes as $route)
                        <tr>
                            <td class="table-text"><div>{{ $route->name }}</div></td>

                            <td style="text-align:right">
                                <!-- Route Load Button -->
                                <form style="display:inline" action="/route/{{ $route->id }}/loadwaypoints" method="GET">
                                    {{ csrf_field() }}

                                    <button type="submit" id="load-everoute-{{ $route->id }}" class="btn btn-default">
                                        <i class="fa fa-btn fa-play"></i>Load
                                    </button>
                                </form>

                                <!-- Route Edit Button -->
                                <form style="display:inline" action="/route/{{ $route->id }}/edit" method="GET">
                                    {{ csrf_field() }}

                                    <button type="submit" id="load-everoute-{{ $route->id }}" class="btn btn-default">
                                        <i class="fa fa-btn fa-edit"></i>Edit
                                    </button>
                                </form>

                                <!-- Route Delete Button -->
                                <form style="display:inline" action="/route/{{ $route->id }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button type="submit" id="delete-everoute-{{ $route->id }}" class="btn btn-danger">
                                        <i class="fa fa-btn fa-trash"></i>Delete
                                    </button>
                                </form>
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
