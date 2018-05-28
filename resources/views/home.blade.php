<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processmaker API App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{asset('css/styles.min.css')}}">
</head>

<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header"><a class="navbar-brand navbar-link" href="#">Processmaker API</a>
            <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
        </div>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#"><strong>{{$usr_name}}</strong> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li role="presentation"><a href="">Update Account</a></li>
                        <li role="presentation"><a href="{{url('/logout')}}">Signout </a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav hidden-sm hidden-md hidden-lg navbar-right">
                <li role="presentation"><a href="#">Home </a></li>
                <li role="presentation"><a href="#">Category </a></li>
                <li role="presentation"><a href="#">Product </a></li>
                <li role="presentation"><a href="#">Orders </a></li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#">Account <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li role="presentation"><a href="#">First Item</a></li>
                        <li role="presentation"><a href="#">Second Item</a></li>
                        <li role="presentation"><a href="#">Third Item</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid main-container">
    <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs sidebar">
        <div class="list-group"><a class="list-group-item"  href="{{url('/home')}}"><span>Home </span></a><a class="list-group-item"  href="{{url('/calendar')}}"><span>Calendar </span></a><a class="list-group-item"><span>Home </span></a><a class="list-group-item"><span>Home </span></a><a class="list-group-item"><span>Home </span></a>
            <a class="list-group-item"><span>Home </span></a>
        </div>
    </div>
    <div class="col-lg-10 col-md-10 col-sm-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Inbox </h3></div>
            <div class="panel-body">
                <div style="padding:10px;">
                    <table class="table" id="table_inbox">
                        <thead>
                        <tr>
                            <th><strong>Case Number</strong> </th>
                            <th><strong>Process</strong> </th>
                            <th><strong>Task</strong> </th>
                            <th><strong>Sent By</strong> </th>
                            <th><strong>Due Date</strong> </th>
                            <th><strong>Status</strong> </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cases as $case)
                        <tr>
                            <td>#{{$case->app_number}}</td>
                            <td>{{$case->app_pro_title}}</td>
                            <td>{{$case->app_tas_title}}</td>
                            <td>{{$case->app_del_previous_user}}</td>
                            <td>{{$case->del_task_due_date}}</td>
                            <td>{{$case->app_status}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="footer" style="padding:10px;">
    <hr>
    <p class="pull-right" style="margin:0px;">Copyright 2017 by <strong>Jhon Zylvin Moral Ramos</strong></p>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function(){
        var table = $('#table_inbox').DataTable({});


    });
</script>
</body>

</html>