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
                                    <label for="inputState" class="form-label">Book: </label>
                                    <select id="inputState" class="form-select" name="type">
                                        <option value="" {{ old('type') == '' ? 'selected' : '' }}>Select...</option>
                                        <option value="CPU" {{ old('type') == 'CPU' ? 'selected' : '' }}>CPU</option>
                                        <option value="GPU" {{ old('type') == 'GPU' ? 'selected' : '' }}>GPU</option>
                                    </select>
                                    @error('type')
                                    <small class="text-danger mb-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                    @enderror
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
                    <table class="table table-bordered text-center cpu-table">
                        <thead>
                            <tr class="bg-danger text-light">
                                <th scope="col">Start Time</th>
                                <th scope="col">Finish Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2">Pick up a date</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="border p-2">
                        <h4 class="text-center"><b>GPU</b></h4>
                        <p class="text-center">Server Booking Time Table</p>
                    </div>
                    <table class="table table-bordered text-center gpu-table">
                        <thead>
                            <tr class="bg-danger text-light">
                                <th scope="col">Start Time</th>
                                <th scope="col">Finish Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2">Pick up a date</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>











Message Hasan Ahmed Noyon





@endsection

@section('footer-links')
<script>
$(document).ready(function() {
    //date pecking in checking seats
    $(".booking_start_date").change(function() {
        var booking_start_date = $(this).val();
        $('.booking_end_date').val('');
        console.log(booking_start_date);
        $('.booking_end_date').attr("min", booking_start_date);
    });

    //ajax setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function isSameDate(date1, date2) {
        // const today = new Date();
        const d1 = new Date(date1);
        const d2 = new Date(date2);
        if (d1.toDateString() === d2.toDateString()) {
            return true;
        }

        return false;
    }

    function getTime(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0' + minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;
        return strTime;
    }

    $('#calendar-body tr td').click(function() {
        let d = $(this).attr('data-date');
        let m = $(this).attr('data-month');
        let y = $(this).attr('data-year');
        $('#calendar-body tr td').removeClass('selected-date');
        $(this).addClass('selected-date');
        let picking_date = y + '-' + m + '-' + d;
        // console.log(picking_date);
        if ((typeof(d) != "undefined") && (typeof(m) != "undefined") && (typeof(
                    y) !=
                "undefined")) {
            $.ajax({
                url: "{{ route('user.booking-check') }}",
                type: "post", //send it through get method
                data: {
                    picking_date: picking_date
                },
                success: function(data) {
                    // console.log(data);

                    // =====================FOR CPU START=====================
                    var temp1 = '';
                    if (data['cpu_datas'].length > 0) {
                        data['cpu_datas'].forEach(element => {
                            temp1 += '<tr>' +
                                '<td>' + (isSameDate(element[
                                            'start_date_and_time'
                                        ],
                                        picking_date) ? getTime(
                                        new Date(
                                            element[
                                                'start_date_and_time'
                                            ])) :
                                    '12:01 AM') + '</td>' +
                                '<td>' + (isSameDate(element[
                                        'end_date_and_time'
                                    ], picking_date) ?
                                    getTime(new Date(element[
                                        'end_date_and_time'
                                    ])) : '11:59 PM') +
                                '</td>' +
                                '</tr>';
                        });
                    } else {
                        temp1 = '<tr>' +
                            '<td colspan="2" class="text-success">Full Day Free</td>' +
                            '</tr>';
                    }
                    $(".cpu-table > tbody").empty();
                    $('.cpu-table > tbody:last-child').append(temp1);
                    // =====================FOR CPU END=====================

                    // =====================FOR GPU START=====================
                    var temp2 = '';
                    if (data['gpu_datas'].length > 0) {
                        data['gpu_datas'].forEach(element => {
                            temp2 += '<tr>' +
                                '<td>' + (isSameDate(element[
                                            'start_date_and_time'
                                        ],
                                        picking_date) ? getTime(
                                        new Date(
                                            element[
                                                'start_date_and_time'
                                            ])) :
                                    '12:01 AM') + '</td>' +
                                '<td>' + (isSameDate(element[
                                        'end_date_and_time'
                                    ], picking_date) ?
                                    getTime(new Date(element[
                                        'end_date_and_time'
                                    ])) : '11:59 PM') +
                                '</td>' +
                                '</tr>';
                        });
                    } else {
                        temp2 = '<tr>' +
                            '<td colspan="2" class="text-success">Full Day Free</td>' +
                            '</tr>';
                    }
                    $(".gpu-table > tbody").empty();
                    $('.gpu-table > tbody:last-child').append(temp2);
                    // =====================FOR GPU END=====================
                }
            });
        }


    })

});
</script>


<script>
$(document).ready(function() {
    $('.dropdown-toggle').dropdown()
});
</script>
@endsection