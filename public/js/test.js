$(document).ready(function () {
    $("#sidebar").mCustomScrollbar({
        theme: "minimal-dark"
    });
    // $('.brand-logo').show();
    // $('.brand-logo-mini').hide();
    var sidebar = $('#sidebar');

    //Add active class to nav-link based on url dynamically
    //Active class can be hard coded directly in html file also as required
    //location.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g, '');
    var current = location.href;
    $('ul li a', sidebar).each(function () {
        var $this = $(this);
        if (current === "") {
            //for root url
            if ($this.attr('href').indexOf("index") !== -1) {
                $(this).parents('.nav-item').last().addClass('active');
                if ($(this).parents('.sub').length) {
                    $(this).closest('.collapse').addClass('show');
                    $(this).addClass('active');
                }
            }
        } else {
            //for other url
            if ($this.attr('href') ===  current) {
                $(this).parents('.nav-item').last().addClass('active');
                if ($(this).parents('.sub').length) {
                    $(this).closest('.collapse').addClass('show');
                    $(this).parents('.nav-item').children(".dropdown-toggle").attr('aria-expanded', 'true');
                    $(this).parents('.nav-item').addClass('active');
                }
            }
        }
    })

    sidebar.on('click', '.dropdown-collapse', function () {
        sidebar.find('.collapse.show').collapse('hide');
    });

    $('#sidebarCollapse').on('click', function () {
        sidebar.find('.collapse.show').collapse('hide');
        if ($('#sidebar').hasClass('active')) {
            $('.nav-profile-hide').show();
            $("#sidebar").mCustomScrollbar({
                theme: "minimal-dark"
            });

        } else {
            $('.nav-profile-hide').hide();
            $("#sidebar").mCustomScrollbar('destroy');

        }

        $('body').toggleClass('sidebar-icon-only');
        $('#sidebar').toggleClass('active');
        $('#content').toggleClass('active');
    });

    
});


