<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Login | Peta Status Mutu Air</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('css/bootstrap.css')}}" rel="stylesheet">

    <!-- Custom Css -->
    <link href="{{ asset('css/style.css')}}" rel="stylesheet">
</head>

<body>
    <div id="image-bg">
        <div class="black-bg">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                    </div> 
                    <div class="col-sm-4" style="padding-top:120px">
                     @if ($errors->any())
                     <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">
                            ×
                        </button>
                        {{$errors->first()}}
                    </div>
                    @endif
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    <div id="wrap-login">
                        <form class="form-signin" method="POST" action="{{ route('login') }}">
                            @csrf
                            <h4 style="text-align:center;color:#0f3c6c;font-family: myf">Login Peta Status Mutu Air</h4>
                            <br>
                            <input type="text" class="form-control" placeholder="Username" name="username" required autofocus>
                            <br>
                            <input type="password" class="form-control" placeholder="Password" name="password" required>
                            <br>
                            <br>
                            <button class="btn btn-lg btn-primary btn-block" type="submit">
                                Login
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
            </div> 
        </div>
    </div>
</div>

<script src="{{ asset('js/jque.js')}}"></script>
<script src="{{ asset('js/bootstrap.js')}}"></script>

</body>

</html>
