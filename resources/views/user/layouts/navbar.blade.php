<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #4B56D2">
    <div class="container">
        <b><a class="navbar-brand" href="{{ route('user.dashboard')}}">ML Server Booking</a></b>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-dark text-white active " aria-current="page"
                        href="{{ route('user.dashboard')}}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark text-white" href="{{ route('user.booking-history')}}">Booking History</a>

                </li>

            </ul>

            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="{{ !empty(Auth::user()->user_more_info) ? asset('storage/'.Auth::user()->user_more_info->avatar) : asset('https://cdn-icons-png.flaticon.com/512/3135/3135715.png') }}" class="rounded-circle"
                            height="25" loading="lazy" />
                            
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg-end">
                        <li><a class="dropdown-item" href="{{ route('user.profile')}}">My Profile</a></li>
                        <!-- <li><a class="dropdown-item" href="#">Logout</a></li> -->
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>

                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>