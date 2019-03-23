$(document).ready(function () {

    var sidebar = $('.navbar');
    
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
            }
        }
    })    
});


