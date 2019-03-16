$(document).ready(function () {
    $("#header_xl").css('margin-top',$("#navbar_fixed").css('height'));
    $("#header_sm").css('margin-top',$("#navbar_fixed").css('height'));

    $(".nav_login").click(function() {
        $("#model_body_login").modal('show');
        // $("#model_background_register").hide();
        // var model_width = $("#model_body_login").css('width').replace('%','');
        // var body_width = $(window).width();
        // var model_width_px = body_width * (model_width / 100);
        // $("#model_body_login").css('left', (body_width / 2) - (model_width_px / 2) + "px");
        // $("#model_background_login").show();
        // $("#navbar_fixed").removeClass('fixed-top');   
    });



    // $("#nav_register").click(function() {
    //     $("#model_body_register").modal('show');
    //     // $("#model_background_login").hide();
    //     // var model_width = $("#model_body_register").css('width').replace('%','');
    //     // var body_width = $(window).width();
    //     // var model_width_px = body_width * (model_width / 100);
    //     // $("#model_body_register").css('left', (body_width / 2) - (model_width_px / 2) + "px");
    //     // $("#model_background_register").show();
    //     // $("#navbar_fixed").removeClass('fixed-top');   
    // });

    $("#btn_close_login").click(function() {
        $("#model_background_login").hide();
        $("#navbar_fixed").addClass('fixed-top');
    });

    // $("#btn_close_register").click(function() {
    //     $("#model_background_register").hide();
    //     $("#navbar_fixed").addClass('fixed-top');
    // });

    $("#model_background_login").click(function () {
        $("#model_background_login").hide();
        $("#navbar_fixed").addClass('fixed-top');
    });

    $("#model_body_login").click(function (e) {
        e.stopPropagation();
    });

    // $("#model_background_register").click(function () {
    //     $("#model_background_register").hide();
    //     $("#navbar_fixed").addClass('fixed-top');
    // });

    // $("#model_body_register").click(function (e) {
    //     e.stopPropagation();
    // });

    AOS.init();

    $("a#about").click(function () {
        $('html, body').animate({
            scrollTop: $(".content-wrapper").offset().top -25
        }, 800, function () {


        });
    });

    $('#btn_submit_login').click(function () {
        event.preventDefault();
        $.ajax({
            url: END_POINT_WED + "/Auth/Login",
            method: "POST",
            dataType: "json",
            data: {
                username: $("#email_login").val(),
                password: $("#pwd_login").val()
            },
            success: (res) => {
                console.log(res);
                setCookie("token", res.token);
                setCookie("socket_token", res.socket_token);
                window.location = res.path;
            },
            error: (res) => {

                if (res.status === 400) {
                    $(".alert ").show();
                    $(".alert ").html(`<strong>Error!</strong> ${res.responseJSON.error.message}`);
                }
            }
        });
    })

    $("input,button").focus(function () {
        $(".alert").hide();
    });
});
