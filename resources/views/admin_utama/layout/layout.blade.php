<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Peta Status Mutu Air</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('css/bootstrap.css')}}" rel="stylesheet">

    <!-- Custom Css -->
    <link href="{{ asset('css/style.css')}}" rel="stylesheet">
    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jque.js')}}"></script>

</head>

<body>
    <nav class="navbar navbar-expand-md nav-atas navbar-dark">
      <a class="navbar-brand" href="#" style="margin-right: 70px">Admin Utama</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="{{route('admin_utama_beranda')}}">Beranda</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin_utama_variable')}}">Variable & Himpunan Fuzzy</a>
        </li>  
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin_utama_aturan')}}">Aturan Fuzzy</a>
        </li> 
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin_utama_sungai')}}">Admin & Sungai</a>
        </li>  
    </ul>
    <ul class="navbar-nav ml-auto">
        <li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();" style="color:#fff"><i class="menu-icon fa fa-sign-out"></i>Logout </a>
        </li>
    </ul>
</div>  
</nav>
@yield('content')
</body>
</html>