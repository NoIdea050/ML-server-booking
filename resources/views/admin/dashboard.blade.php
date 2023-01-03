@extends('admin.layouts.app')

@section('header-links')
<link href="{{ asset('all/admin/plugins/apex/apexcharts.css')}}" rel="stylesheet" type="text/css">
<link href="{{ asset('all/admin/assets/css/dashboard/dash_1.css')}}" rel="stylesheet" type="text/css" />
<style type="text/css">
.bg-light-blue {
    background-color: #80ced6;
}

.bg-light-brown {
    background-color: #f18973;
}

.bg-light-gray {
    background-color: #A9A9A9;
}

.bg-light-pink {
    background-color: #FFB6C1;
}

.bg-light-green {
    background-color: #66CDAA;
}

.bg-light-violet {
    background-color: #EE82EE;
}

.bg-light-orange {
    background-color: #FF7F50;
}

.bg-light-yellow {
    background-color: #F0E68C;
}

.bg-light-roseBrown {
    background-color: #BC8F8F;
}

.value {}

.ass {
    padding: 2px;
    height: 50px;
    width: 100%;
}

.ass h6 {
    padding: 0px;
    margin: 0px;
    font-size: 16px;
    font-weight: 600;
    color: white;
    letter-spacing: 0;
}

.ass p {
    padding: 0px;
    margin: 0px;
    font-size: 15px;
    font-weight: 600;
    color: white;
    text-align: center;
}

.css-selector {
    background: linear-gradient(273deg, #e315d7, #18cc3e, #0d49c7, #0793c9);
    background-size: 800% 800%;

    -webkit-animation: t2 18s ease infinite;
    -moz-animation: t2 18s ease infinite;
    animation: t2 18s ease infinite;
}

@-webkit-keyframes t2 {
    0% {
        background-position: 0% 50%
    }

    50% {
        background-position: 100% 50%
    }

    100% {
        background-position: 0% 50%
    }
}

@-moz-keyframes t2 {
    0% {
        background-position: 0% 50%
    }

    50% {
        background-position: 100% 50%
    }

    100% {
        background-position: 0% 50%
    }
}

@keyframes t2 {
    0% {
        background-position: 0% 50%
    }

    50% {
        background-position: 100% 50%
    }

    100% {
        background-position: 0% 50%
    }
}

.css-selector2 {
    background: linear-gradient(273deg, #04aa8f, #4d0f9d, #cc00ca, #d73a0b);
    background-size: 800% 800%;

    -webkit-animation: t1 18s ease infinite;
    -moz-animation: t1 18s ease infinite;
    animation: t1 18s ease infinite;
}

@-webkit-keyframes t1 {
    0% {
        background-position: 0% 50%
    }

    50% {
        background-position: 100% 50%
    }

    100% {
        background-position: 0% 50%
    }
}

@-moz-keyframes t1 {
    0% {
        background-position: 0% 50%
    }

    50% {
        background-position: 100% 50%
    }

    100% {
        background-position: 0% 50%
    }
}

@keyframes t1 {
    0% {
        background-position: 0% 50%
    }

    50% {
        background-position: 100% 50%
    }

    100% {
        background-position: 0% 50%
    }
}
</style>
@endsection

@section('contents')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">

            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four css-selector pt-3 pl-2 pr-3">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="ass">
                                <h6>{{$user}}</h6>
                                <p>Total users</p>
                            </div>
                            <div class="w-icon">
                                <i class="fa fa-users" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four css-selector pt-3 pl-2 pr-3">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="ass">
                                <h6>{{$booking}}</h6>
                                <p>Total Booking</p>
                            </div>
                            <div class="w-icon">
                                <i class="fa fa-users" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four css-selector pt-3 pl-2 pr-3">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="ass">
                                <h6>{{$pending}}</h6>
                                <p>Total Pending</p>
                            </div>
                            <div class="w-icon">
                                <i class="fa fa-users" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four css-selector pt-3 pl-2 pr-3">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="ass">
                                <h6>{{$approved}}</h6>
                                <p>Total Approved</p>
                            </div>
                            <div class="w-icon">
                                <i class="fa fa-users" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four css-selector pt-3 pl-2 pr-3">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="ass">
                                <h6>{{$rejected}}</h6>
                                <p>Total Rejected</p>
                            </div>
                            <div class="w-icon">
                                <i class="fa fa-users" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four css-selector pt-3 pl-2 pr-3">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="ass">
                                <h6>{{$current_month}}</h6>
                                <p>Total Servers Booked In Current Month</p>
                            </div>
                            <div class="w-icon">
                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
