@extends('admin.layouts.app')
@section('header-links')

@endsection

@section('contents')

@if(Auth::check() && Auth::user()->role_id == 1)
<?php $url_group = 'superadmin' ?>
@elseif(Auth::check() && Auth::user()->role_id == 2)
<?php $url_group = 'admin' ?>
@elseif(Auth::check() && Auth::user()->role_id == 3)
<?php $url_group = 'staff' ?>
@endif

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="">

                        </div>
                        <div class="custom-heading-wrapper">
                            <h1 class="m-0 p-0 custom-heading">System Setup</h1>
                            <div class="under-line-wrapper d-flex justify-content-around align-items-center">
                                <span class="left-line w-100"></span>
                                <span class="diamond"></span>
                                <span class="right-line w-100"></span>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route($url_group.'.system.settings') }}" class="btn btn-warning reload-btn">
                                <i class="fas fa-sync-alt reload-icon"></i> Reload
                            </a>
                        </div>
                    </div>

                    <div class="mt-5 from-wrapper">
                        <form action="{{ route($url_group.'.system.settings.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row mt-4">
                                <div class="col-sm-12 col-md-12">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon5">Project
                                                            Name</span>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control {{($errors->first('project_name') ? "border border-danger" : "")}}"
                                                        name="project_name"
                                                        value="{{ old('project_name') ? old('project_name') : $row->project_name }}"
                                                        placeholder="Enter Project Name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon5">Email</span>
                                                    </div>
                                                    <input type="email"
                                                        class="form-control {{($errors->first('email') ? "border border-danger" : "")}}"
                                                        name="email"
                                                        value="{{ old('email') ? old('email') : $row->email }}"
                                                        placeholder="Enter Email">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon5">Phone</span>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control {{($errors->first('phone') ? "border border-danger" : "")}}"
                                                        name="phone"
                                                        value="{{ old('phone') ? old('phone') : $row->phone }}"
                                                        placeholder="Enter Phone">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon5">Address</span>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control {{($errors->first('address') ? "border border-danger" : "")}}"
                                                        name="address"
                                                        value="{{ old('address') ? old('address') : $row->address }}"
                                                        placeholder="Enter Address">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon5">Monthly
                                                            Credit</span>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control {{($errors->first('monthly_credit') ? "border border-danger" : "")}}"
                                                        name="monthly_credit"
                                                        value="{{ old('monthly_credit') ? old('monthly_credit') : $row->monthly_credit }}"
                                                        placeholder="Enter Monthly Credit">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon5">CPU Cost(Hourly)</span>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control {{($errors->first('cpu_cost_per_hour') ? "border border-danger" : "")}}"
                                                        name="cpu_cost_per_hour"
                                                        value="{{ old('cpu_cost_per_hour') ? old('cpu_cost_per_hour') : $row->cpu_cost_per_hour }}"
                                                        placeholder="Enter cpu cost per hour">
                                                </div>
                                            </div>
                                        </div> --}}

                                        {{-- <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon5">GPU Cost(Hourly)</span>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control {{($errors->first('gpu_cost_per_hour') ? "border border-danger" : "")}}"
                                                        name="gpu_cost_per_hour"
                                                        value="{{ old('gpu_cost_per_hour') ? old('gpu_cost_per_hour') : $row->gpu_cost_per_hour }}"
                                                        placeholder="Enter gpu cost per hour">
                                                </div>
                                            </div>
                                        </div> --}}

                                    </div>

                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-check"></i> Save
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
