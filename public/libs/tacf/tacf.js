(function ($) {
    "use strict";

    function fixWidthHelper(e, ui) {
        ui.children().each(function () {
            $(this).width($(this).width());
        });
        return ui;
    }

    function tacf_open_modal(title, data) {
        $('.tacf-modal-head h3').html(title);
        $('.tacf-modal-body').html(data);
        $('.tacf-overlay').show();
        $('#tacf-modal').show();
    }

    function tacf_close_modal() {
        $('.tacf-modal-head h3').html('');
        $('.tacf-modal-body').html('');
        $('.tacf-overlay').hide();
        $('#tacf-modal').hide();
    }

    $(document).on('click', '.tacf-box-tabs a', function () {
        var tabs = $(this).attr("data-tab");
        $(".tacf-box-tabs a").removeClass("active");
        $(".tacf-tab-content").removeClass("active");
        $(this).addClass("active");
        $(tabs).addClass("active");
        return false;
    });

    $('.tacf-ui-sortable').sortable({
        items: ".tacf-row",
        opacity: 1,
        revert: false,
        cursor: 'move',
        handle: '.ui-sortable-handle',
        helper: fixWidthHelper
    }).disableSelection();

    $('.tacf-boxs-sortable').sortable({
        items: ".tacf-row-sub",
        opacity: 1,
        revert: false,
        cursor: 'move',
        handle: '.ui-sortable-handle-sub',
        helper: fixWidthHelper
    }).disableSelection();    

    $(document).on('click', '.megapanel-icon-add' , function () {
        var $this = $(this),
        $title = $this.data('modal-title'),
        $input_search = $('.tacf-search-input'),
        $parent = $this.closest('.megapanel-icon-select');
        $('#tacf-modal').addClass($this.data('modal-size'));
        $.ajax({
            type: 'GET',
            url: admin_ajax_url,
            data: {action: 'megapanel_geticons'},
            success: function (data) {
                tacf_open_modal($title, data);

                $('.tacf-icon-selector').on('click', function () {
                    var seticon = $(this).data('seticon');
                    $parent.find('i').removeAttr('class').addClass(seticon);
                    $parent.find('input').val(seticon).trigger('change');
                    $parent.find('.megapanel-icon-preview').removeClass('hidden');
                    $parent.find('.megapanel-icon-remove').removeClass('hidden');
                    tacf_close_modal()
                });
                $input_search.keyup(function () {
                    var value = $(this).val(), $icons = $('.tacf-modal-body').find('.tacf-icon-selector');
                    $icons.each(function () {
                        var $ico = $(this);
                        if ($ico.data('seticon').search(new RegExp(value, 'i')) < 0) {
                            $ico.hide();
                        } else {
                            $ico.show();
                        }
                    });
                });
            }
        });
    });

    $(document).on('click', '.add-element-widget-boxs' , function () {
        var $this = $(this),
        $title = $this.data('modal-title'),
        $input_search = $('.tacf-search-input'),
        $parent = $this.parent().find('.megapanel-sortable-options');
        $('#tacf-modal').addClass($this.data('modal-size'));
        if(!$this.data('modal-search')){
            $('.tacf-modal-search').remove();
        }

        $('.tacf-boxs-sortable').sortable({
            items: ".tacf-row-sub",
            opacity: 1,
            revert: false,
            cursor: 'move',
            handle: '.ui-sortable-handle-sub',
            helper: fixWidthHelper
        }).disableSelection();
        
        $.ajax({
            type: 'POST',
            url: admin_ajax_url,
            data: {action: 'widget_get_boxs_element', option: $this.data('action'), opkey: $this.data('opkey'), opname: $this.data('opname')},
            success: function (data) {
                tacf_open_modal($title, data);
                $input_search.keyup(function () {
                    var value = $(this).val(), $search = $('.tacf-modal-body').find('.itme-search');
                    $search.each(function () {
                        var $search = $(this);
                        if ($search.data('search').search(new RegExp(value, 'i')) < 0) {
                            $search.hide();
                        } else {
                            $search.show();
                        }
                    });
                });
                $('.element-box-select').on('click', function () {
                    var $tacf_clone = $(this).find('.tacf-set-element').clone();
                    $parent.find('.ul-element-widget').append($tacf_clone)
                    $tacf_clone.removeClass('element-box-select').fadeIn();
                });
                return false;
            }
        });
        return false;
    });

    $(document).on('click', '.tacf-modal-close, .tacf-overlay' , function () {
        tacf_close_modal()
    });
    
    $(document).on('keyup', '.tacf_toggle_title', function () {
        $(this).parents('td').find('.tacf-title-item span').text($(this).val());
    });

    $(document).on('click', '.tacf-collapse-button', function () {
        var gettoggle = $(this);
        var getinput = $(this).parent().find('.tacf-toggle-input');
        var getbox = $(this).parent().parent().find('.tacf-toggle-content');
        getbox.toggleClass('d-none');
        var getvisible = getbox.is(':visible');
        if (getvisible) {
            gettoggle.find('i').addClass('fa-minus');
            gettoggle.find('i').removeClass('fa-plus');
            getinput.val('1');
        } else {
            gettoggle.find('i').addClass('fa-plus');
            gettoggle.find('i').removeClass('fa-minus');
            getinput.val('0');
        }
        return false;
    });

    $(document).on('click', '.tacf-button', function () {
        var tacf_box = $(this).parent().parent(),
            $tacf_clone = tacf_box.find('.tacf-clone').clone(),
            key = tacf_box.find('tr').length - 1;
        $tacf_clone.find('.tacf-input-key').each(function () {
            
            if ($(this).hasClass('tacf-input-uniqueid')) {
                $(this).val(Math.round(new Date().getTime() + (Math.random() * 100)));
            }
            
            $(this).attr('data-name', $(this).attr('data-name').replace('{key}', key));
            $(this).renameAttr('data-name', 'name');
            if ($(this).hasClass('articleeditor-content')) {
                ArticleEditor('.articleeditor-content');
            }

            if ($(this).hasClass('tacf-input-fileupload')) {
                $(this).attr('data-field', $(this).attr('data-field').replace('{key}', key));
            }

            if ($(this).hasClass('tacf-input-widget')) {
                $(this).attr('data-widget', $(this).attr('data-widget').replace('{key}', key));
                $(this).removeClass('tacf-input-widget');
            }

            $(this).removeClass('tacf-input-key');
        })
        $tacf_clone.removeClass('tacf-clone');
        if ($(this).hasClass('tacf-select')) {
            $tacf_clone.find("select.tacf-select2").select2();
        }
        tacf_box.find('.tacf-clone').before($tacf_clone).fadeIn();
        $tacf_clone.find('.tacf-input-fileupload').removeClass('tacf-input-fileupload').fileupload();
        if($('.tacf-input-colorpicker').length){
            $tacf_clone.find('.tacf-input-colorpicker').removeClass('tacf-input-colorpicker').spectrum({
                allowEmpty: false,
                showAlpha: false
            });
        }
        
        return false;
    });

    $(document).on('click', '.tacf-remove', function () {
        var tacf_tr = $(this).parent().parent();
        var title = tacf_tr.find('.tacf-title-item span').html();
        $(this).addClass('-confirm-delete-li');
        $('#confirmation-delete').find('.modal-body').html(delete_confirm_text+' # '+title);
        $('#confirmation-delete').modal('show');
        return false;
    });

    $(document).on('click', '#confirmation-delete button', function(){
        if ($(this).attr('value') == 'true') {  
            var tacf_tr = $('.-confirm-delete-li').parent().parent();
            tacf_tr.fadeOut().remove();
        }
        $('.-confirm-delete-li').removeClass('-confirm-delete-li')
    });

    $(document).on('click', '.tacf-remove-sub', function () {
        var tacf_tr = $(this).parent();
        tacf_tr.fadeOut().remove();
        return false;
    });

    $.fn.extend({
        renameAttr: function (name, newName, removeData) {
            var val;
            return this.each(function () {
                val = $.attr(this, name);
                $.attr(this, newName, val);
                $.removeAttr(this, name);
                if (removeData !== false) {
                    $.removeData(this, name.replace('data-', ''));
                }
            });
        }
    });

})(jQuery);
