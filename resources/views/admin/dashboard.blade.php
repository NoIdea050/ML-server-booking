@extends('admin.layouts.app')

@section('header-links')
<link href="{{ asset('all/admin/plugins/apex/apexcharts.css')}}" rel="stylesheet" type="text/css">
<link href="{{ asset('all/admin/assets/css/dashboard/dash_1.css')}}" rel="stylesheet" type="text/css" />
{{-- Modal Links --}}
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="{{ asset('all/admin/plugins/animate/animate.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('all/admin/assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
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

@if(Auth::check() && Auth::user()->role_id == 1)
<?php $url_group = 'superadmin'; ?>
@elseif(Auth::check() && Auth::user()->role_id == 2)
<?php $url_group = 'admin'; ?>
@elseif(Auth::check() && Auth::user()->role_id == 3)
<?php $url_group = 'staff'; ?>
@endif

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

            <div class="col-12 layout-spacing">
                <div class="widget widget-card-four pt-3 px-3">
                    <div class="widget-content">
                        <h4 class="text-center">Request For Credit</h4>
                        <hr>
                        <div class="table-responsive mb-4">
                            <table id="style-3" class="table style-3  table-hover">
                                <thead>
                                    <tr>
                                        <th>SL.</th>
                                        <th>Info</th>
                                        <th>Message</th>
                                        <th>Amout(Credit)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach($requested_credits as $row)

                                    <tr>
                                        <td class="checkbox-column"> {{$i++}} </td>
                                        <td>
                                            <span><b>By:</b>{{ $row->user_info->name }}</span>
                                            @if ($row->requested_date_and_time)
                                                <div><b>Date & Time: </b>{{ date('d M, Y', strtotime($row->requested_date_and_time)) }} | {{ date('h:i a', strtotime($row->requested_date_and_time)) }}</div>
                                            @endif
                                        </td>
                                        <td><div>Message: {{ $row->message }}</div></td>
                                        <td>{{ $row->credit }}</td>
                                        <td>

                                            <button type="button"
                                                class="btn m-0 p-0 px-1 btn-success"
                                                data-toggle="modal" data-target="#accepet-modal-{{ $row->id }}"
                                                title="Accept">
                                                <i class="fa fa-check"
                                                    style="font-size:10px;"></i>
                                            </button>
                                            <button type="button"
                                                class="btn m-0 p-0 px-1 btn-warning"
                                                data-toggle="modal" data-target="#reject-modal-{{ $row->id }}"
                                                title="Reject">
                                                <i class="fa fa-times"
                                                    style="font-size:10px;"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <div id="accepet-modal-{{ $row->id }}"
                                        class="modal animated zoomInUp custo-zoomInUp" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-x">
                                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                                        </svg>
                                                    </button>
                                                    <div
                                                        class="d-flex flex-column justify-content-between align-items-center">
                                                        <i class="fa fa-question-circle text-warning"
                                                            style="font-size: 70px"></i>
                                                        <h4 class="modal-title">Accept Record</h4>
                                                    </div>
                                                    <p class="modal-text text-center mt-3">Do you want to accept the record?</p>
                                                    <div class="mt-3 d-flex justify-content-center">
                                                        <button title="No" class="btn btn-light mr-2"
                                                            data-dismiss="modal">
                                                            <i class="fa fa-times"></i> No
                                                        </button>
                                                        <a href="{{ route($url_group.'.user.credit-history.accept', $row->id) }}"  
                                                            title="Accept" class="btn btn-danger ml-2"><i class="fa fa-check"></i> Yes</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="reject-modal-{{ $row->id }}"
                                        class="modal animated zoomInUp custo-zoomInUp" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-x">
                                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                                        </svg>
                                                    </button>
                                                    <div
                                                        class="d-flex flex-column justify-content-between align-items-center">
                                                        <i class="fa fa-question-circle text-warning"
                                                            style="font-size: 70px"></i>
                                                        <h4 class="modal-title">Reject Record</h4>
                                                    </div>
                                                    <p class="modal-text text-center mt-3">Do you want to reject the record?</p>
                                                    <div class="mt-3 d-flex justify-content-center">
                                                        <button title="No" class="btn btn-light mr-2"
                                                            data-dismiss="modal">
                                                            <i class="fa fa-times"></i> No
                                                        </button>
                                                        <a href="{{ route($url_group.'.user.credit-history.reject', $row->id) }}"  
                                                            title="Reject" class="btn btn-danger ml-2"><i class="fa fa-check"></i> Yes</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
