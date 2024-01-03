

;(function(root, factory) {
	if (typeof define === 'function' && define.amd) {
	  define(['jquery'], factory);
	} else if (typeof exports === 'object') {
	  module.exports = factory(require('jquery'));
	} else {
	  root.FileUpload = factory(root.jQuery);
	}
}(this, function($) {
	var pluginName = "fileupload";
	/**
	 * Upload plugin
	 *
	 * @param {Object} element
	 * @param {Array} options
	 */
	function FileUpload(element, options) {
		var defaults = {
			field: '',
			type: 'image',
			tab: 'library',
			content: false,
			src: true,
			srcid: false,
			image: '',
			size: 'thumbnail',
			button: '',
			titletb: 'media upload',
			messages: {
				'iconupload': '<i class="bx bx-cloud-upload"></i>',
				'iconchanges': '<i class="bx bxs-image-add"></i>',
				'iconremove':  '<i class="bx bx-minus"></i>',
				'icondefault':   'Default',
				'upload': 'upload',
				'changes': 'changes',
				'remove':  'Remove',
				'default': 'Default'
			},
			tpl: {
				wrap:           '<div class="uploadfile-wrapper"><div class="input-group"></div></div>',
				prependgroup:	'<div class="input-group-prepend"><span  class="button-{{ field }} btn btn-secondary" title="{{ upload }}">{{ iconupload }} {{ button }}</span></div>',
				preview:        '<div class="preview-{{ field }} preview"></div>',
				removeButton:   '<span class="remove-{{ field }} btn btn-danger" title="{{ remove }}">{{ iconremove }}</span>',
			}
		};

		

		this.isInit     	= false;
		this.element  		= element;
		this.input  		= $(this.element);
		this.settings   	= $.extend(true, defaults, options, this.input.data());
		this.clearElement  	= this.clearElement.bind(this);
		this.media_upload  	= this.media_upload.bind(this);
		this.media_remove  	= this.media_remove.bind(this);
		this.media_change  	= this.media_change.bind(this);

		this.translateMessages();
		this.translateVar();
		this.createElements();

		var elementclass = {
			preview: '.preview-'+this.settings.field,
			remove: '.remove-'+this.settings.field,
			buttonupload: '.button-'+this.settings.field
		}

		this.elementclass  	= elementclass; 

		if(this.input.val() != ''){
			$(this.elementclass.remove).show();
			if(this.input.val() && this.settings.type == 'image'){
				if(this.settings.srcid){
					$(this.elementclass.preview).html('<img src="'+this.settings.srcid+'" />');
				}
				else {
					$(this.elementclass.preview).html('<img src="'+this.input.val()+'" />');
				}
				
			}
		}
		else {
			if(this.elementclass.remove.length){
				$(this.elementclass.remove).hide();
			}
			
		}


		this.buttonupload = $(this.elementclass.buttonupload);
		this.buttonremove = $(this.elementclass.remove);

		this.buttonupload.on('click', this.media_upload);
		this.input.on('change', this.media_change);
		this.buttonremove.on('click', this.media_remove);
		return false;
	}

	FileUpload.prototype.media_remove = function() {
		this.input.val('');
		$(this.elementclass.remove).hide();
		if(this.settings.image && this.settings.type == 'image'){
			$(this.elementclass.preview).html('<img src="'+this.settings.image+'" />');
		}
		else if(this.settings.type == 'audio'){
			$('.upload-'+this.settings.field+'-player-audio').hide();
		}
		else {
			$(this.elementclass.preview).html('').hide();
		}
		return false;
	}

	FileUpload.prototype.media_change = function() {
		if(this.input.val()){
			$(this.elementclass.remove).show();
			if(this.settings.type == 'image'){
				$(this.elementclass.preview).show().html('<img src="'+this.input.val()+'" />');
			}
			else if(this.settings.type == 'audio'){
				$('.upload-'+this.settings.field+'-player-audio').show();
				var file = this.input.val();
				var extension = file.substr( (file.lastIndexOf('.') +1) );
				playSong(this.input.val(), extension);
			}
			else {
				$(this.elementclass.preview).html('').hide();
			}
		}
		else {
			$(this.elementclass.remove).hide();
			if(this.settings.image && this.settings.type == 'image'){
				$(this.elementclass.preview).show().html('<img src="'+this.settings.image+'" />');
			}
			else {
				$(this.elementclass.preview).html('').hide();
			}
		}
		return false;
	}

	FileUpload.prototype.media_upload = function() {
		var tbwidth 	= $(window).width() - 160, 
			tbheight 	= $(window).height() - 100;

		this.input.val('');
		$(this.elementclass.remove).hide();
		$(this.elementclass.preview).html('').hide();

		if (this.settings.type == 'gallery'){
			window.restore_send_to_gallery = window.send_to_gallery;
		} else {
			window.restore_send_to_editor  = window.send_to_editor;
		}

		tb_show(this.settings.titletb, media_upload_url+'?type='+this.settings.type+'&tab='+this.settings.tab+'&TB_iframe=true&height='+tbheight+'&width='+tbwidth+'');
		if(this.settings.content){
			//media_upload_send_content();
		} else {
			if (this.settings.type == 'gallery'){
				this.media_upload_send_gallery(this.settings.field);
			} else {
				this.media_upload_send_image(this.settings.field, this.settings.src, this.settings.size, this.settings.defult);
			}
		}

		return false;
		
	};

	FileUpload.prototype.media_upload_send_image = function(field, src, size, defult) {
		var settings = this.settings;
		var elementclass = this.elementclass;
		var input = this.input;
		window.send_to_editor = function(data) {
			tb_remove();
			if(size == 'full'){
				var filesrc = data['file'];
			}
			else {
				var filesrc = data['thumbnail'];
			}

			if(src){
				input.val(filesrc);
			} else {
				input.val(data['fileid']);
			}

			$(elementclass.remove).show();
			$(elementclass.preview).show();

			if(settings.type == 'image'){
				$(elementclass.preview).html('<img src="'+filesrc+'" />');
			}
			else if(data['filetype'] == 'audio'){
				$('.upload-'+field+'-player-audio').show();
				playSong(data['file'], data['mimes']);
			}
			else if(data['filetype'] == 'video'){

			}

			window.send_to_editor = window.restore_send_to_editor;
		}
	};

	FileUpload.prototype.media_upload_send_gallery = function(field) {
		var settings = this.settings;
		var input = this.input;
		window.send_to_gallery = function(html) {
			/*
			imgurl = $('input',html).attr('value');
			tb_remove();
			if(typeof imgurl == 'undefined'){
				imgurl = $(html).attr('value');
			}
			$('.cmp-input-'+field).val(imgurl);
			$('.cmp-'+field+'-gallery').show().attr("title","Gallery ids="+imgurl);
			$('.cmp-'+field+'-button').hide();
			*/
			window.send_to_gallery = window.restore_send_to_gallery;
		}
	};

	FileUpload.prototype.clearElement = function(){
		
	};

	FileUpload.prototype.isTouchDevice = function(){
		return (('ontouchstart' in window) ||
				(navigator.MaxTouchPoints > 0) ||
				(navigator.msMaxTouchPoints > 0));
	};
	
	FileUpload.prototype.translateMessages = function(){
		for (var name in this.settings.tpl) {
			for (var key in this.settings.messages) {
				this.settings.tpl[name] = this.settings.tpl[name].replace('{{ ' + key + ' }}', this.settings.messages[key]);
			}
		}
	};

	FileUpload.prototype.translateVar = function(){
		for (var name in this.settings.tpl) {
			for (var key in this.settings) {
				this.settings.tpl[name] = this.settings.tpl[name].replace('{{ ' + key + ' }}', this.settings[key]);
			}
		}
	};

	FileUpload.prototype.createElements = function()
	{
		this.isInit = true;
		
		this.input.wrap($(this.settings.tpl.wrap));
		this.wrapper = this.input.parent();

		this.prependgroup = $(this.settings.tpl.prependgroup);
		this.prependgroup.insertAfter(this.input);


		this.removeButton = $(this.settings.tpl.removeButton);
		this.removeButton.prependTo(this.prependgroup);

		this.preview = $(this.settings.tpl.preview);
		this.preview.insertAfter(this.wrapper);

		if(this.settings.image){
			this.preview.html('<img src="'+this.settings.image+'" />');
		}

		if (this.isTouchDevice() === true) {
			this.wrapper.addClass('touch-fallback');
		}

		if (this.input.attr('disabled')) {
			this.isDisabled = true;
			this.wrapper.addClass('disabled');
		}

		if (this.isDisabled === false && this.settings.showRemove === true) {
			this.clearButton = $(this.settings.tpl.clearButton);
			this.clearButton.insertAfter(this.input);
			this.clearButton.on('click', this.clearElement);
		}

		this.filenameWrapper = $(this.settings.tpl.filename);

	};

	FileUpload.prototype.init = function(){
		this.createElements();
	};


	$.fn[pluginName] = function(options) {
		this.each(function() {
			if (!$.data(this, pluginName)) {
				$.data(this, pluginName, new FileUpload(this, options));
			}
		});
		return this;
	};

	return FileUpload;
}));



(function($) {
    "use strict";
	$('.input-file-upload').fileupload();
	$('[data-toggle="fileupload"]').fileupload();
})(jQuery);
