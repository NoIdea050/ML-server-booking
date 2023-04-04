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
                                    <a href="{{ route($url_group.'.storage.index') }}"
                                        class="btn btn-primary refresh-btn" title="Refresh">
                                        <i class="fa fa-arrow-left refresh-icon" style="font-size:16px;"></i></a>
                                </div>
                                <div class="col-10 col-sm-10 col-md-8 title-wrapper">
                                    <h3 class="text-center title">Storage List</h3>
                                </div>
                                <div class="col-1 col-sm-1 col-md-1 refresh-btn-wrapper">
                                    <a href="{{ route($url_group.'.storage.create') }}"
                                        class="btn btn-warning refresh-btn" title="Refresh">
                                        <i class="fa fa-refresh refresh-icon" style="font-size:16px;"></i></a>
                                </div>
                            </div>
                            <hr>


                            <div class="row justify-content-center">
                                <div class="col-sm-12 col-md-8 py-4">
                                    <form action="{{ route($url_group.'.storage.update', $data->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon5">Title</span>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control {{($errors->first('title') ? "border border-danger" : "")}}"
                                                            name="title" value="{{ $data->title }}" placeholder="Enter Storage Title(Ex: CPU/GPU)">
                                                    </div>
                                                </div>
                                            </div>
                                            

                                            <div class="col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon5">Type</span>
                                                        </div>
                                                        <select class="form-control {{($errors->first('type') ? "border border-danger" : "")}}"
                                                                name="type" id="">
                                                            <option value="">Select One</option>
                                                            <option value="CPU" {{ $data->type == 'CPU' ? 'selected' : '' }}>CPU</option>
                                                            <option value="GPU" {{ $data->type == 'GPU' ? 'selected' : '' }}>GPU</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon5">Credit Cost(Per Hour)</span>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control {{($errors->first('cost_per_hour') ? "border border-danger" : "")}}"
                                                            name="cost_per_hour" value="{{ $data->cost_per_hour }}" placeholder="Enter Credit Cost(Per Hour)">
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
