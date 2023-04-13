@extends('admin.layouts.app')
@section('header-links')
<link href="{{ asset('all/admin/assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('all/admin/plugins/file-upload/file-upload-with-preview.min.css') }}" rel="stylesheet"
    type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('all/admin/plugins/dropify/dropify.min.css') }}">
<link href="{{ asset('all/admin/assets/css/users/account-setting.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('contents')

@if(Auth::check() && Auth::user()->role_id == 2)
@php
$url_group = 'admin';
@endphp
@endif

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing ">
                <div class="widget-content widget-content-area br-6">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="back-btn-container">

                        </div>
                        <div class="custom-heading-wrapper">
                            <h3 class="m-0 p-0 ">Profile Info</h3>
                            <div class="under-line-wrapper d-flex justify-content-around align-items-center">
                                <span class="left-line w-100"></span>
                                <span class="diamond"></span>
                                <span class="right-line w-100"></span>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route($url_group.'.profile.edit',Auth::guard('admin')->user()->id) }}"
                                class="btn btn-warning reload-btn">
                                <i class="fas fa-sync-alt reload-icon"></i> Reload
                            </a>

                        </div>
                    </div>

                    <form action="{{route($url_group.'.profile.update',Auth::guard('admin')->user()->id)}}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mt-4">
                            <div class="col-sm-12 col-lg-3 col-md-3">
                                <div class="upload pr-md-4" class="rounded-circle">
                                    <input type="hidden" name="old_img"
                                        value="{{Auth::guard('admin')->user()->avatar}}" />
                                    <input type="file" name="avatar" id="input-file-max-fs" class="dropify"
                                        data-default-file="{{ Auth::guard('admin')->user()->avatar ? asset('storage/'.Auth::guard('admin')->user()->avatar) : asset('img/profile.jpg') }}"
                                        data-max-file-size="2M" />
                                    <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> Upload Picture</p>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-9 col-lg-9">
                                <div class="mb-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon5">Name<span
                                                    class="text-danger">*</span></span>
                                        </div>
                                        <input type="text" class="form-control" name="name" placeholder="Enter name"
                                            aria-label="Username" value="{{ Auth::guard('admin')->user()->name }}">
                                    </div>
                                    @error('name')
                                    <small class="text-danger mb-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon5">Email<span
                                                    class="text-danger">*</span></span>
                                        </div>
                                        <input type="email" class="form-control" name="email" placeholder="Enter email"
                                            aria-label="Username" value="{{Auth::guard('admin')->user()->email }}">
                                    </div>
                                    @error('email')
                                    <small class="text-danger mb-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                    @enderror
                                </div>
                                {{-- <div class="mb-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon5">phone<span
                                                    class="text-danger">*</span></span>
                                        </div>
                                        <input type="text" class="form-control" name="phone" placeholder="Enter phone"
                                            aria-label="Username" value="{{Auth::guard('admin')->user()->phone}}">
                                    </div>
                                    @error('phone')
                                    <small class="text-danger mb-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                    @enderror
                                </div> --}}

                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary" name="submit" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="back-btn-container">
                        </div>
                        <div class="col-12 col-sm-12">
                            <h4 class="m-0 p-0 text-center">Change Password</h4>
                        </div>
                    </div>
                    <form action="{{ route($url_group.'.change.password', Auth::guard('admin')->user()->id) }}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mt-4">
                            <div class="col-sm-12 col-md-4 col-lg-4 mt-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon5">Old Pass<span
                                                class="text-danger">*</span></span>
                                    </div>
                                    <input type="password"
                                        class="form-control {{ ($errors->first('old_password') ? 'border border-danger' : '') }}"
                                        name="old_password" placeholder="old password" aria-label="Username">
                                </div>
                                @error('old_password')
                                <small class="text-danger mb-2" role="alert">
                                    <strong>{{ $message }}</strong>
                                </small>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4 mt-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon5">New Pass<span
                                                class="text-danger">*</span></span>
                                    </div>
                                    <input type="password"
                                        class="form-control {{ ($errors->first('password') ? 'border border-danger' : '') }}"
                                        name="password" placeholder="new password" aria-label="Username">
                                </div>
                                @error('password')
                                <small class="text-danger mb-2" role="alert">
                                    <strong>{{ $message }}</strong>
                                </small>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4 mt-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon5">Confirm Pass<span
                                                class="text-danger">*</span></span>
                                    </div>
                                    <input type="password"
                                        class="form-control {{ ($errors->first('password_confirmation') ? 'border border-danger' : '') }}"
                                        name="password_confirmation" placeholder="Confirm password"
                                        aria-label="Username">
                                </div>
                                @error('password_confirmation')
                                <small class="text-danger mb-2" role="alert">
                                    <strong>{{ $message }}</strong>
                                </small>
                                @enderror
                            </div>
                        </div>

                        <div class="text-right mt-4">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
