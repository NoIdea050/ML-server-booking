@extends('admin.layouts.app')
@section('header-links')

<!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
<link rel="stylesheet" type="text/css" href="{{ asset('all/admin/plugins/table/datatable/datatables.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('all/admin/assets/css/forms/theme-checkbox-radio.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('all/admin/plugins/table/datatable/dt-global_style.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('all/admin/plugins/table/datatable/custom_dt_custom.css')}}">
<!-- END PAGE LEVEL CUSTOM STYLES -->

{{-- Modal Links --}}
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="{{ asset('all/admin/plugins/animate/animate.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('all/admin/assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->

@endsection

@section('contents')

@if(Auth::check() && Auth::user()->role_id == 1)
<?php $url_group = 'superadmin'; ?>
@elseif(Auth::check() && Auth::user()->role_id == 2)
<?php $url_group = 'admin'; ?>
@elseif(Auth::check() && Auth::user()->role_id == 3)
<?php $url_group = 'staff'; ?>
@endif
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <div class="col-lg-12">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <div class="table-responsive mb-4">
                                <div class="row page-title-wrapper">
                                    <div class="col-sm-12 col-md-2"></div>
                                    <div class="col-10 col-sm-10 col-md-8 title-wrapper">
                                        <h3 class="text-center title">Booking List</h3>
                                    </div>
                                    <div class="col-1 col-sm-1 col-md-1 refresh-btn-wrapper">
                                        <a href="{{ route($url_group.'.booking.index') }}"
                                            class="btn btn-warning refresh-btn" title="Refresh">
                                            <i class="fa fa-refresh refresh-icon" style="font-size:16px;"></i></a>
                                    </div>
                                </div>
                                <hr>
                                <table id="style-3" class="table style-3  table-hover">
                                    <thead>
                                        <tr>
                                            <th>SL.</th>
                                            <th>User Info</th>
                                            <th>Booking Info</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach($datas as $row)

                                        <tr>
                                            <td class="checkbox-column"> {{$i++}} </td>
                                            <td>User Name: {{$row->user->username}} <br>
                                                Email: {{$row->user->email}} <br>
                                                Credit: {{$row->credit ? $row->credit : $row->user->credit->total_credit_left}}</td>
                                            <td>Start Date:{{$row->start_date_and_time}} <br>End
                                                Date:{{$row->end_date_and_time}} <br>
                                                Type:{{$row->type}} <br>
                                                Credit Cost:{{$row->credit_cost}} <br>

                                            </td>
                                            <td class="text-center"><span
                                                    class="shadow-none badge badge-primary"></span>
                                                <?php if ($row->status == 0) {
                                                    echo 'Pending';
                                                } elseif($row->status == 1) {
                                                    echo 'Accepted';
                                                }
                                                elseif($row->status == 2) {
                                                    echo 'Rejected';
                                                } ?>
                                            </td>
                                        </tr>
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
</div>
@endsection

@section('footer-links')

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ asset('all/admin/plugins/table/datatable/datatables.js')}}"></script>
<script>
c3 = $('#style-3').DataTable({
    "oLanguage": {
        "oPaginate": {
            "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
            "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
        },
        "sInfo": "Showing page _PAGE_ of _PAGES_",
        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        "sSearchPlaceholder": "Search...",
        "sLengthMenu": "Results :  _MENU_",
    },
    "stripeClasses": [],
    "lengthMenu": [5, 20, 50, 100],
    "pageLength": 50
});

multiCheck(c3);
</script>
<!-- END PAGE LEVEL SCRIPTS -->
@endsection