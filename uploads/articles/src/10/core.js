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
//Change the carousel's title and subtitle.
function update_carousel(carousel, active)
{
	var active = carousel.find(active ? '.active' : '.item:first');
	var title = active.attr('data-title'),
		subtitle = active.attr('data-subtitle');
	carousel.find('h1.opensans').html(title);
	carousel.find('p.opensans').html(subtitle);
}
jQuery(document).ready(function($) {
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
		update_carousel($('#contact-carousel'), false);
		//Change the carousel's text when a slide event is triggered.
		$('#contact-carousel').on('slid.bs.carousel', function(e) {
			update_carousel($(this), true)
		});
		
	}
	else if ($('body').hasClass('blog') || $('body').hasClass('portfolio') && $('body').hasClass('view')) {
		//
		$('.tagcloud a').tagcloud({size:{start:10, end:16, unit:'pt'}});
		//Make source code look pretty.
		prettyPrint();
		//
		$('.fancybox').fancybox()
	}
	else if ($('body').hasClass('login')) {
		//Display help information for the login terminal.
		$('.terminal-wrapper .fa').tooltip({'title':'Type help for a list of supported commands'});
		//Create a login terminal with our very own terminal script.
		$('.login-terminal').terminal('create', {});
	}
	else if ($('body').hasClass('about')) {
		$('.proficiency-list a').tooltip({placement:'left'});

	}
	if ($('body').hasClass('core') || $('body').hasClass('portfolio')) {
		//By default, only show web applications.
		var ignore = $('#project-filters').attr('data-ignore');
		if (ignore)
			$('.featured-content .all').not('.'+ignore).hide();
		//Toggle the visibility of featured projects.
		$('.portfolio-filters .filter-btn').click(function(e){
			var toggle_class = ($(this).is('button')) ? 'btn-info' : 'active';
			$('.portfolio-filters .filter-btn').removeClass(toggle_class);
			$(this).addClass(toggle_class);
			var filter = $(this).attr('data-filter');
			$('.featured-content > div').each(function(index, element){
				var filters = $(this).attr('data-filters').replace(/ /g, '').split(',');
				($.inArray(filter, filters) != -1)
					? $(this).fadeIn('slow')
					: $(this).fadeOut('fast');
			});
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
					//console.log(JSON.stringify(data));
					if (data.success) {
						if (data.redirect_url || data.redirect_url == '')
							document.location.href = base_url(data.redirect_url);
					}
					if (data.show_modal)
						core_modal(data.header, data.body, data.status)
				},
				error:function(data){
					//console.log(data);
				}
			});
			return false;
		});
	}
});