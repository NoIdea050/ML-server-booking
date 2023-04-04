@extends('admin.layouts.app')
@section('header-links')

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
                                <div class="col-sm-12 col-md-2">
                                    <a href="{{ route($url_group.'.user.credit-history', $user->id) }}"
                                        class="btn btn-warning refresh-btn" title="Add New">
                                        <i class="fa fa-arrow-left refresh-icon" style="font-size:16px;"></i></a>
                                </div>
                                <div class="col-10 col-sm-10 col-md-8 title-wrapper">
                                    <h3 class="text-center title">Add New Credit to {{ $user->name }}</h3>
                                </div>
                                <div class="col-1 col-sm-1 col-md-1 refresh-btn-wrapper">
                                    <a href="{{ route($url_group.'.user.credit-history.create', $user->id) }}"
                                        class="btn btn-primary refresh-btn" title="Add New">
                                        <i class="fa fa-plus refresh-icon" style="font-size:16px;"></i></a>
                                </div>
                            </div>
                            <hr>
                            <div class="row justify-content-center">
                                <div class="col-sm-12 col-md-8 py-4">
                                    <form action="{{ route($url_group.'.credit-history.store') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon5">Name</span>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control {{($errors->first('name') ? "border border-danger" : "")}}"
                                                            name="name" value="{{$user->name }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon5">Email</span>
                                                        </div>
                                                        <input type="email"
                                                            class="form-control {{($errors->first('email') ? "border border-danger" : "")}}"
                                                            name="email" value="{{$user->email }}" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon5">Date & Time</span>
                                                        </div>
                                                        <input type="datetime-local"
                                                            class="form-control {{($errors->first('date_and_time') ? "border border-danger" : "")}}"
                                                            name="date_and_time" value="{{ old('date_and_time') ? old('date_and_time') : date('Y-m-d\TH:i:s') }}">
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div class="col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon5">Credit</span>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control {{($errors->first('credit') ? "border border-danger" : "")}}"
                                                            name="credit" value="{{ old('credit') }}">
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div class="col-sm-12 col-md-12">
                                                <button class="btn btn-success w-100" type="submit">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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

@endsection