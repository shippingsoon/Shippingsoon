//
window.onpopstate = function(e)
{
    if (e.state) {
		$('#offset').val(e.state.offset);
		$('#limit').val(e.state.limit);
		$('.search-query').attr({'data-onpopstate':1, 'data-enabled':0});
		$('.search-query').tagit('removeAll');
		var tags = e.state.tags.split('-');
		for (var i in tags)
			$('.search-query').tagit('createTag', tags[i]);
		$('.search-query').attr('data-enabled', 1);
		get_search_results(e.state.offset, e.state.limit, e.state.tags);
		$('.search-query').attr('data-onpopstate', 0);
	}
}
//Returns the base URL.
function base_url(path)
{
	path = (path) ? path.toLowerCase() : '';
	return document.getElementsByTagName('base')[0].href+path;
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
//
function get_search_results(offset, limit, tags)
{
	if ($('.search-query').attr('data-enabled') != 1)
		return false;
	var offset = (offset === undefined || offset === null) ? $('#offset').val() : offset,
		limit = (limit === undefined || limit === null) ? $('#limit').val() : limit,
		tags = (tags === undefined || tags === null) ? $('.search-query').tagit('assignedTags').join('-') : tags;
	$.ajax({
		type:'POST',
		url:base_url('portfolio/search/'+offset+'/'+limit+'/'+encodeURIComponent(tags)),
		dataType:'json',
		success:function(data) {
			if (data) {
				$('.featured-content').empty();
				$('.pager').html(data.pager);
				$('title').html(((tags) ? tags.replace(/-/g, ', ') + ' - Search results' : 'Search - Shipping Soon'));
				$('.portfolio-banner h1').html(((tags) ? 'Search results for: <b>'+tags.replace(/-/g, ', ')+'</b>' : 'Search'));
				$.each(data.articles, function(key, article) {
					var template = $('.featured-projects .template').clone();
					template.removeClass('template').removeClass('hide');
					template.find('.title a').html(article.title);
					template.find('.title a, .overlay > a:eq(0)').attr({
						title:'Read more about '+article.title,
						href:base_url(((article.category != 'Portfolio') ? 'blog/'+article.category : 'portfolio')+'/'+article.slug+'/'+article.article_id)
					});
					template.find('.subtitle').html(article.description);
					template.find('.photo-frame').prepend($('<img />').attr({
						'src':base_url('uploads/articles/img/'+article.article_id+'/0.jpg'),
						'alt':article.title,
						'class':'img-responsive'
					}));
					if (article.source_link)
						template.find('.overlay > a:eq(1)').removeClass('hide').attr({
							title:'View '+article.title+"'s source code",
							href:article.source_link
						});
					else if (article.live_link)
						template.find('.overlay > a:eq(2)').removeClass('hide').attr({
							title:'View '+article.title,
							href:article.live_link
						});
					$('.featured-content').append(template);
				});
				if (data.articles.length < 1)
					$('<h2>No results found for: <b>'+tags.replace(/-/g, ', ')+'</b></h2>')
						.addClass('centered opensans light-weight')
						.appendTo('.featured-content');
			}
		},
		error:function(data){
			console.log(data);
		}
	});
	if ($('.search-query').attr('data-onpopstate') == 0)
		history.pushState({'offset':offset, 'limit':limit, 'tags':tags}, 'Next', base_url('portfolio/search/'+offset+'/'+limit+'/'+encodeURIComponent(tags)));		
}
jQuery(document).ready(function($) {
	$('.core-search .glyphicon-search').click(function(e){
		$('.core-search').submit();
	});
	$('.core-search').submit(function(e){
		e.preventDefault();
		var action = $(this).attr('action'),
			value = $.trim($(this).find('input').val());
		if (value)
			window.location = action+'/'+encodeURIComponent(value)+'#search';
	});
	$('.core-search input').keyup(function(){
		this.value = this.value.replace(/[^a-zA-Z0-9+]+/g, '');
	});
	$('.core-search input').focusin(function(){
		$(this).parent().addClass('focused');
	});
	$('.core-search input').blur(function(){
		$(this).parent().removeClass('focused');
	});
	//Set default parameters for AJAX calls.
	$.ajaxSetup({
		type:'POST',
		cache:false,
		contentType:'application/x-www-form-urlencoded; charset=utf-8',
		async:false,
		dataType:'json'
	});
	//Log statistics.
	setInterval('statistics()', 30 * 1000);
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
	else if ($('body').hasClass('portfolio') && $('body').hasClass('search')) {
		if ($('#offset').val() == 0 && !$('.search-query').val()) {
			history.replaceState({'offset':0, 'limit':12, 'tags':''}, 'search', base_url('portfolio/search/0/12'));
			console.log('test');
		}
		var placeholder = 'search for projects';
		//Initialize tagit.
		$('.search-query').tagit({
			availableTags:($('#auto_complete').length > 0) ? $('#auto_complete').val().split(',') : '',
			autocomplete: {delay:0, minLength:2},
			allowSpaces:false,
			singleFieldDelimiter:',',
			caseSensitive:false,
			placeholderText:placeholder,
			fieldName:'tags[]',
			afterTagAdded:function(event, ui) {
				//Hide the placeholder text.
				$('.ui-widget-content').attr('placeholder', '');
				get_search_results(0);
			},
			afterTagRemoved:function(event, ui) {
				//Restore the placeholder text.
				if ($('.search-query').tagit('assignedTags').length == 0)
					$('.ui-widget-content').attr('placeholder', placeholder);
				get_search_results(0);
			}
		});
		//Focus in on the search area.
		$('.ui-autocomplete-input').focus();
		//Make sure the input is alphanumeric.
		$('.tagit-new input').keyup(function(){
			this.value = this.value.replace(/[^a-zA-Z0-9+]+/g, '');
		});
		//When the search icon is clicked get search results.
		$('.search-box .glyphicon-search').click(function(e){
			get_search_results(0);
		});
		 //Search for new results when a pager link is clicked.
		$('.pager').on('click', 'a', function(e) {
			e.preventDefault();
			$('#offset').val($(this).attr('data-offset'));
			//Retrieve new search results.
			get_search_results();
			//Scroll to the top of the search results area.
			$('html, body').animate({
				scrollTop: $('.portfolio-search').offset().top
			}, 300);
		});
		//
		$('.portfolio-search .dropdown-menu a').click(function(e){
			e.preventDefault();
			var parent = $(this).parent().parent();
			var type = parent.attr('data-type'),
				label = $(this).text(),
				tags = $('.search-query').tagit('assignedTags'),
				value = $(this).attr('data-value');
			$('.dropdown-toggle.'+type).html(label+' <span class="caret"></span>');
			$.each($('.search-query').tagit('assignedTags'), function(key, tag) {
				parent.find('a').each(function(index, dom) {
                    if (tag.toLowerCase() == dom.innerHTML.toLowerCase()) {
                        $('.tagit .tagit-label').each(function(k, val) {
                            if (tag.toLowerCase() == val.innerHTML.toLowerCase()) {
                                tags.splice(tags.indexOf(tag), 1);
                                $('.search-query').val(tags.join(','))
                                $(this).parent().remove();
                            }
                        })
                    }
                });
            });
			if (value != 'all')
				$('.search-query').tagit('createTag', value);
			else
				get_search_results(0, 12);
		});
	}
	else if ($('body').hasClass('login')) {
		//Display help information for the login terminal.
		$('.terminal-wrapper .fa').tooltip();
		//Create a login terminal with our very own terminal script.
		$('.login-terminal').terminal('create', {});
	}
	else if ($('body').hasClass('about')) {
		$('.proficiency-list a').tooltip();
	}
	if ($('body').hasClass('blog') || $('body').hasClass('portfolio')) {
		//
		$('.tagcloud a').tagcloud({size:{start:10, end:16, unit:'pt'}});
		//Make source code look pretty.
		prettyPrint();
		//
		$('.fancybox').fancybox()
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