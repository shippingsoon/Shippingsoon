//Returns the base URL.
function base_url(path)
{
	path = isset(path) ? path : '';
    return document.getElementsByTagName('base')[0].href+path;
}
//Checks to see if a given object is set.
function isset()
{
    var len = arguments.length;
    for (var i = 0; i < len; i++)
        if (typeof arguments[i] === 'undefined' || arguments[i] === null)
            return false;
    return true;
}
//Tracks usage.
function statistics()
{
	var statistic_id = document.getElementById('statistic_id').value;
	if (statistic_id)
		$.post(base_url('core/statistics/'+statistic_id));
}
//A modal for miscellaneous server responses.
function core_modal(header, body, status)
{
	$('#core-modal .modal-body div').attr('class', ((!status) ? 'alert alert-danger' : ''));
	$('#core-modal .modal-header').html(header);
	$('#core-modal .modal-body div').html(body);
	$('#core-modal').modal();
}
jQuery(document).ready(function() {
	//Enable CSS transitions after the page has loaded.
	$('body').removeClass('no-transitions');
	//Set default parameters for AJAX calls.
	$.ajaxSetup({
		type:'POST',
		cache:false,
		contentType:'application/x-www-form-urlencoded; charset=utf-8',
		async:false,
		dataType:'json'
	});
	//Log activity.
	//setInterval('statistics()', 30 * 1000);
	if ($('body').hasClass('core') && $('body').hasClass('index')) {
		//Initiate the carousel.
		$('#contact-carousel').carousel({
			interval:8000,
			pause:'hover',
			wrap:true
		});
		//Change the carousel's text when a slide event is triggered.
		$('#contact-carousel').on('slid.bs.carousel', function(e) {
			var slide_index = $(this).find('.active').index(),
				title = 'Lorem ipsum<br/>commodo, luctus',
				subtitle = 	'\
					Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. \
					Nullam id dolor id nibh ultricies vehicula ut id elit.';
			switch (slide_index) {
				case 1:
					title = 'Etiam porta,<br/>sem malesuada';
					subtitle = '\
						Duis aute irure dolor in reprehenderit in voluptate. \
						Velit esse cillum dolore eu fugiat nulla.';
					break;
				case 2:
					title = 'Porttitor ligula,<br/>eget lacinia';
					subtitle = '\
						Excepteur sint occaecat cupidatat non proident, \
						sunt in culpa qui officia deserunt mollit anim id est laborum.';
					break;
			}
			$(this).find('h1.opensans').html(title);
			$(this).find('p.opensans').html(subtitle);
		});
		
	}
	else if ($('body').hasClass('blog') || $('body').hasClass('portfolio')) {
        //
		SyntaxHighlighter.autoloader(
			'js jscript javascript '+base_url('assets/js/syntaxhighlighter/shBrushJScript.js'),
			'py python '+base_url('assets/js/syntaxhighlighter/shBrushPython.js'),
			'c cpp '+base_url('assets/js/syntaxhighlighter/shBrushCpp.js'),
			'php '+base_url('assets/js/syntaxhighlighter/shBrushPhp.js'),
			'sql '+base_url('assets/js/syntaxhighlighter/shBrushSql.js'),
			'css '+base_url('assets/js/syntaxhighlighter/shBrushCss.js'),
			'xml '+base_url('assets/js/syntaxhighlighter/shBrushXml.js')
		);
		SyntaxHighlighter.defaults['toolbar'] = false;
		SyntaxHighlighter.all();
		$('.table-of-contents').affix({
			offset: {
				top:0,
				bottom:function () {
					return (this.bottom = $('.core-footer').outerHeight(true) + 100);
				}
			}
		});
	}
    else if ($('body').hasClass('user') || $('body').hasClass('login')) {
		$('.terminal-wrapper .fa').tooltip({
			'title':'Type help for a list of supported commands'
		});
		
		$('.login-terminal').terminal('create', {
		
		});
		
	}
	
	if ($('body').hasClass('core') || $('body').hasClass('portfolio')) {
		//By default, only show web applications.
		var ignore = $('#project-filters').attr('data-ignore');
		if (ignore)
			$('.featured-content .all').not('.'+ignore).hide();
		//Toggle the visibility of featured projects.
		$('#project-filters button').click(function(e){
			$('#project-filters button').removeClass('btn-info');
			$(this).addClass('btn-info');
			var filter = $(this).attr('data-filter');
			$('.featured-content .all').not('.'+filter).hide('fast');
			$('.'+filter).show('slow');
			return false;
		});
		//Add a class if the user hovers over a featured project.
		$('.featured-overlay').hover(
			function() {
				//This class will be used to trigger fancy CSS transitions.
				$(this).addClass('hover');
			},
			function() {
				$(this).removeClass('hover');
			}
		);
	}
	
	if ($('body').hasClass('core') || $('body').hasClass('contact') || $('body').hasClass('user')){
		//Add our fancy transitions class.
		$('.waypoint-container').waypoint('sticky', {
			stuckClass:'waypoint',
			offset:200
		});
		//If the contact form is submitted.
		$('.core-form').submit(function(e){
			$.ajax({
				url:$(this).attr('action'),
				type:'POST',
				data:$(this).find('input, textarea').not('input[type=submit]').serialize(),
				success:function(data) {
					console.log(JSON.stringify(data));
					if (data.success) {
						if (data.redirect_url || data.redirect_url == '')
							document.location.href = base_url(data.redirect_url);
					}
					if (data.show_modal)
						core_modal(data.header, data.body, data.status)
				},
				error:function(data){
					console.log(data);
				}
			});
			return false;
		});
	}
});