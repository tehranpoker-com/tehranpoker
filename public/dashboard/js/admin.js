(function($) {
    "use strict";
    $(document).on('click', '.buttons-options button' , function () {
        var options = $(this).parent(),
            input = options.find('input');
        options.find('button').removeClass('active');
        $(this).addClass('active');
        input.val($(this).attr("data-value"));
    });
    /*-------------------------------------------------------------------------------------------------*/
    $(".nav-tabs-cookie a").each(function() {
        var cookiename = $(this).parent().data('cookie');
        var cookietab = $(this).parent().data('cookie-tab');
        var id = $(this).attr('data-tab');
        if($.cookie(cookiename))
        {
            if ($.cookie(cookiename) == id) {
                $(this).addClass('active');
                $(id).addClass('active');
            } else {
                $(this).removeClass('active');
                $(id).removeClass('active');
            }

        }
        else
        {
            
        }
        
    });
    
    /*-------------------------------------------------------------------------------------------------*/
    $(".nav-tabs-cookie a").on('click', function() {
        var cookiename = $(this).parent().data('cookie');
        var id = $(this).attr('data-tab');
        $.cookie(cookiename, id);
    });

    $(document).on('change', '.ajax-homepage-widget-select' , function () {
        var trbox = $(this).parents('tr'), widget = $(this).data('widget'), option = $(this).find(':selected').data('option');
        trbox.addClass('loading');
        $.ajax({
            type: 'POST',
            url: admin_ajax_url,
            data: {action: 'options_widget_homepage',widget: widget, option: option},
            success: function (data) {
                if(data.status){
                    trbox.find('.box-widget-options').html(data.html);
                    trbox.find("select.select2").select2();
                }
                else {
                    trbox.find('.box-widget-options').html('');
                }
                trbox.removeClass('loading');
            }
        });
    });

})(jQuery);