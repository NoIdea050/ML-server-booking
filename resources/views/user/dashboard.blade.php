@extends('user.layouts.app')
@section('header-links')
@endsection

@section('contents')

<div class="container my-3 d-flex justify-content-end">
    <div class="row">
        <div class="col-12 ">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Create
                Booking
            </button>
            <!-- The Modal -->
            <div class="modal" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Booking Form</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <!--Booking Form Start-->
                            <form action="{{ route('user.booking') }}" method="POST" class="row g-3">
                                @csrf
                                <div class="col-md-12">
                                    <label for="inputState" class="form-label">Book For</label>
                                    <input id="inputState" class="form-control" name="name"
                                        value="{{ Auth::user()->name }}" readonly>
                                    @error('name')
                                    <small class="text-danger mb-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="startDateTime">Start Date & Time : </label>
                                    <input type="datetime-local" class="form-control booking_start_date"
                                        id="startDateTime" name="start_date_and_time" min="{{ date('Y-m-d h:i') }}"
                                        value="{{ old('start_date_and_time') }}">
                                    @error('start_date_and_time')
                                    <small class="text-danger mb-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="endDateTime">End Date & Time : </label>
                                    <input type="datetime-local" class="form-control booking_end_date" id="endDateTime"
                                        name="end_date_and_time" min="{{ date('Y-m-d h:i') }}"
                                        value="{{ old('end_date_and_time') }}">
                                    @error('end_date_and_time')
                                    <small class="text-danger mb-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="inputState" class="form-label">Storage: </label>
                                    <select id="inputState" class="form-select select-memory" name="storage">
                                        <option value="" {{ old('storage') == '' ? 'selected' : '' }}>Select One</option>
                                        @foreach ($storages as $storage)
                                            <option 
                                                value="{{ $storage->id }}" 
                                                {{ old('storage') == '$storage->id' ? 'selected' : '' }}
                                                data-cost_per_hour = {{ $storage->cost_per_hour }}
                                                >{{ $storage->title }} &nbsp; (Type:{{ $storage->type }})</option>
                                        @endforeach
                                    </select>
                                    @error('storage')
                                    <small class="text-danger mb-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                    @enderror
                                </div>
                                <div class="col-12 alert-msg">

                                </div>
                                <div class="col-12">
                                    <label for="exampleFormControlTextarea1" class="form-label">Booking Cost</label>
                                    <input class="form-control booking_cost" name="credit_cost"
                                        placeholder="Pick up stat & end date time first." readonly>
                                </div>
                                <div class="col-12">
                                    <label for="exampleFormControlTextarea1" class="form-label">Notes</label>
                                    <textarea class="form-control" name="note" id="exampleFormControlTextarea1"
                                        rows="3">{{ old('note') }}</textarea>
                                </div>
                                <div class="col-12">
                                    <label for="exampleFormControlInput1" class="form-label">Email address</label>
                                    <input type="email" class="form-control" name="email" id="exampleFormControlInput1"
                                        value="{{ Auth::user()->email }}" readonly>
                                    @error('email')
                                    <small class="text-danger mb-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success w-100">Book</button>
                                </div>
                            </form>
                            <!--Booking Form End-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    @if(Session::has('success'))
    <div class="alert alert-success text-center" role="alert">
        {{ session('success') }}
    </div>
    @endif
    @if(Session::has('error'))
    <div class="alert alert-danger text-center" role="alert">
        {{ session('error') }}
    </div>
    @endif
    <div class="row d-flex align-items-start">
        <div class="col-12">
            <div class="container-calendar">
                <h3 id="monthAndYear"></h3>
                <div class="button-container-calendar">
                    <button id="previous" onclick="previous()">&#8249;</button>
                    <div class="footer-container-calendar">
                        <label for="month">Jump To: </label>
                        <select id="month" onchange="jump()">
                            <option value=0>Jan</option>
                            <option value=1>Feb</option>
                            <option value=2>Mar</option>
                            <option value=3>Apr</option>
                            <option value=4>May</option>
                            <option value=5>Jun</option>
                            <option value=6>Jul</option>
                            <option value=7>Aug</option>
                            <option value=8>Sep</option>
                            <option value=9>Oct</option>
                            <option value=10>Nov</option>
                            <option value=11>Dec</option>
                        </select>
                        <select id="year" onchange="jump()"></select>
                    </div>
                    <button id="next" onclick="next()">&#8250;</button>
                </div>
                <table class="table-calendar" id="calendar" data-lang="en">
                    <thead id="thead-month"></thead>
                    <tbody id="calendar-body"></tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="border p-2">
                        <h4 class="text-center"><b>CPU</b></h4>
                        <p class="text-center">Server Booking Time Table</p>
                    </div>
                    @foreach ($storages as $storage)
                        @if ($storage->type == 'GPU')
                            @continue;
                        @endif    
                        <table class="table table-bordered text-center storage-table storage-table-{{ $storage->id }} cpu-table-{{ $storage->id }} mb-3">
                            <thead>
                                <tr class="bg-primary text-light">
                                    <th scope="col" colspan="3">{{ $storage->title }}</th>
                                </tr>
                            </thead>
                            <thead>
                                <tr class="bg-secondary text-light">
                                    <th scope="col">Start Time</th>
                                    <th scope="col">Finish Time</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="3">Pick up a date</td>
                                </tr>
                            </tbody>
                        </table>
                    @endforeach
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="border p-2">
                        <h4 class="text-center"><b>GPU</b></h4>
                        <p class="text-center">Server Booking Time Table</p>
                    </div>
                    @foreach ($storages as $storage)
                        @if ($storage->type == 'CPU')
                            @continue;
                        @endif
                        <table class="table table-bordered text-center storage-table storage-table-{{ $storage->id }} gpu-table-{{ $storage->id }} mb-3">
                            <thead>
                                <tr class="bg-primary text-light">
                                    <th scope="col" colspan="3">{{ $storage->title }}</th>
                                </tr>
                            </thead>
                            <thead>
                                <tr class="bg-secondary text-light">
                                    <th scope="col">Start Time</th>
                                    <th scope="col">Finish Time</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="3">Pick up a date</td>
                                </tr>
                            </tbody>
                        </table>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-links')

@include('user.js.calendar-date-select-js')

@include('user.js.create-booking-js')

@endsection