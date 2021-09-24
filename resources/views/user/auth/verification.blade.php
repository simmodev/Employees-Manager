<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
    
    <div class="container">
        <div class="card mx-auto mt-4 col-md-6">
            
            <div class="card-body">
                @if (isset($message))
                    <div class="alert alert-danger text-center">
                        {{$message}}
                    </div>
                @endif
                <form action="{{route('verification')}}" method="post">
                    @csrf
                    <img src="{{asset('img/login.svg')}}" class="card-img-top">
                    <div class="col-md-6">
                        <input type="number" class="form-control mt-4" name="verification_code" required>
                        <button class="btn btn-primary text-white mt-3 px-4" type="submit">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script src="{{asset('js/app.js')}}"></script>
</body>
</html>