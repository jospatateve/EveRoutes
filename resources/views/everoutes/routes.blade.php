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

                            <!-- Route Load Button -->
                            <td>
                                <form action="/route/{{ $route->id }}/loadwaypoints" method="GET">
                                    {{ csrf_field() }}

                                    <button type="submit" id="load-everoute-{{ $route->id }}" class="btn">
                                        <i class="fa fa-btn"></i>Load
                                    </button>
                                </form>
                            </td>

                            <!-- Route Edit Button -->
                            <td>
                                <form action="/route/{{ $route->id }}/edit" method="GET">
                                    {{ csrf_field() }}

                                    <button type="submit" id="load-everoute-{{ $route->id }}" class="btn">
                                        <i class="fa fa-btn"></i>Edit
                                    </button>
                                </form>
                            </td>

                             <!-- Route Delete Button -->
                            <td>
                                <form action="/route/{{ $route->id }}" method="POST">
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
