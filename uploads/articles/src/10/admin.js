
jQuery(document).ready(function() {
	if ($('body').hasClass('admin')) {
		if ($('body').hasClass('article')) {
			//Initialize tagit.
			$('#tags').tagit({
				availableTags:($('#auto_complete').length > 0) ? $('#auto_complete').val().split(',') : '',
				autocomplete: {delay: 0, minLength: 2},
				allowSpaces:false,
				caseSensitive:false,
				placeholderText:'search tags',
				fieldName:'tags[]',
				afterTagAdded:function(event, tag) {
					// Once a tag is added remove the placeholder text.
					$('.ui-widget-content').attr('placeholder', '');
				},
				afterTagRemoved:function(event, ui) {
					//If this is the last tag restore the placeholder text.
					if ($('#tags').tagit('assignedTags').length == 0)
						$('.ui-widget-content').attr('placeholder', 'search tags');
				}
			});
			//Allow j
			$('#date_created, #date_modified').datetimepicker({
				//dateFormat:'dd-mm-yy',
				dateFormat:'yy-mm-dd',
				timeFormat:'H:m:ss',
				changeYear:true,
				changeMonth:true
			});
			//Generate the slug.
			$('#title').keyup(function(e){
				var title = $.trim($(this).val().toLowerCase());
				if (title)
					$('#slug').val(title.replace(/ +/g, '-').replace(/[^\w-]+/g, ''));
			});
		}
	}
});