<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Admin-Login</title>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('all/admin/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('all/admin/assets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('all/admin/assets/css/authentication/form-2.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('all/admin/assets/css/forms/theme-checkbox-radio.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('all/admin/assets/css/forms/switches.css')}}">

    <!-- Favicon -->
    <link href="{{ asset('website/img/logo/favicon.png') }}" rel="icon" />
    <link href="{{ asset('website/img/logo/favicon.png') }}" rel="apple-touch-icon" />
</head>
<body class="form">
    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">
                        <h1 class="">Admin Password Reset</h1>
                        <p class="">Enter Your Email To Reset Password</p>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if(Session::has('error'))
                            <div class="alert alert-danger text-center">
                                {{ Session::get('error')}}
                            </div>
                        @endif
                        @if(Session::has('success'))
                            <div class="alert alert-success text-center">
                                {{ Session::get('success')}}
                            </div>
                        @endif
                        <form class="text-left" method="POST" action="{{ route('admin.forgot.password.link') }}">
                            <div class="form">
                                @csrf
                                <div id="username-field" class="field-wrapper input">
                                    <label for="username">Email</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <input id="username" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus class="form-control" placeholder="e.g John_Doe">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('admin-login') }}">Back To Login</a>
                                </div>
                            </div>
                        </form>
                    </div>                    
                </div>
            </div>
        </div>
    </div>

    
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('all/admin/assets/js/libs/jquery-3.1.1.min.js')}}"></script>
    <script src="{{ asset('all/admin/bootstrap/js/popper.min.js')}}"></script>
    <script src="{{ asset('all/admin/bootstrap/js/bootstrap.min.js')}}"></script>
    
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('all/admin/assets/js/authentication/form-2.js')}}"></script>

</body>

</html>




