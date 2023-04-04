<script>
    $(document).ready(function() {

        //date pecking in checking seats
        $(".booking_start_date").change(function() {
            var booking_start_date = $(this).val();
            $('.booking_end_date').val('');
            console.log(booking_start_date);
            $('.booking_end_date').attr("min", booking_start_date);
        });
        
        $('.dropdown-toggle').dropdown();

        $("body").on('change', '.booking_start_date, .booking_end_date, .select-memory', function() {
            let booking_start_date = new Date(Date.parse($('.booking_start_date').val()));
            let booking_end_date = new Date(Date.parse($('.booking_end_date').val()));
            let selected_memory = $('.select-memory').find(":selected").val();
            // console.log(booking_start_date + '----' + booking_end_date + '----' + selected_memory)

            if ((booking_start_date != '') && (booking_start_date != 'Invalid Date') && 
                (booking_end_date != '') && (booking_end_date != 'Invalid Date') && 
                (selected_memory != '')) {

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
                    let cost_per_hour = $('.select-memory').find(":selected").attr('data-cost_per_hour');
                    if (cost_per_hour == 'undefined') {
                        cost_per_hour = 0;
                    }
                    // alert(cost_per_hour);
                    let total_cost = parseFloat((cost_per_hour/60)*differenceInMinute).toFixed(2);
                    $('.booking_cost').val(total_cost);
                }
                $('.alert-msg').append(msg);
            }else{
                $('.booking_cost').val('');
            }
        });
    });
</script>