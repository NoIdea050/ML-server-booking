<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.16/tailwind.min.css'>

</head>

<body>

    <body class="bg-gray-200 font-sans text-gray-700">
        <div class="container mx-auto p-8 flex">
            <div class="max-w-md w-full mx-auto">
                <h1 class="text-4xl text-center mb-12 font-thin">Reset Password</h1>

                <div class="bg-white rounded-lg overflow-hidden shadow-2xl">
                    <div class="p-8">
                        @if(Session::has('error'))
                        <div class="alert alert-danger text-center" style="color:red;background:#ffffdb">
                            {{ Session::get('error')}}
                        </div>
                        @endif
                        @if(Session::has('success'))
                        <div class="alert alert-success text-center" style="color:red;background:#ffffdb">
                            {{ Session::get('success')}}
                        </div>
                        @endif
                        @if (session('status'))
                        <div class="alert alert-success" role="alert" style="color:red;background:#ffffdb">
                            {{ session('status') }}
                        </div>
                        @endif
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="mb-5">
                                <label for="username" class="block mb-2 text-sm font-medium text-gray-600">Email
                                    Address</label>

                                <input type="text"
                                    class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none form-control @error('email') is-invalid @enderror"
                                    placeholder="Email Address" name="email" value="{{ $email ?? old('email') }}"
                                    required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" style="color: red;" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="password"
                                    class="block mb-2 text-sm font-medium text-gray-600">Password</label>

                                <input type="password" name="password"
                                    class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none form-control @error('password') is-invalid @enderror"
                                    placeholder="Password" required autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="confirm_password"
                                    class="block mb-2 text-sm font-medium text-gray-600">Confirm
                                    Password</label>

                                <input type="password" name="password_confirmation" required autocomplete="new-password"
                                    class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none"
                                    placeholder="Confirm Password">
                            </div>
                            <button class="w-full p-3 mt-4 bg-indigo-600 text-white rounded shadow" type="submit">Reset
                                Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <!-- partial -->

</body>

</html>