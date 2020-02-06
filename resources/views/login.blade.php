<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="{{ __('voyager::generic.is_rtl') == 'true' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="none" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="admin login">
    <title>Admin - {{ Voyager::setting("admin.title") }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{asset('css/publimovil.css')}}">
    <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.min.css')}}">
    @if (__('voyager::generic.is_rtl') == 'true')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.css">
        <link rel="stylesheet" href="{{ voyager_asset('css/rtl.css') }}">
    @endif

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
</head>
<body class="login">
    <div class="d-flex align-items-center justify-content-center content-login">
        <div id="contenedor">
            <div class="card shadow shadow-lg" id="card-login" >
                <div class="card-body" style="padding:50px">
                    <h3 class="text-center text-publimovil">{{ __('Login') }}</h3>
                    <form action="{{ route('voyager.login') }}" method="POST">
                        @csrf
                        <div class="form-group form-group-default" id="emailGroup">
                            <label>{{ __('Correo') }}</label>
                            <div class="controls">
                                <input type="text" name="email" id="email" value="{{ old('email') }}" class="form-control form-control-sm form-control-pu" required>
                             </div>
                        </div>
                        <div class="form-group form-group-default" id="passwordGroup">
                            <label>{{ __('voyager::generic.password') }}</label>
                            <div class="controls">
                                <input type="password" name="password" class="form-control form-control-sm form-control-pu" required>
                            </div>
                        </div>
                        <div class="row justify-content-center ">
                            <ul class="nav">    
                                @foreach ($countries as $country)
                                    <li class="nav-item" style="width:16%">
                                        <img src="{{$country->image}}" class="img-fluid border rounded-circle" alt="{{$country->name}}">
                                    </li>
                                @endforeach
                            </ul>
                            {{-- @foreach ($countries as $country)
                                <div class="col-12">
                                    <img src="{{asset($country->image)}}" alt="{{$country->abbreviation}}" width="30px" height="30px" class="rounded-circle border country">
                                </div>
                            @endforeach --}}
                    
                        </div>
                        
                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-publimovil login-button">
                                Login
                            </button>
                        </div>
                    </form>
    
                   {{--  <div class="row">
                        <div class="col text-center">
                            <a href="" class="forget">¿Olvidó su contraseña?</a>
                        </div>
                    </div> --}}

                    <div style="clear:both"></div>

                    @if(!$errors->isEmpty())
                    <div class="alert alert-red">
                      <ul class="list-unstyled">
                          @foreach($errors->all() as $err)
                          <li>{{ $err }}</li>
                          @endforeach
                      </ul>
                    </div>
                    @endif
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center ">
                <div class="row justify-content-center mt-4 ">
                    <div class="col-lg-12 col-md-8 col-xs-8">
                        <img src="{{asset('images/letras.png')}}" class="img-fluid " alt="">
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center ">
                <div class="row justify-content-center mt-2 ">
                    <div class="col-lg-2 col-2">
                        <a href=""><i class="fa fa-facebook-official fa-2x text-white" aria-hidden="true"></i></a>
                    </div>
                    <div class="col-lg-2 col-2">
                        <a href=""><i class="fa fa-instagram fa-2x text-white" aria-hidden="true"></i></a>
                    </div>
                    <div class="col-lg-2 col-2">
                        <a href=""><i class="fa fa-globe fa-2x text-publimovil" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- <script>
    var btn = document.querySelector('button[type="submit"]');
    var form = document.forms[0];
    var email = document.querySelector('[name="email"]');
    var password = document.querySelector('[name="password"]');
    btn.addEventListener('click', function(ev){
        if (form.checkValidity()) {
            btn.querySelector('.signingin').className = 'signingin';
            btn.querySelector('.signin').className = 'signin hidden';
        } else {
            ev.preventDefault();
        }
    });
    email.focus();
    document.getElementById('emailGroup').classList.add("focused");

    // Focus events for email and password fields
    email.addEventListener('focusin', function(e){
        document.getElementById('emailGroup').classList.add("focused");
    });
    email.addEventListener('focusout', function(e){
       document.getElementById('emailGroup').classList.remove("focused");
    });

    password.addEventListener('focusin', function(e){
        document.getElementById('passwordGroup').classList.add("focused");
    });
    password.addEventListener('focusout', function(e){
       document.getElementById('passwordGroup').classList.remove("focused");
    });

</script> --}}
</body>
</html>
