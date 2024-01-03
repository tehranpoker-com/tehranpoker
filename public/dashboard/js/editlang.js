(function($) {
    "use strict";
    
    $('.edit-phrase').on('click', function(){
        var inputphrase = $(this).closest('tr.tr-box-phrase');
        inputphrase.find('.phrase-input').removeClass('d-none');
        inputphrase.find('.phrase-text').addClass('d-none');
    });

    $('.phrase-cancel').on('click', function(){
        var inputphrase = $(this).closest('tr.tr-box-phrase');
        inputphrase.find('.phrase-text').removeClass('d-none');
        inputphrase.find('.phrase-input').addClass('d-none');
    });

    $('.phrase-save').on('click', function(){
        var inputphrase = $(this).closest('tr.tr-box-phrase'),
            phrase = inputphrase.find('.input-phrase').val(),
            button = inputphrase.find('.phrase-save');
        $.ajax({
            type: 'POST',
            url: admin_ajax_url,
            data: {action: 'phrasesave', key: button.data('key'), code: button.data('code'), phrase: phrase },
            success: function (data) {
                inputphrase.find('.phrase-text').removeClass('d-none').html(phrase);
                inputphrase.find('.phrase-input').addClass('d-none');
            }
        });
        return false;
    });

})(jQuery);