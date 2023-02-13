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
                                    <select id="inputState" class="form-select type-of-memory" name="type">
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
                    <table class="table table-bordered text-center cpu-table">
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
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="border p-2">
                        <h4 class="text-center"><b>GPU</b></h4>
                        <p class="text-center">Server Booking Time Table</p>
                    </div>
                    <table class="table table-bordered text-center gpu-table">
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-links')
<script>
$(document).ready(function() {
    //date picking
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

    function covertStringToTime(stringTime) {
        let date = new Date();
        let time = stringTime.match(/(\d+):(\d+) (\w+)/);
        date.setHours(parseInt(time[1]) + (time[3] == 'pm' ? 12 : 0));
        date.setMinutes(parseInt(time[2]));
        return date;
    }

    function nextMinute(dateData) {
        let nextMinute = new Date(dateData);
        nextMinute.setMinutes(nextMinute.getMinutes() + 1);
        return getTime(new Date(nextMinute.toString()));
    }
    function prevMinute(dateData) {
        let prevMinute = new Date(dateData);
        prevMinute.setMinutes(prevMinute.getMinutes() - 1);
        return getTime(new Date(prevMinute.toString()));
    }

    function nextTimeAfter5Min(dateData) {
        let after5Minute = new Date(dateData);
        after5Minute.setMinutes(after5Minute.getMinutes() + 5);
        return after5Minute.toString();
    }

    $('#calendar-body tr td').click(function() {
        let d = $(this).attr('data-date');
        let m = $(this).attr('data-month');
        let y = $(this).attr('data-year');
        $('#calendar-body tr td').removeClass('selected-date');
        $(this).addClass('selected-date');
        let picking_date = y + '-' + m + '-' + d;
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

                    // =====================CPU START=====================
                    var temp1 = '';
                    if (data['cpu_datas'].length > 0) {
                        data['cpu_datas'].forEach(element => {
                            temp1 += '<tr class="bg-danger text-white">' +
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
                                '<td>Booked</td>'+
                                '</tr>';
                        });

                    } else {
                        temp1 = '<tr>' +
                            '<td colspan="3" class="bg-success text-white">Full Day Free</td>' +
                            '</tr>';
                    }

                    $(".cpu-table > tbody").empty();
                    $('.cpu-table > tbody:last-child').append(temp1);

                    let regenarate_row = "";

                    let table = $(".cpu-table");
                    let rows = table.find("tr");
                    let row = '';
                    row = rows.eq(1);
                    let cells = row.find("td");
                    let cellLength = cells.length;
                    if (cellLength > 1){
                        cell = cells.eq(0);
                        let initialTime = covertStringToTime('00:00 am');
                        let After5Min = nextTimeAfter5Min(initialTime);
                        After5Min = covertStringToTime(After5Min);
                        let thisRowStartTime = covertStringToTime(cell.text());

                        let time1 = new Date(initialTime).getTime();
                        let time2 = new Date(thisRowStartTime).getTime();
                        let after5min = new Date(After5Min).getTime();

                        if (time1 < time2 && after5min < time2) {
                            regenarate_row += '<tr class="bg-success text-white">' +
                            '<td>' + nextMinute(initialTime) + '</td>' +
                            '<td>' + prevMinute(thisRowStartTime) + '</td>' +
                            '<td>Free</td>'+
                            '</tr>';
                        }
                    }

                    table = $(".cpu-table > tbody");
                    for (let i = 0; i < rows.length; i++) {
                        rows = table.find("tr");
                        row = rows.eq(i);
                        cells = row.find("td");
                        cellLength = cells.length
                        regenarate_row += rows[i].outerHTML;
                        if (cellLength > 1 && i < rows.length-1) {
                            cell = cells.eq(1);
                            let thisRowEndTime = covertStringToTime(cell.text());
                            let After5Min = nextTimeAfter5Min(thisRowEndTime);

                            row = rows.eq(i+1);
                            cells = row.find("td");
                            cell = cells.eq(0);
                            let nextRowStartTime = covertStringToTime(cell.text());

                            let time1 = new Date(thisRowEndTime).getTime();
                            let time2 = new Date(nextRowStartTime).getTime();
                            let after5min = new Date(After5Min).getTime();
                            if (time1 < time2 && after5min < time2) {
                                regenarate_row += '<tr class="bg-success text-white">' +
                                '<td>' + nextMinute(thisRowEndTime) + '</td>' +
                                '<td>' + prevMinute(nextRowStartTime) + '</td>' +
                                '<td>Free</td>'+
                                '</tr>';
                            }
                        }
                    }

                    table = $(".cpu-table");
                    rows = table.find("tr");
                    row = '';
                    row = rows.eq(rows.length-1);
                    cells = row.find("td");
                    cellLength = cells.length;
                    if (cellLength > 1){
                        cell = cells.eq(1);
                        let thisRowEndTime = covertStringToTime(cell.text());
                        let After5Min = nextTimeAfter5Min(thisRowEndTime);

                        let dayEndTime = covertStringToTime('12:00 pm');

                        let time1 = new Date(thisRowEndTime).getTime();
                        let time2 = new Date(dayEndTime).getTime();
                        let after5min = new Date(After5Min).getTime();
                        if (time1 < time2 && after5min < time2) {
                            regenarate_row += '<tr class="bg-success text-white">' +
                            '<td>' + nextMinute(thisRowEndTime) + '</td>' +
                            '<td>' + prevMinute(dayEndTime) + '</td>' +
                            '<td>Free</td>'+
                            '</tr>';
                        }
                    }

                    if (regenarate_row != '') {
                        $(".cpu-table > tbody").empty();
                        $('.cpu-table > tbody:last-child').append(regenarate_row);
                    }
                    // =====================CPU END=====================

                    // =====================GPU START===================
                    var temp2 = '';
                    if (data['gpu_datas'].length > 0) {
                        data['gpu_datas'].forEach(element => {
                            temp2 += '<tr class="bg-danger text-white">' +
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
                                '<td>Booked</td>'+
                                '</tr>';
                        });
                    } else {
                        temp2 = '<tr>' +
                            '<td colspan="3" class="bg-success text-white">Full Day Free</td>' +
                            '</tr>';
                    }
                    $(".gpu-table > tbody").empty();
                    $('.gpu-table > tbody:last-child').append(temp2);

                    let regenarate_row1 = "";

                    let table1 = $(".gpu-table");
                    let rows1 = table1.find("tr");
                    let row1 = '';
                    row1 = rows1.eq(1);
                    let cells1 = row1.find("td");
                    let cellLength1 = cells1.length;
                    if (cellLength1 > 1){
                        cell1 = cells1.eq(0);
                        let initialTime1 = covertStringToTime('00:00 am');
                        let After5Min1 = nextTimeAfter5Min(initialTime1);
                        After5Min1 = covertStringToTime(After5Min1);
                        let thisRowStartTime1 = covertStringToTime(cell1.text());

                        let time1 = new Date(initialTime1).getTime();
                        let time2 = new Date(thisRowStartTime1).getTime();
                        let after5min1 = new Date(After5Min1).getTime();

                        if (time1 < time2 && after5min1 < time2) {
                            regenarate_row1 += '<tr class="bg-success text-white">' +
                            '<td>' + nextMinute(initialTime1) + '</td>' +
                            '<td>' + prevMinute(thisRowStartTime1) + '</td>' +
                            '<td>Free</td>'+
                            '</tr>';
                        }
                    }

                    table1 = $(".gpu-table > tbody");
                    for (let i = 0; i < rows1.length; i++) {
                        rows1 = table1.find("tr");
                        row1 = rows1.eq(i);
                        cells1 = row1.find("td");
                        cellLength1 = cells1.length
                        regenarate_row1 += rows1[i].outerHTML;
                        if (cellLength1 > 1 && i < rows1.length-1) {
                            cell1 = cells1.eq(1);
                            let thisRowEndTime1 = covertStringToTime(cell1.text());
                            let After5Min1 = nextTimeAfter5Min(thisRowEndTime1);

                            row1 = rows1.eq(i+1);
                            cells1 = row1.find("td");
                            cell1 = cells1.eq(0);
                            let nextRowStartTime1 = covertStringToTime(cell1.text());

                            let time1 = new Date(thisRowEndTime1).getTime();
                            let time2 = new Date(nextRowStartTime1).getTime();
                            let after5min1 = new Date(After5Min1).getTime();
                            if (time1 < time2 && after5min1 < time2) {
                                regenarate_row1 += '<tr class="bg-success text-white">' +
                                '<td>' + nextMinute(thisRowEndTime1) + '</td>' +
                                '<td>' + prevMinute(nextRowStartTime1) + '</td>' +
                                '<td>Free</td>'+
                                '</tr>';
                            }
                        }
                    }

                    table1 = $(".gpu-table");
                    rows1 = table1.find("tr");
                    row1 = '';
                    row1 = rows1.eq(rows1.length-1);
                    cells1 = row1.find("td");
                    cellLength1 = cells1.length;
                    if (cellLength1 > 1){
                        cell1 = cells1.eq(1);
                        let thisRowEndTime1 = covertStringToTime(cell1.text());
                        let After5Min1 = nextTimeAfter5Min(thisRowEndTime1);

                        let dayEndTime1 = covertStringToTime('12:00 pm');

                        let time1 = new Date(thisRowEndTime1).getTime();
                        let time2 = new Date(dayEndTime1).getTime();
                        let after5min1 = new Date(After5Min1).getTime();
                        if (time1 < time2 && after5min1 < time2) {
                            regenarate_row1 += '<tr class="bg-success text-white">' +
                            '<td>' + nextMinute(thisRowEndTime1) + '</td>' +
                            '<td>' + prevMinute(dayEndTime1) + '</td>' +
                            '<td>Free</td>'+
                            '</tr>';
                        }
                    }

                    if (regenarate_row1 != '') {
                        $(".gpu-table > tbody").empty();
                        $('.gpu-table > tbody:last-child').append(regenarate_row1);
                    }

                    // =====================GPU END=====================
                }
            });
        }


    })

});
</script>


<script>
$(document).ready(function() {
    $('.dropdown-toggle').dropdown();

    $('.booking_start_date, .booking_end_date, .type-of-memory').change(function(){
        let booking_start_date = new Date(Date.parse($('.booking_start_date').val()));
        let booking_end_date = new Date(Date.parse($('.booking_end_date').val()));
        let type_of_memory = $('.type-of-memory').val();

        if ((booking_start_date != '') && (booking_end_date != '') && (type_of_memory != '')) {
            let difference = booking_end_date - booking_start_date;
            let differenceInMinute = difference / (1000 * 60);
            var msg = '';
            if (differenceInMinute <= 0) {
                msg = '<div class="alert alert-danger mb-0" role="alert">Your time picking is worng.</div>';
                $('.booking_cost').val('');
            }else if(differenceInMinute < 60){
                msg = '<div class="alert alert-danger mb-0" role="alert">You have to book minimun one hour.</div>';
                $('.booking_cost').val('');
            }else{
                msg = '';
                $('.alert-msg').empty();
                let cost_per_hour = 0;
                if (type_of_memory == 'CPU') {
                    cost_per_hour = "{{ $datas['CPU'] }}";
                }else{
                    cost_per_hour = "{{ $datas['GPU'] }}";
                }
                let total_cost = parseFloat((cost_per_hour/60)*differenceInMinute).toFixed(2);
                $('.booking_cost').val(total_cost);
            }
            $('.alert-msg').append(msg);
        }
    });
});
</script>
@endsection