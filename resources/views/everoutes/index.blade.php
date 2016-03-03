@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Route
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    <!-- New Task Form -->
                    <form action="/route" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Task Name -->
                        <div class="form-group">
                            <label for="everoute-name" class="col-sm-3 control-label">Name</label>

                            <div class="col-sm-6">
                                <input type="text" name="name" id="everoute-name" class="form-control" value="{{ old('everoute') }}">
                            </div>
                        </div>

                        <!-- Add Task Button -->
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

            <!-- Current Tasks -->
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
                                            <form action="/routes/load/{{ $route->id }}" method="GET">
                                                {{ csrf_field() }}

                                                <button type="submit" id="load-everoute-{{ $route->id }}" class="btn">
                                                    <i class="fa fa-btn"></i>Load
                                                </button>
                                            </form>
                                        </td>

                                        <!-- Route Edit Button -->
                                        <td>
                                            <form action="/routes/edit/{{ $route->id }}" method="GET">
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
        </div>
    </div>
@endsection
