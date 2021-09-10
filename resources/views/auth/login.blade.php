<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
    
    <div class="container">
        <div class="card mx-auto mt-4 col-md-6">
            @if (Session::get('email'))
                {{Session::get('email')}}
            @endif
            <div class="card-body">
                <form action="{{route('login')}}" method="post">
                    @csrf
                    <img src="{{asset('img/login.svg')}}" class="card-img-top">
                    <input type="email" class="form-control mt-4" name="email">
                    <button class="btn btn-primary text-white mt-3" type="submit">تسجيل الدخول</button>
                </form>
            </div>
        </div>
    </div>

<script src="{{asset('js/app.js')}}"></script>
</body>
</html>