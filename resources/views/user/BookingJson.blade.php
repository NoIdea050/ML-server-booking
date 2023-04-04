@extends('user.layouts.app')
@section('header-links')
<link href="{{ asset('all/admin/plugins/animate/animate.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('all/admin/assets/css/components/custom-modal.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('contents')
    <h1>Bookings JSON</h1>
    <p>Click the button below to view the JSON output of total bookings made for each user.</p>
    <a href="{{ route('user.BookingJson') }}" target="_blank" class="btn btn-primary">View JSON</a>
        
@endsection