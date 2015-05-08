jQuery(document).ready( function ($) {

	$('.chch-put-template-acivate').on('click', function(e){
		e.preventDefault();
		var template = $(this).attr('data-template');
		var base = $(this).attr('data-base');

		$('#poststuff .theme-browser .theme.active').removeClass('active');
		var theme = $(this).closest('.theme');
		theme.addClass('active');

		$('#_chch_put_template').val(template);
		$('#_chch_put_template_base').val(base);
		$('#publish').trigger('click');
	});

	$('.cc-pu-customize-close').on('click', function(e){
		e.preventDefault();
		var template = $(this).attr('data-template');
		$('body').css('overflow', 'visible');
		$('#cc-pu-customize-form-'+template).hide();
	});

	$('.chch-put-template-edit').on('click', function(e){
		e.preventDefault();
		var thisEl = $(this);
		template = thisEl.attr('data-template');
		nounce = thisEl.attr('data-nounce');

		$frame = $("#cc-pu-customize-preview-" + template);
		$frame.attr('src', userSettings.url + "?cc-cs-customize=1");

		theme = thisEl.closest('.theme');
		previewWrapper = $('#cc-pu-customize-form-'+template);

		$('.theme').removeClass('active');
		theme.addClass('active');

		$('#_chch_put_template').val(template);

		previewWrapper.find('.revealer-wrapper .cc-pu-customize-style').addClass('disable-option');
		previewWrapper.find('.revealer-wrapper.cc-pu-option-active .cc-pu-customize-style').removeClass('disable-option');
		previewWrapper.find('.cc-pu-customize-style').not('.disable-option').trigger('change');

		previewWrapper.show();

		$('body').css('overflow', 'hidden');

	});

	/////////////
	//LIVE PREVIEW
	/////////////

	$( ".accordion-section-title" ).on('click', function(e){
		var el = $(this);
		var target = el.next('.accordion-section-content');
		if(!$(this).hasClass('open')){
			$( ".accordion-section-title").removeClass('open');
			el.addClass('open');
			target.slideDown('fast');
		}
		else
		{
			el.removeClass('open');
			target.slideUp('fast');
		}
	});

	 $( '.cc-pu-colorpicker' ).wpColorPicker({
		change: _.throttle(function() {
			var el = $(this);
			var template = el.attr('data-template');
			var target = el.attr('data-customize-target');
			var styleAttr = el.attr('data-attr');
			var elValue = el.val();
			if(target === '#thank-you' && styleAttr === 'background-color') {
				$('#cc-pu-customize-preview-'+template).contents().find(target).css(styleAttr,elValue);
				$('#cc-pu-customize-preview-'+template).contents().find(target).find('.triangle').css('border-color',elValue);
			} else {
				$('#cc-pu-customize-preview-'+template).contents().find(target).css(styleAttr,elValue);
			}
		})
	 });

	$('.cc-pu-customize-style').on('change', function(e){
		var el = $(this);

		var elId = el.attr('id');
		var elType = el.attr('type');
		var template = el.attr('data-template');
		var target = el.attr('data-customize-target');
		var styleAttr = el.attr('data-attr');
		var elValue = el.val();
		var elUnit = el.attr('data-unit');

		if(typeof elUnit === "undefined"){
			elUnit = '';
		}

		if(styleAttr == 'background-image'){
			$('#cc-pu-customize-preview-'+template).contents().find(target).css('background-image','url('+elValue+')');

			var n = elId.search("_image");
			if(n > 0) {
				$('#cc-pu-customize-preview-'+template).contents().find(target).css('background-size','cover');
			}
		}
		else if(styleAttr == 'href' || styleAttr == 'src') {
			$('#cc-pu-customize-preview-'+template).contents().find(target).attr(styleAttr,elValue);
		}
		else {
			$('#cc-pu-customize-preview-'+template).contents().find(target).css(styleAttr,elValue+elUnit);
		}

	});

	$('.cc-pu-customize-content').on('keyup', function(e){
		var el = $(this);
		var template = el.attr('data-template');
		var target = el.attr('data-customize-target');
		var elAttr = el.attr('data-attr');
		var elValue = el.val();

		if(typeof elAttr === "undefined"){
			$('#cc-pu-customize-preview-'+template).contents().find(target).text(elValue);
		}
		else {
			$('#cc-pu-customize-preview-'+template).contents().find(target).attr(elAttr,elValue);
		}
	});


	$('.revealer').on('change', function(){
		var el = $(this);
		var target = el.attr('data-customize-target');

		if(el.hasClass('active')){
			$('#'+target).slideUp('fast');
			el.removeClass('active');
		}
		else
		{
			$('#'+target).slideDown('fast');
			el.addClass('active');
		}
	});

	$('.revealer-group').on('change', function(){
		var el = $(this);
		var template = el.attr('data-template');
		var eltarget = el.attr('data-customize-target');
		var elAttr = el.attr('data-attr');

		var group = el.attr('data-group');
		var thisOption = el.find(":selected");
		var target = thisOption.val();

		$('#cc-pu-customize-preview-'+template+' '+eltarget).css('background-size','auto');
		if(target == 'no') {
			$('#cc-pu-customize-preview-'+template+' '+eltarget).css(elAttr ,'url()');

		}

		$('#cc-pu-customize-form-'+template+' .'+group).slideUp();
		$('#cc-pu-customize-form-'+template+' #'+target).slideDown();
		$('#cc-pu-customize-form-'+template+' #'+target).find('.cc-pu-customize-style').trigger('change');

		if(group === 'content-logo_type-group') {
			$('#cc-pu-customize-preview-'+template).contents().find('.logo-text, .logo-image').hide();
			$('#cc-pu-customize-preview-'+template).contents().find('.logo-' + target).show();

			if(target === 'text') {
				$('select[name="CcComingSoonAdminOptions[text_logo][font]"]').trigger('change');
			}
		}
	});
	$('.revealer-group').trigger('change');


	$('.remover-checkbox').on('change', function(){
		var target = $(this).attr('data-customize-target');

		if($(this).is(':checked')){
			$(target).hide();
		} else {
			$(target).show();
		}
	});

	$('.cc-pu-fonts').on('change', function(){
		var el = $(this);
		template = el.attr('data-template');
		target = el.attr('data-customize-target');
		styleAttr = el.attr('data-attr');

		thisOption = el.find(":selected");

		elValue = thisOption.val();
		linkID = elValue.replace(/\+/g, '-');

		if(!$('#'+linkID).length) {
			$('#cc-pu-customize-preview-'+template).contents().find('head').append('<link rel="stylesheet" id="'+linkID+'"  href="//fonts.googleapis.com/css?family=' + elValue +'" type="text/css" media="all" />');
		}

		elValue = elValue.replace(/\+/g, ' ');

		setTimeout(
			function(elValue, template,target) {
				return function() {
					$('#cc-pu-customize-preview-'+template).contents().find(target).css(styleAttr,"\""+elValue+"\"");
				};
			}(elValue, template,target)
		, 2000);
	});

	$('.chch-repeater-add').on('click', function(e){
		e.preventDefault();
		el = $(this);
		wrapper = el.closest('.chch-repeater-wrapper');

		wrapper.find('.chch-repeater-field:first-child').clone(true).appendTo(wrapper).find('input').val('').focus();
	});

	/////////////
	//WP UPLOADER
	/////////////
	$('.cc-pu-image-upload').click(function(e) {

		e.preventDefault();

		var $t = $('#'+$(this).data('target'));

		if($t.data('media')) {
			$t.data('media').open();
			return;
		} else {
			$t.data('media', wp.media({
				title: 'Choose Image',
				button: {
					text: 'Choose Image'
				},
				multiple: false
			}));

			var media = $t.data('media');

			media.on('select', function() {
				var attachment = media.state().get('selection').first().toJSON();
				$t.val(attachment.url).trigger('change');
			});

			media.open();
		}

	});
	$('#_chch_pop_up_time_auto_closed').trigger('change');
});
