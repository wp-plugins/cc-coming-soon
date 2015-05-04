
jQuery(document).ready(function($) { 

    tinymce.PluginManager.add('keyup_event', function(editor) { 
		
	   editor.onKeyUp.add(function(){
			var editorId = editor.id;
            var get_ed_content = tinymce.activeEditor.getContent(); 
            do_stuff_here(editorId,get_ed_content);
		});
		
		editor.onChange.add(function(){
			var editorId = editor.id;
            var get_ed_content = tinymce.activeEditor.getContent(); 
            do_stuff_here(editorId,get_ed_content);
		});
		 
    }); 

    
    function do_stuff_here(id,content) {
		var target = id.split('-');
		var text = $(content).html();
		
		if(typeof text === "undefined"){
			text='';
		}

		switch(target[0])
		{
			case 'header_text':
				$('#cc-pu-customize-preview-'+target[1]).contents().find('.main main h1').html(text);
			break;
			
			case 'message_text':
				$('#cc-pu-customize-preview-'+target[1]).contents().find('.message-text').html(content);
			break;	
			
			case 'footer_note':
				$('#cc-pu-customize-preview-'+target[1]).contents().find('.footer-note').html(content);
			break; 
		} 
    }
});