<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processmaker API App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="{{asset('css/styles.min.css')}}">
</head>

<body>
<div id="wrapper">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
            <div class="panel panel-default login-panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Processmaker API - Login </h3></div>
                <div class="panel-body">
                    <form method="post" action="login">
                        {{csrf_field()}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                       {{ $error }}
                                    @endforeach
                            </div>
                        @endif

                        <div class="form-group">
                            <label class="control-label">Username </label>
                            <input class="form-control" type="text" name="username" id="login_username">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Password </label>
                            <input class="form-control" type="password" name="password" id="login_password">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success btn-block" type="submit">Login </button>
                        </div>
                    </form>
                    <p class="text-center"><a href="settings">Settings</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>