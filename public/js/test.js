$(document).ready(function () {
  $("#sidebar").mCustomScrollbar({
    theme: "minimal-dark"
  });
    $('.brand-logo').show();
    $('.brand-logo-mini').hide();
    var sidebar = $('#sidebar');

    //Add active class to nav-link based on url dynamically
    //Active class can be hard coded directly in html file also as required
    var current = location.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g, '');
    $('ul li a', sidebar).each(function () {
        var $this = $(this);
        if (current === "") {
            //for root url
            if ($this.attr('href').indexOf("index") !== -1) {
                $(this).parents('.nav-item').last().addClass('active');
                if ($(this).parents('.sub-menu').length) {
                    $(this).closest('.collapse').addClass('show');
                    $(this).addClass('active');
                }
            }
        } else {
            //for other url
            if ($this.attr('href').indexOf(current) !== -1) {
                $(this).parents('.nav-item').last().addClass('active');
                if ($(this).parents('.sub-menu').length) {
                    $(this).closest('.collapse').addClass('show');
                    $(this).addClass('active');
                }
            }
        }
    })

    sidebar.on('click', '.dropdown-collapse', function () {
        sidebar.find('.collapse.show').collapse('hide');
    });

    $('#sidebarCollapse').on('click', function () {

        if ($('#sidebar').hasClass('active')) {
            $('.link_hide').show();
            $('.brand-logo').show();
            $('.brand-logo-mini').hide();
            $('.nav-profile-hide').show();
            $("#sidebar").mCustomScrollbar({
              theme: "minimal-dark"
            });
            
        } else {
            $('.link_hide').hide();
            $('.brand-logo').hide();
            $('.brand-logo-mini').show();
            $('.nav-profile-hide').hide();
            $("#sidebar").mCustomScrollbar('destroy');

        }
        //sidebar.find('.dropdown-collapse').removeClass('dropdown-hover'); 
        $('.sub').toggleClass('submenu_active');
        $('#sidebar').toggleClass('active');
        $('#content').toggleClass('active');
    });
});
