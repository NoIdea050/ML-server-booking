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
                            <div class="row page-title-wrapper">
                                <div class="col-sm-12 col-md-2"></div>
                                <div class="col-10 col-sm-10 col-md-8 title-wrapper">
                                    <h3 class="text-center title">Storage List</h3>
                                </div>
                                <div class="col-1 col-sm-1 col-md-1 refresh-btn-wrapper">
                                    <a href="{{ route($url_group.'.storage.create') }}"
                                        class="btn btn-primary refresh-btn" title="Refresh">
                                        <i class="fa fa-plus refresh-icon" style="font-size:16px;"></i></a>
                                </div>
                            </div>
                            <hr>
                            <div class="table-responsive mb-4">
                                <table id="style-3" class="table style-3  table-hover">
                                    <thead>
                                        <tr>
                                            <th>SL.</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Cost(Per Hour)</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach($datas as $row)

                                        <tr>
                                            <td class="checkbox-column"> {{$i++}} </td>
                                            <td>{{$row->title}}</td>
                                            <td>{{$row->type}}</td>
                                            <td>{{$row->cost_per_hour}} Credit(s)</td>
                                            <td class="text-center">
                                                <?php if ($row->status == 1) {
                                                    echo 'Active';
                                                } else {
                                                    echo 'Inactive';
                                                } ?>
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ route($url_group.'.storage.edit', $row->id) }}"
                                                    class="btn m-0 p-0 px-1 btn-warning"
                                                    title="Edit Data">
                                                    <i class="fa fa-edit }}"
                                                        style="font-size:10px;"></i>
                                                </a>

                                                <button type="button"
                                                    class="btn m-0 p-0 px-1 btn-{{ $row->status == 1 ? 'success' : 'danger' }}"
                                                    data-toggle="modal" data-target="#status-modal-{{ $row->id }}"
                                                    title="{{ $row->status == 1 ? 'Make Inactive' : 'Make Active' }}">
                                                    <i class="fa fa-{{ $row->status == 1 ? 'toggle-on' : 'toggle-off' }}"
                                                        style="font-size:10px;"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <div id="status-modal-{{ $row->id }}"
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
                                                            <h4 class="modal-title">Change Status</h4>
                                                        </div>
                                                        <p class="modal-text text-center mt-3">Do you want to
                                                            change status?</p>
                                                        <div class="mt-3 d-flex justify-content-center">
                                                            <button title="Keep Stable" class="btn btn-light mr-2"
                                                                data-dismiss="modal">
                                                                <i class="fa fa-times"></i> No
                                                            </button>

                                                            <a title="Make Inactive" class="btn btn-danger ml-2"
                                                                href="{{ route($url_group.'.storage.status.change',$row->id) }}">
                                                                <i class="fa fa-check"></i> Yes
                                                            </a>
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
