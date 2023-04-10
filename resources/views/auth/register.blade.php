<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration Form</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.16/tailwind.min.css'>

</head>

<body class="bg-gray-200 font-sans text-gray-700">
    <div class="container mx-auto p-8 flex">
        <div class="max-w-md w-full mx-auto">
            <h1 class="text-4xl text-center mb-12 font-thin">Registration</h1>

            <div class="bg-white rounded-lg overflow-hidden shadow-2xl">
                <div class="p-8">
                    <form method="POST" class="" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-5">
                            <label for="Name" class="block mb-2 text-sm font-medium text-gray-600">Name</label>

                            <input type="text" name="name"
                                class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none form-control @error('name') is-invalid @enderror"
                                placeholder="Your Name" value="{{ old('name') }}" required autocomplete="name"
                                autofocus>
                            @error('name')
                            <span class="invalid-feedback" style="color:red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-5">
                            <label for="username" class="block mb-2 text-sm font-medium text-gray-600">Username</label>

                            <input type="text" name="username"
                                class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none form-control @error('username') is-invalid @enderror"
                                placeholder="Username" value="{{ old('username') }}" required autocomplete="username"
                                autofocus>
                            @error('username')
                            <span class="invalid-feedback" style="color:red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="dob" class="block mb-2 text-sm font-medium text-gray-600">Date of birth</label>
                            <div class="relative">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input type="date" name="dob"
                                    class="bg-gray-200 text-gray-900 text-sm rounded-lg block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white border border-transparent focus:outline-none form-control @error('dob') is-invalid @enderror"
                                    placeholder="Select date" value="{{ old('dob') }}" autofocus>
                                @error('dob')
                                <span class="invalid-feedback" style="color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>

                        <div class="mb-5">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-600">Email</label>

                            <input type="email" name="email"
                                class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none form-control @error('email') is-invalid @enderror"
                                placeholder="Email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                            <span class="invalid-feedback" style="color:red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-600">Password</label>

                            <input type="password" name="password"
                                class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none form-control @error('password') is-invalid @enderror"
                                placeholder="Password" required autocomplete="new-password">
                        </div>
                        <div class="mb-5">
                            <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-600">Confirm
                                Password</label>

                            <input type="password" name="password_confirmation" required autocomplete="new-password"
                                class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none"
                                placeholder="Confirm Password">
                        </div>

                        <button class="w-full p-3 mt-4 bg-indigo-600 text-white rounded shadow"
                            type="submit">Register</button>
                    </form>
                </div>

                <div class="flex justify-between p-8 text-sm border-t border-gray-300 bg-gray-100">
                    <a href="{{route('login')}}" class="font-medium text-indigo-500">Already have an account? Login</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/flowbite@1.5.5/dist/datepicker.js"></script>
</body>

</html>