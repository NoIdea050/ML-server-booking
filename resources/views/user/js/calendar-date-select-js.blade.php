<script>
    $(document).ready(function() {
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
            var ampm = hours > 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0' + minutes : minutes;
            var strTime = hours + ':' + minutes + ' ' + ampm;
            return strTime;
        }

        function covertStringToTime(stringTime) {
            let date = new Date();
            let time = stringTime.match(/(\d+):(\d+) (\w+)/);
            date.setHours(parseInt(time[1]) + (time[3] == 'PM' ? 12 : 0));
            date.setMinutes(parseInt(time[2]));
            return date;
        }

        function nextMinute(dateData) {
            // console.log(dateData);
            let nextMinute = new Date(dateData);
            nextMinute.setMinutes(nextMinute.getMinutes() + 1);
            // console.log(nextMinute.toString());
            return getTime(new Date(nextMinute.toString()));
        }
        function prevMinute(dateData) {
            let prevMinute = new Date(dateData);
            prevMinute.setMinutes(prevMinute.getMinutes() - 1);
            // console.log(prevMinute.toString());
            return getTime(new Date(prevMinute.toString()));
        }

        function nextTimeAfter5Min(dateData) {
            let after5Minute = new Date(dateData);
            after5Minute.setMinutes(after5Minute.getMinutes() + 5);
            // console.log(after5Minute.toString());
            return after5Minute.toString();
            // return getTime(new Date(after5Minute.toString()));
        }

        // $('#calendar-body tr td').click(function() {
        $(document.body).on("click","#calendar-body tr td",function(){
            let d = $(this).attr('data-date');
            let m = $(this).attr('data-month');
            let y = $(this).attr('data-year');
            // alert("click");
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
                        temp1 = '<tr>' +
                                '<td colspan="3" class="bg-success text-white">Full Day Free</td>' +
                                '</tr>';
                        // $('.storage-table > tbody');
                        $(".storage-table > tbody").empty();
                        $('.storage-table > tbody:last-child').append(temp1);
                        if (data != 'No Data Found') {
                            // var table = new Array("{{ count($storages) }}");
                            const tableObj = {};
                            // var table_len = table.length;
                            // for (let index = 0; index < table_len; index++) {
                            //     table[index] = 'h';
                            // }
                            // console.log(tableObj);
                            data.forEach(element => {
                                // console.log(table[element['id']-1]);
                                if (tableObj[element['storage_id']] === undefined || tableObj[element['storage_id']] === null) {
                                    tableObj[element['storage_id']] = '';
                                }
                                tableObj[element['storage_id']] += '<tr class="bg-danger text-white">' +
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

                                $(".storage-table-"+element['storage_id']+" > tbody").empty();
                                $(".storage-table-"+element['storage_id']+" > tbody:last-child").append(tableObj[element['storage_id']]);
                            });


                            // ===Regenerate Start===
                            var tableObjLength = Object.keys(tableObj).length;
                            // console.log("Length of obj :" + tableObjLength);
                            for (let index = 0; index < tableObjLength; index++) {
                                // console.log(index);
                                let regenarate_row = "";

                                let table = $(".storage-table-"+Object.keys(tableObj)[index]+" > tbody");
                                let rows = table.find("tr");
                                let row = '';
                                row = rows.eq(0);
                                let cells = row.find("td");
                                let cellLength = cells.length;
                                // console.log(cellLength);
                                if (cellLength > 1){
                                    // console.log('Yes');
                                    cell = cells.eq(0);
                                    let initialTime = covertStringToTime('12:01 AM');
                                    let After5Min = nextTimeAfter5Min(initialTime);
                                    After5Min = covertStringToTime(After5Min);
                                    let thisRowStartTime = covertStringToTime(cell.text());

                                    let time1 = new Date(initialTime).getTime();
                                    let time2 = new Date(thisRowStartTime).getTime();
                                    let after5min = new Date(After5Min).getTime();
                                    // console.log(initialTime +"---"+ thisRowStartTime +"---"+ After5Min +"---"+ thisRowStartTime)
                                    // if (time1 < time2) {
                                    if (time1 < time2 && after5min < time2) {
                                        regenarate_row += '<tr class="bg-success text-white">' +
                                        '<td>' + prevMinute(initialTime) + '</td>' +
                                        '<td>' + prevMinute(thisRowStartTime) + '</td>' +
                                        '<td>Free</td>'+
                                        '</tr>';
                                    }
                                }

                                table = $(".storage-table-"+Object.keys(tableObj)[index]+" > tbody");
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

                                        // let date1 = "Mon Feb 06 2023 02:26:14 GMT+0600 (Bangladesh Standard Time)";
                                        // let date2 = "Mon Feb 06 2023 02:30:00 GMT+0600 (Bangladesh Standard Time)";
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

                                table = $(".storage-table-"+Object.keys(tableObj)[index]);
                                rows = table.find("tr");
                                row = '';
                                row = rows.eq(rows.length-1);
                                cells = row.find("td");
                                cellLength = cells.length;
                                if (cellLength > 1){
                                    // console.log("here-2");
                                    cell = cells.eq(1);
                                    let thisRowEndTime = covertStringToTime(cell.text());
                                    let After5Min = nextTimeAfter5Min(thisRowEndTime);

                                    let dayEndTime = covertStringToTime('11:59 PM');

                                    let time1 = new Date(thisRowEndTime).getTime();
                                    let time2 = new Date(dayEndTime).getTime();
                                    let after5min = new Date(After5Min).getTime();
                                    // console.log(thisRowEndTime +"---"+ dayEndTime +"---"+ After5Min +"---"+ dayEndTime)
                                    if (time1 < time2 && after5min < time2) {
                                        regenarate_row += '<tr class="bg-success text-white">' +
                                        '<td>' + nextMinute(thisRowEndTime) + '</td>' +
                                        '<td>' + nextMinute(dayEndTime) + '</td>' +
                                        '<td>Free</td>'+
                                        '</tr>';
                                    }
                                }

                                if (regenarate_row != '') {
                                    $(".storage-table-"+Object.keys(tableObj)[index]+" > tbody").empty();
                                    $(".storage-table-"+Object.keys(tableObj)[index]+" > tbody:last-child").append(regenarate_row);
                                }  
                            }
                            // ===Regenerate Stop===
                            // console.log(tableObj[1]);

                            // tableObj.clear();
                            
                        }
                    }
                });
            }


        })

    });
</script>