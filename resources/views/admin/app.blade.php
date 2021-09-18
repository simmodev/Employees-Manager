<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ready</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body >
<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
<div class="wrapper">
    <div class="sidebar">
        <h2>Controle Panel</h2>
        <ul class='nav-items'> 
            <a href="#"><li><i class="fas fa-home"></i>Home</li></a>
            <a href="{{route('admin.users.dashboard')}}"><li><i class="fas fa-user"></i>Employees Dashboard</li></a>
            <a href="{{route('admin.projects.dashboard')}}"><li><i class="fas fa-address-card"></i>Projects</li></a>
            <a href="{{route('admin.tasks.dashboard')}}"><li><i class="fas fa-project-diagram"></i>Tasks</li></a>
            <a href="#"><li><i class="fas fa-blog"></i>Blogs</li></a></li>
            <a href="#"><li><i class="fas fa-address-book"></i>Contact</li></a>
            <a href="#"><li><i class="fas fa-map-pin"></i>Map</li></a>
        </ul> 
    </div>
    <div class="main_content">
        <div class="header fw-bold text-center">بسم الله الرحمن الرحيم.</div>  
        <div class="container mt-3">
            @yield('content')
            @yield('script')
        </div>
    </div>
</div>


    <script src="{{asset('js/app.js')}}"></script>
</body>
</html>
