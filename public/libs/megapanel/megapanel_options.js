jQuery(document).ready(function() {

 
    jQuery(document).on('change', '.tahb-animate-effect' , function () {
        var box_animate = $(this).parent().parent(),
            effect      = box_animate.find('.tahb-animate-effect').find(":selected").val(),
            param       = box_animate.find('.tahb-animate-options-param'),
            preview     = box_animate.find('.tahb-animate-preview');

        preview.removeClass().addClass('tahb-animate-preview animated '+effect).css("animation-duration", '');
    });

    var cookiename = jQuery('.nav-tabs-cookie').attr('data-cookie');
    if(!cookiename){
        cookiename = 'cookieptions';
    }
    /*-------------------------------------------------------------------------------------------------*/
    jQuery(".megapanel-tabs a").on('click', function() {
        var tabs = jQuery(this).attr("data-tab");
        jQuery(".megapanel-tabs a").removeClass("active");
        jQuery(".megapanel-tab-content").removeClass("active");
        jQuery(this).addClass("active");
        jQuery(tabs).addClass("active");
        return false;
    });
    /*-------------------------------------------------------------------------------------------------*/
    jQuery(document).on('click', '.set-status-button' , function () {
        if($(this).hasClass('status-off'))
        {
            $(this).removeClass('status-off').addClass('status-on');
            $(this).parent().find('.boxs-status').val('1');
        }
        else
        {
            $(this).removeClass('status-on').addClass('status-off');
            $(this).parent().find('.boxs-status').val('0');
        }
    });
    /*-------------------------------------------------------------------------------------------------*/
    jQuery(document).on('click', '.megapanel-buttons-options button' , function () {
        var options = jQuery(this).parent(),
            input = options.find('input');
        options.find('button').removeClass('active');
        jQuery(this).addClass('active');
        input.val(jQuery(this).attr("data-value"));
    });
    /*-------------------------------------------------------------------------------------------------*/
    jQuery(document).on('click', '.megapanel-buttons-colors button' , function () {
        var options = jQuery(this).parent(),
            input = options.find('input');
        options.find('button').removeClass('active');
        jQuery(this).addClass('active');
        input.val(jQuery(this).attr("data-color"));
        input.spectrum({allowEmpty: false,showAlpha: false, color: jQuery(this).attr("data-color")});
    });
    /*-------------------------------------------------------------------------------------------------*/
    jQuery(document).on('click', '.megapanel-buttons-checkbox button' , function () {
        jQuery(this).toggleClass('active');
        var cid = jQuery(this).attr("data-id");
        if(jQuery(cid).is(':checked'))
        {
            jQuery(cid).removeAttr('checked');
        }
        else
        {
             jQuery(cid).attr('checked', 'checked');
        }
    });
    /*-------------------------------------------------------------------------------------------------*/
    jQuery('.megapanel-list-sortable').sortable({
        opacity: 0.8,
        revert: true,
        cursor: 'move',
        handle: '.hndle',
        placeholder: {
            element: function(currentItem) {
                return jQuery("<li style='border: 1px dashed #ccc;height: 36px;background: #fffdea;'>&nbsp;</li>")[0];
            },
            update: function(container, p) {
                return;
            }
        }
    });
    /*-------------------------------------------------------------------------------------------------*/
    jQuery(document).on('click', '.megapanel-section-help-title' , function () {
        var gettoggle   = jQuery(this);
        var getinput    = jQuery(this).find('.megapanel_toggle');
        jQuery(this).parent().find('.megapanel-controls-help-container').toggle();
    });
    /*-------------------------------------------------------------------------------------------------*/
    jQuery(document).on('click', '.megapanel-toggle' , function () {
        var gettoggle   = jQuery(this);
        var getinput    = jQuery(this).parent().find('.megapanel_toggle');
        jQuery(this).parent().parent().parent().find('.megapanel_inner_box').toggle('fast',function(){
            var getvisible = jQuery(this).is(':visible');
            if (getvisible)
            {
                 gettoggle.addClass('dashicons-arrow-up'); 
                 gettoggle.removeClass('dashicons-arrow-down');
                 getinput.val('1');
            }
            else
            {
                 gettoggle.addClass('dashicons-arrow-down'); 
                 gettoggle.removeClass('dashicons-arrow-up');
                 getinput.val('0');
            }
        });
    });
    /*-------------------------------------------------------------------------------------------------*/
    jQuery(document).on('click', '.megapanel-options-head-items h3 .collapse-button' , function () {
        var gettoggle   = jQuery(this);
        var getinput    = jQuery(this).parent().find('.megapanel_toggle');
        jQuery(this).parent().parent().find('.megapanel-toggle-content').toggle('fast',function(){
            var getvisible = jQuery(this).is(':visible');
            if (getvisible)
            {
                 gettoggle.find('i').addClass('fa-minus'); 
                 gettoggle.find('i').removeClass('fa-plus');
                 getinput.val('1');
            }
            else
            {
                 gettoggle.find('i').addClass('fa-plus'); 
                 gettoggle.find('i').removeClass('fa-minus');
                 getinput.val('0');
            }
        });
    });
    /*-------------------------------------------------------------------------------------------------*/
    jQuery(document).on('keyup', '.megapanel_version' , function () {
        jQuery(this).parents('li').find('.megapanel-title-item').html(jQuery(this).val());
    });
    /*-------------------------------------------------------------------------------------------------*/
    jQuery(document).on('click', '.remove-megapanel-button' , function () {
        jQuery(this).parents('li').addClass('megapanel-removered').fadeOut(function() {
			jQuery(this).remove();
		});
    });
    /*-------------------------------------------------------------------------------------------------*/
    jQuery(document).on('click', '#megapanel_add_criteria_item' , function (event) {
		event.preventDefault(event);
        megapanel_itemscount++;
        var template = jQuery('#megapanel_tmpl_criteria_item'),data = {data: megapanel_itemscount, title: 'type version'};
		var compile = template.tmpl(data).html();
		jQuery('#megapanel-reviews-list').append(compile);
	});
    /*-------------------------------------------------------------------------------------------------*/
    jQuery(document).on('click', '.megapanel-icon-default' , function () {
        var $this   = jQuery(this),
            $parent = $this.closest('.megapanel-icon-select');
        var icon = jQuery(this).data('geticon');
        $parent.find('i').removeAttr('class').addClass(icon);
        $parent.find('input').val(icon).trigger('change');
        return false;
    });
    /*-------------------------------------------------------------------------------------------------*/
    jQuery(document).on('click', '.megapanel-icon-remove' , function () {
        var $this   = jQuery(this),
            $parent = $this.closest('.megapanel-icon-select');
        $parent.find('i').removeAttr('class');
        $parent.find('input').val('').trigger('change');
        return false;
    });

    
});