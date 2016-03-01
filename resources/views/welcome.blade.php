<!DOCTYPE html>
<html>
    <head>
        <title>EveRoutes</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                @if (!Auth::check())
                    <div class="title"><p>Sadew &amp; Jos<br/>Eve Online Project - Route Planner</p></div>
                    <a href= "{{url('login/eveonline')}}"><img src="{{url('ssologin.png')}}" alt="Login with Eve Online"/></a>
                @elseif (isset($location))
                    <div class="title"><p>{{ Auth::user()->name }} @ {{ $location }}</p></div>
                @endif
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops! Something went wrong!</strong>
                        <br/><br/>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </body>
</html>
