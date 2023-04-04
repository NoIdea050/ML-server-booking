@extends('user.layouts.app')
@section('header-links')
<link href="{{ asset('all/admin/plugins/animate/animate.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('all/admin/assets/css/components/custom-modal.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('contents')

<div class="container d-flex justify-content-end">
    <div class="row">
        <div class="col-12 ">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                Request For Credit
            </button>
            <!-- The Modal -->
            <div class="modal" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Request For Extra Credit</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <!--Booking Form Start-->
                            <form action="{{ route('user.request-for-credit') }}" method="POST" class="row g-3">
                                @csrf
                                <div class="col-md-12">
                                    <label for="inputState" class="form-label">Amount of Credit<span class="text-danger">*</span></label>
                                    <input type="text" id="inputState" class="form-control" name="credit"
                                        value="{{ old('credit') }}"
                                        placeholder="Enter Amount of Credit">
                                    @error('credit')
                                    <small class="text-danger mb-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="inputState" class="form-label">Message(optional)</label>
                                    <textarea class="form-control" name="message" id="" 
                                        placeholder="Enter Your Message">{{ old('message') }}</textarea>
                                    @error('message')
                                    <small class="text-danger mb-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-success w-100">Request</button>
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
<div class="container my-3 d-flex justify-content-end">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <h5 class="text-center mb-3 text-uppercase"><b>CREDIT MANAGEMENT</b></h5>

        <table class="table">
            <thead>
                <tr class="text-center">
                    <th scope="col">#</th>
                    <th scope="col">Total Credit Gain</th>
                    <th scope="col">Total Credit Left</th>
                    <th scope="col">Last Credit Added</th>
                </tr>
            </thead>
            <tbody>
                @foreach($credits as $data)
                <tr class="text-center">
                    <th scope="row">{{ ++$loop->index }}</th>
                    <td>{{$data->total_credit_gain}}</td>
                    <td>{{$data->total_credit_left}}</td>
                    <td>{{$data->last_credit_added}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="container my-3 d-flex justify-content-end">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <h5 class="text-center mb-3 text-uppercase"><b>CREDIT HISTORY</b></h5>

        <table class="table">
            <thead>
                <tr class="text-center">
                    <th scope="col">#</th>
                    <th scope="col">Info</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($credit_histories as $data)
                <tr class="text-center">
                    <th scope="row">{{ ++$loop->index }}</th>
                    <td>
                        @if ($data->requested_date_and_time)
                            <div><b>Requested Date & Time: </b>{{ date('d M, Y', strtotime($data->requested_date_and_time)) }} | {{ date('h:i a', strtotime($data->requested_date_and_time)) }}</div>
                        @endif
                        @if ($data->status == 1)
                            <div><b>{{ $data->requested_date_and_time ? 'Accepted' : 'Given' }} Date & Time: </b>{{ date('d M, Y', strtotime($data->date_and_time)) }} | {{ date('h:i a', strtotime($data->date_and_time)) }}</div>
                        @endif
                    </td>
                    <td>{{$data->credit}}</td>
                    <td>
                        @if ($data->status == 1)
                            <span class="text-success">{{ $data->requested_date_and_time ? 'Accepted' : 'Given' }}</span>
                        @elseif($data->status == 0)
                            <span class="text-primary">Requested</span>
                        @else
                            <span class="text-danger">Rejected</span>
                        @endif
                    </td>
                    <td>
                        @if ($data->status == 0 || $data->status == 2)
                            <a class="btn btn-danger py-1 px-2" 
                                href="{{ route('user.request-for-credit-delete', $data->id) }}">Delete</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="container">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <h5 class="text-center text-uppercase mb-3"><b>Booking History</b></h5>
        <table class="table">
            <thead>
                <tr class="text-center">
                    <th scope="col">#</th>
                    <th scope="col">Start Date & Time</th>
                    <th scope="col">End Date & Time</th>
                    <th scope="col">Storage</th>
                    <th scope="col">Credit Used</th>
                    <th scope="col">Status</th>
                    {{-- <th scope="col">Action</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr class="text-center">
                    <th scope="row">{{ ++$loop->index }}</th>
                    <td>{{ date('d M, Y | h:i a', strtotime($data->start_date_and_time)) }}</td>
                    <td>{{ date('d M, Y | h:i a', strtotime($data->end_date_and_time)) }}</td>
                    <td>
                        @if ($data->storage_info)
                            {{ $data->storage_info->title }} <b>(Type: {{ $data->storage_info->type }})</b>
                        @endif
                        
                    </td>
                    <td>{{$data->credit_cost}}</td>
                    <td>
                        @if($data->status == 0)
                        <span class="text-warning">Pending</span>
                        @elseif($data->status == 1)
                        <span class="text-success">Accepted</span>
                        @else
                        <span class="text-danger">Rejected</span>
                        @endif
                    </td>
                    <td>
                        @if($data->status == 0)
                        <button type="button" class="btn btn-warning m-0 p-0 px-1">
                            <a class=" fa fa-trash text-white" href="" data-toggle="modal"
                                data-target="#zoomupModal-{{ $data->id }}"></a>
                        </button>
                        @endif
                    </td>

                    <div id="zoomupModal-{{ $data->id }}" class="modal animated zoomInUp custo-zoomInUp" role="dialog">
                        <form action="{{route('user.booking-destroy',$data->id)}}" method="POST">
                            @method('POST')
                            @csrf
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-x">
                                                <line x1="18" y1="6" x2="6" y2="18">
                                                </line>
                                                <line x1="6" y1="6" x2="18" y2="18">
                                                </line>
                                            </svg>
                                        </button>
                                        <div class="d-flex flex-column justify-content-between align-items-center">
                                            <i class="far fa-question-circle fa-10x text-warning"></i>
                                            <h4 class="modal-title">Are you
                                                sure?
                                            </h4>
                                        </div>
                                        <p class="modal-text text-center mt-3">
                                            Do
                                            you really want to delete this?</p>

                                        <div class="mt-3 d-flex justify-content-center">
                                            <button class="btn btn-light mr-2" data-dismiss="modal"><i
                                                    class="fas fa-times"></i>
                                                No</button>
                                            <button class="btn btn-danger ml-2"><i class="fas fa-check"></i>Yes
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </tr>
                @endforeach
            </tbody>
        </table>
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


});
</script>
<script>
$(document).ready(function() {
    $('.dropdown-toggle').dropdown()
});
</script>
@endsection