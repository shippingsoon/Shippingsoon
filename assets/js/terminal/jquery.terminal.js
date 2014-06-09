/*
	@description
		-This jQuery plugin transforms any element into a Linux-like terminal.
	@copyright
		-2014 shipping Soon
	@example
		-$('.my-terminal').terminal('create', {'user':'anonymous', 'host':'website'});
	@version
		-Terminal v0.05
	@dependencies
		-jQuery v1.11.0
	@license
		-GPLv3
*/
	
//Prevent library naming conflicts by wrapping the '$' character in a self-invoking function.
(function($){
	//Default settings that will be passed to our methods.
	var settings = {
		'class_name':'terminal-container',
		'user':'root',
		'host':'shippingsoon',
		'directory':'~',
		'css':{
			'display':'block',
			'font-family':'"Courier New", Courier, monospace',
			'font-size':'1.3em',
			'line-height':'1.3em',
			'color':'SpringGreen',
			'background-color':'black',
			'width':'100%',
			'height':'450px',
			'max-height':'450px',
			'overflow':'hidden',
		}
	};
	//A list of supported commands.
	var commands = {
		'help':function(){
			var helper = [
				'login [username] [password]',
				'ls [directory_name]',
				'cd [directory_name]', 
				'clear'
			];
			for (var i = 0; i < helper.length; i++)
				dispatchMessage(helper[i]);
		},
		'login':function(){
			if (arguments.length != 2)
				dispatchMessage('login: Cannot possibly work without effective root');
			else {
				$.ajax({
					type:'POST',
					url:base_url('user/login'),
					data:{'email':arguments[0], 'password':arguments[1]},
					dataType:'json',
					success:function(data) {
						if (data.success) {
							if (data.redirect_url || data.redirect_url == '')
								document.location.href = base_url(data.redirect_url);
						}
						else
							dispatchMessage('login: Invalid credentials');
					}
				});
			}
		},
		'clear':function(){
			//Clear the terminal.
			$(settings.class_name).html($('.terminal-left:last, .terminal-right:last'));
		},
		//The following 3 commands are only placeholders. Some day they'll actually do something useful.
		'sudo':function(){
			prompt('[sudo] password for '+settings.user+':', 1);
		},
		'ls':function(){
			dispatchMessage('Desktop Documents Downloads Music');
		},
		'cd':function(){
			var directories = ['Desktop', 'Documents', 'Downloads', 'Music'],
				directory = '~';
			if (arguments[0]) {
				if (directories.indexOf(arguments[0]) == -1)
					dispatchMessage('bash: cd: '+arguments[0]+': No such file or directory');
				else
					directory = '~/'+arguments[0];
			}
			settings.directory = directory;
		}
	}
	//Prompt the user for input.
	function prompt(message, process_id)
	{
		$(settings.class_name).addClass('prompt').attr({'data-prompt':message, 'data-process-id':process_id});
	}
	//Run a command.
	function run(input)
	{
		var command = input.split(' ');
		if (commands[command[0]])
			commands[command[0]].apply(null, command.splice(1));
		else
			dispatchMessage(input+': command not found');
	}
	//Display a message.
	function dispatchMessage(message)
	{
		$("<p></p>", {
			'text':message,
			'css':{
				'margin':'0',
				'clear':'both',
			},
		}).appendTo($(settings.class_name));
	}
	//The methods of this jQuery plugin.
	var methods = {
		//Initiates a new terminal.
		'create':function() {
			//Merge the function arguments with the default settings.
			for (var i = 0; i < arguments.length; i++)
				this.extend(settings, arguments[i]);
			//Run this block of code for each matched element.
			return this.each(function() {
				var terminal = $(this);
				terminal.addClass((settings.class_name) ? settings.class_name : 'terminal-container');
				settings.class_name = '.'+settings.class_name;
				//Style our terminal.
				terminal.css(settings.css);
				$('<div></div>', {
					'class':'terminal-left',
					'css':{
						'float':'left',
						'background-color':'inherit',
						'color':'inherit',
						'clear':'both',
						'width':'auto',
						'margin-right':'8px'
					},
					'text':settings.user+'@'+settings.host+':'+settings.directory+'$',
				}).appendTo(terminal);
				$('<div></div>', {
					'class':'terminal-right',
					'css':{
						'background-color':'inherit',
						'overflow':'hidden'
					}
				}).appendTo(terminal);
				$('<input />', {
					'css':{
						'width':'100%',
						'color':'inherit',
						'background-color':'inherit',
						'font-family':'inherit',
						'font-size':'1em',
						'border':'0px',
						'outline':'0px',
						'margin':'0'
					},
					'type':'text'
				}).appendTo(terminal.find('.terminal-right'));
				$(this).on('keydown', '.active', function(e){
					//If the user presses the Enter key.
					if (e.keyCode == 13){
						//Trim the user's input.
						var line = $.trim($(this).val());
						if (line) {
							$(this).removeClass('active');
							//Clone our terminal template.
							var left = $(settings.class_name).find('.terminal-left').first().clone(),
								right = $(settings.class_name).find('.terminal-right').first().clone();					
							$(this).attr('readonly', 'readonly');
							right.find('input').addClass('active').removeAttr('readonly').val('');
							switch (parseInt($(settings.class_name).attr('data-process-id'))) {
								case 1:
									$('#password').val(line);
									break;
								default:
									run(line);
							}
							if ($(settings.class_name).hasClass('prompt')) {
								left.html($(settings.class_name).attr('data-prompt'));
								$(settings.class_name).removeClass('prompt');
							}
							else
								left.html(settings.user+'@'+settings.host+':'+settings.directory+'$');
							left.appendTo($(settings.class_name));
							
							right.appendTo($(settings.class_name));
							$(settings.class_name).find('.active').focus();
							$(settings.class_name).scrollTop($(settings.class_name).prop('scrollHeight'));
						}
					}
				});
				$(this).find('.terminal-right input').addClass('active').focus()
			});
		},
		'init':function(){
			
		}
	};
	$.fn.terminal = function(method) {
		if (methods[method])
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		else if (typeof method === 'object' || ! method)
			return methods.init.apply(this, arguments);
	};
})(jQuery);

