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
                    <h3 class="panel-title">Processmaker API - Settings </h3></div>
                <div class="panel-body">

                        <form method="post" action="settings">
                        {{csrf_field()}}

                        <div class="form-group {{ $errors->settings->has('server_name') ? ' has-error' : '' }}">
                            <label class="control-label">Processmaker Server</label>
                            <input class="form-control" type="text" name="server_name" id="server_name">
                            @if ($errors->settings->has('server_name'))
                                <span class="help-block">
                                        <strong>{{ $errors->settings->first('server_name') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->settings->has('workflow') ? ' has-error' : '' }}">
                            <label class="control-label">Workspace Name</label>
                            <input class="form-control" type="text" name="workflow" id="workflow">
                            @if ($errors->settings->has('workflow'))
                                <span class="help-block">
                                        <strong>{{ $errors->settings->first('workflow') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->settings->has('client_id') ? ' has-error' : '' }}">
                            <label class="control-label">Client ID</label>
                            <input class="form-control" type="text" name="client_id"  id="client_id">
                            @if ($errors->settings->has('client_id'))
                                <span class="help-block">
                                        <strong>{{ $errors->settings->first('client_id') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->settings->has('client_secret') ? ' has-error' : '' }}">
                            <label class="control-label">Client Secret</label>
                            <input class="form-control" type="text" name="client_secret"  id="client_secret">
                            @if ($errors->settings->has('client_secret'))
                                <span class="help-block">
                                        <strong>{{ $errors->settings->first('client_secret') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success btn-block" type="submit">Save </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>