$(document).ready(function() {
    Webcam.set({
        width: 320,
        height: 240,
        image_format: 'jpeg',
        jpeg_quality: 90
    });

    $('#accesscamera').on('click', function() {
        Webcam.reset();
        Webcam.on('error', function() {
            $('#photoModal').modal('hide');
            swal({
                title: 'Warning',
                text: 'Please give permission to access your webcam',
                icon: 'warning'
            });
        });
        Webcam.attach('#my_camera');
    });

    $('#takephoto').on('click', take_snapshot);

    $('#retakephoto').on('click', function() {
        $('#my_camera').addClass('d-block');
        $('#my_camera').removeClass('d-none');

        $('#results').addClass('d-none');

        $('#takephoto').addClass('d-block');
        $('#takephoto').removeClass('d-none');

        $('#retakephoto').addClass('d-none');
        $('#retakephoto').removeClass('d-block');

        $('#uploadphoto').addClass('d-none');
        $('#uploadphoto').removeClass('d-block');
    });

    $('#uploadphoto').on('click', function() {
        var img = $('#photoStore').val();
        alert(img);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/quick-booking/upload',
            type: "post", //send it through get method
            data:{img:img},
            success: function(data) {
                alert(data)
                document.getElementById('image_method').value = 'webcam';
                document.getElementById('cam_img_name').value = data;
            }
        })
    })



    $('#accesscamera1').on('click', function() {
        Webcam.reset();
        Webcam.on('error', function() {
            $('#photoModal').modal('hide');
            swal({
                title: 'Warning',
                text: 'Please give permission to access your webcam',
                icon: 'warning'
            });
        });
        Webcam.attach('#my_camera1');
    });
    $('#takephoto1').on('click', take_snapshot1);
    $('#retakephoto1').on('click', function() {
        $('#my_camera1').addClass('d-block');
        $('#my_camera1').removeClass('d-none');

        $('#results1').addClass('d-none');

        $('#takephoto1').addClass('d-block');
        $('#takephoto1').removeClass('d-none');

        $('#retakephoto1').addClass('d-none');
        $('#retakephoto1').removeClass('d-block');

        $('#uploadphoto1').addClass('d-none');
        $('#uploadphoto1').removeClass('d-block');
    });
    $('#uploadphoto1').on('click', function() {
        var img = $('#photoStore1').val();
        alert(img);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/quick-booking/upload',
            type: "post", //send it through get method
            data:{img:img},
            success: function(data) {
                // alert(data)
                document.getElementById('guardian_image_method').value = 'webcam';
                document.getElementById('guardian_cam_img_name').value = data;
            }
        })
    })



    $('#accesscamera2').on('click', function() {
        alert("accesscamera2")
        Webcam.reset();
        Webcam.on('error', function() {
            $('#photoModal').modal('hide');
            swal({
                title: 'Warning',
                text: 'Please give permission to access your webcam',
                icon: 'warning'
            });
        });
        Webcam.attach('#my_camera2');
    });
    $('#takephoto2').on('click', take_snapshot2);
    $('#retakephoto2').on('click', function() {
        $('#my_camera2').addClass('d-block');
        $('#my_camera2').removeClass('d-none');

        $('#results2').addClass('d-none');

        $('#takephoto2').addClass('d-block');
        $('#takephoto2').removeClass('d-none');

        $('#retakephoto2').addClass('d-none');
        $('#retakephoto2').removeClass('d-block');

        $('#uploadphoto2').addClass('d-none');
        $('#uploadphoto2').removeClass('d-block');
    });
    $('#uploadphoto2').on('click', function() {
        var img = $('#photoStore2').val();
        alert(img);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/quick-booking/upload',
            type: "post", //send it through get method
            data:{img:img},
            success: function(data) {
                alert(data)
                document.getElementById('local_guardian_image_method').value = 'webcam';
                document.getElementById('local_guardian_cam_img_name').value = data;
            }
        })
    })
})

function take_snapshot()
{
    //take snapshot and get image data
    Webcam.snap(function(data_uri) {
        //display result image
        $('#results').html('<img src="' + data_uri + '" class="d-block mx-auto rounded"/>');

        //display image in main place
        var preview = document.getElementById("preview");
        var previewImg = document.createElement("img");
        previewImg.setAttribute("src", data_uri);
        preview.innerHTML = "";
        preview.appendChild(previewImg);

        var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
        $('#photoStore').val(raw_image_data);
    });

    $('#my_camera').removeClass('d-block');
    $('#my_camera').addClass('d-none');

    $('#results').removeClass('d-none');

    $('#takephoto').removeClass('d-block');
    $('#takephoto').addClass('d-none');

    $('#retakephoto').removeClass('d-none');
    $('#retakephoto').addClass('d-block');

    $('#uploadphoto').removeClass('d-none');
    $('#uploadphoto').addClass('d-block');
}

function take_snapshot1()
{
    //take snapshot and get image data
    Webcam.snap(function(data_uri) {
        //display result image
        $('#results1').html('<img src="' + data_uri + '" class="d-block mx-auto rounded"/>');

        //display image in main place
        var preview1 = document.getElementById("preview1");
        var previewImg1 = document.createElement("img");
        previewImg1.setAttribute("src", data_uri);
        preview1.innerHTML = "";
        preview1.appendChild(previewImg1);

        var raw_image_data1 = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
        $('#photoStore1').val(raw_image_data1);
    });

    $('#my_camera1').removeClass('d-block');
    $('#my_camera1').addClass('d-none');

    $('#results1').removeClass('d-none');

    $('#takephoto1').removeClass('d-block');
    $('#takephoto1').addClass('d-none');

    $('#retakephoto1').removeClass('d-none');
    $('#retakephoto1').addClass('d-block');

    $('#uploadphoto1').removeClass('d-none');
    $('#uploadphoto1').addClass('d-block');
}

function take_snapshot2()
{
    //take snapshot and get image data
    Webcam.snap(function(data_uri) {
        //display result image
        $('#results2').html('<img src="' + data_uri + '" class="d-block mx-auto rounded"/>');

        //display image in main place
        var preview2 = document.getElementById("preview2");
        var previewImg2 = document.createElement("img");
        previewImg2.setAttribute("src", data_uri);
        preview2.innerHTML = "";
        preview2.appendChild(previewImg2);

        var raw_image_data2 = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
        $('#photoStore2').val(raw_image_data2);
    });

    $('#my_camera2').removeClass('d-block');
    $('#my_camera2').addClass('d-none');

    $('#results2').removeClass('d-none');

    $('#takephoto2').removeClass('d-block');
    $('#takephoto2').addClass('d-none');

    $('#retakephoto2').removeClass('d-none');
    $('#retakephoto2').addClass('d-block');

    $('#uploadphoto2').removeClass('d-none');
    $('#uploadphoto2').addClass('d-block');
}