<html lang="en">
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
            <div class="card-body">
                <form action="{{route('login')}}" method="post">
                    @csrf
                    @if(session('fail'))
                        <div class="alert alert-danger text-center">
                            {{session('fail')}}
                        </div>
                    @endif
                    <img src="{{asset('img/login.svg')}}" class="card-img-top mb-3">
                    <input type="email" class="form-control mt-2" name="email">
                    <button class="btn btn-primary text-white mt-3" type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>

<script src="{{asset('js/app.js')}}"></script>
</body>
</html>