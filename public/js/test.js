$(document).ready(function () {
    $('.brand-logo').show();
    $('.brand-logo-mini').hide();
    var sidebar = $('#sidebar');


    sidebar.on('click', '.dropdown-collapse', function () {
        sidebar.find('.collapse.show').collapse('hide');
    });

    $('#sidebarCollapse').on('click', function () {
        
        if ($('#sidebar').hasClass('active')) {
            $('.link_hide').show();
            $('.brand-logo').show();
            $('.brand-logo-mini').hide();
            $('.nav-profile-hide').show();
        } else {
            $('.link_hide').hide();
            $('.brand-logo').hide();
            $('.brand-logo-mini').show();      
            $('.nav-profile-hide').hide();
        }
        //sidebar.find('.dropdown-collapse').removeClass('dropdown-hover'); 
        $('.sub').toggleClass('submenu_active');
        $('#sidebar').toggleClass('active');
        $('#content').toggleClass('active');
    });
});