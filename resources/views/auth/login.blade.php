<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login Form</title>

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.16/tailwind.min.css'>

</head>

<body>

    <body class="bg-gray-200 font-sans text-gray-700">
        <div class="container mx-auto p-8 flex">
            <div class="max-w-md w-full mx-auto">
                <h1 class="text-4xl text-center mb-12 font-thin">Login</h1>

                <div class="bg-white rounded-lg overflow-hidden shadow-2xl">
                    <div class="p-8">
                        @if(Session::has('error'))
                        <div class="alert alert-danger text-center text-blue" style="color:red;background:#ffffdb">
                            {{ Session::get('error')}}
                        </div>
                        @endif
                        @if(Session::has('success'))
                        <div class="alert alert-success text-center" style="color:red;background:#ffffdb">
                            {{ Session::get('success')}}
                        </div>
                        @endif
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-5">
                                <label for="username"
                                    class="block mb-2 text-sm font-medium text-gray-600">Username</label>

                                <input type="text"
                                    class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none form-control @error('username') is-invalid @enderror"
                                    placeholder="Username" name="username" value="{{ old('username') }}" required
                                    autocomplete="username" autofocus>
                                @error('username')
                                <span class="invalid-feedback" style="color:red;background:#ffffdb" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="password"
                                    class="block mb-2 text-sm font-medium text-gray-600">Password</label>

                                <input name="password"
                                    class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none form-control @error('password') is-invalid @enderror"
                                    type="password" required autocomplete="current-password" placeholder="Password">
                                @error('password')
                                <span class="invalid-feedback" style="color:red;background:#ffffdb" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <button class="w-full p-3 mt-4 bg-indigo-600 text-white rounded shadow"
                                type="submit">Login</button>


                        </form>
                    </div>

                    <div class="flex justify-between p-8 text-sm border-t border-gray-300 bg-gray-100">
                        <a href="{{route('register')}}" class="font-medium text-indigo-500">Create account? Register</a>

                        @if (Route::has('password.request'))
                        <span><a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </body>

</body>

</html>