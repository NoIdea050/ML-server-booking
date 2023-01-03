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
                                        <h3 class="text-center title">User List</h3>
                                    </div>
                                    <div class="col-1 col-sm-1 col-md-1 refresh-btn-wrapper">
                                        <a href="{{ route($url_group.'.user.index') }}"
                                            class="btn btn-warning refresh-btn" title="Refresh">
                                            <i class="fa fa-refresh refresh-icon" style="font-size:16px;"></i></a>
                                    </div>
                                </div>
                                <hr>
                                <table id="style-3" class="table style-3  table-hover">
                                    <thead>
                                        <tr>
                                            <th>SL.</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach($datas as $row)

                                        <tr>
                                            <td class="checkbox-column"> {{$i++}} </td>
                                            <td>{{$row->name}}</td>
                                            <td>{{$row->email}}</td>
                                            <td class="text-center"><span
                                                    class="shadow-none badge badge-primary"></span>
                                                <?php if ($row->status == 1) {
                                                    echo 'Active';
                                                } else {
                                                    echo 'Inactive';
                                                } ?>
                                            </td>
                                            <td class="text-right">
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
                                                                href="{{ route($url_group.'.user.status.change',$row->id) }}">
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
