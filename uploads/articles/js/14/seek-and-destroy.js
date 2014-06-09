/*
	@description
		-A demonstration of several fundamental components of an HTML5 Canvas game written in pure Javascript.
	@copyright
		-2014 shipping Soon
	@example
		-https://www.shippingsoon.com/user/login
	@version
		-Path v0.01
	@license
		-GPLv3
*/

onload = function(){
	//Frames per second.
	var FPS = 30;
	//Our canvas element.
	var canvas = document.getElementsByTagName('canvas')[0];
	canvas.style.border = 'solid 1px #BBB';
	canvas.style.backgroundColor = '#F1F1F1';
	var context = canvas.getContext('2d');
	//This object will keep track of the mouse's position.
	var player = {
		x:0,
		y:0,
		radius:16,
		color:'red',
		setPosition:function(x, y){
			this.x = Math.ceil(x);
			this.y = Math.ceil(y);
		},
		draw:function(n){
			var message = 'What a terrible shade of blue...';
			switch (n) {
				case 1:
					message = "Great...now I'm purple";
					this.color = '#800080';
					break;
				case 2:
					message = "";
					this.color = '#A020A0';
					break;
				case 3:
					message = "Stay back!";
					this.color = '#C040C0';
					break;
				case 4:
					message = "I was joking!";
					this.color = '#D050D0';
					break;
				default:
					this.color = 'red';
					break;
			}
			context.pCircle(this.x, this.y, this.radius, this.color);
			context.pText(message, this.x + 20, this.y - 20);
		}
	};
	//An array of enemies.
	var enemies = [];
	//Set the width and height of the canvas.
	canvas.width = canvas.parentNode.clientWidth;
	canvas.height = 400;
	//When the mouse is moved, update our player's position.
	canvas.addEventListener('mousemove', function(e){
		//Use the canvas' boundaries as an offset to get a relative mouse position.
		var rect = this.getBoundingClientRect();
		player.setPosition(e.clientX - rect.left, e.clientY - rect.top);
	}, false);
	//If the user resizes their browser window, adjust the width and height of our canvas.
	window.addEventListener('resize', function(e){
		canvas.width = canvas.parentNode.clientWidth;
		canvas.height = 400;
	}), false;
	//Enemy constructor.
	function Enemy(o)
	{
		//Initiate the enemy's public and private members with default values.
		this.active = true;
		this.x = o.x || 0;
		this.y = o.y || 0;
		this.radius = o.radius || 20;
		//The following properties will only be accessed from within the enemy objects.
		var color = o.color || 'blue',
			speed = o.speed || 1,
			x = 0,
			y = 0;
		//This member will move the enemy and check to see if it collided with the player.
		this.update = function() {
			//Get the angle that the enemy needs to move towards to reach the player. This value
			//only needs to change when the mouse makes a move, so a less expensive measure would
			//be to update it during a mousemove event.
			var targetAngle = angle(player, this),
				targetDistance = distance(player, this);
			//Adjust the enemy's speed if it is moving at a rate that would skip over the target. 
			if ((targetDistance + this.radius) < (speed * 2))
				speed = targetDistance;
			//Convert the enemy's polar coordinates to Cartesian coordinates.
			this.x += speed * Math.cos(targetAngle);
			this.y += speed * Math.sin(targetAngle);
			//These two coordinates will be used to draw the line that points in the direction the enemy is heading.
			x = this.radius * Math.cos(targetAngle),
			y = this.radius * Math.sin(targetAngle);
			//This boolean will determine if the enemy is alive.
			this.active = (this.active && !collision(player, this));
		};
		//Render the enemies.
		this.draw = function(n){
			//The size of the enemy's mouth.
			this.lineWidth = this.lineWidth || 0;
			//If the enemy is still alive.
			if (this.active) {
				//Draw the enemy.
				context.pCircle(this.x, this.y, this.radius, color);
				//Draw the enemy's mouth.
				context.pLine(this.x, this.y, this.x + x, this.y + y, '#F1F1F1', this.lineWidth++, 'round');
				if (this.lineWidth > 18)
					this.lineWidth = 0;
				if (n >= 4)
					context.pText("Get him!", this.x + 20, this.y - 20);
			}
		};
	}
	//Returns the distance between two points.
	function distance(a, b)
	{
		return Math.sqrt(Math.pow(b.x - a.x, 2) + Math.pow(b.y - a.y, 2));
	}
	//Get the angle of a target relative to a given position.
	function angle(target, position)
	{
		return Math.atan2(target.y - position.y, target.x - position.x);
	}
	//Circular collision detection.
	function collision(a, b)
	{
		//If the distance between the colliding objects is smaller than the combined radius.
		return (distance(a, b) < (a.radius + b.radius));
	}
	//Draws a line.
	CanvasRenderingContext2D.prototype.pLine = function(x, y, w, h, color, width, cap)
	{
		this.beginPath();
		this.moveTo(x, y);
		this.lineTo(w, h);
		this.strokeStyle = color || 'black';
		this.lineWidth = width || 4;
		this.lineCap = cap || 'butt';
		this.stroke();
	}
	//Draws a circle.
	CanvasRenderingContext2D.prototype.pCircle = function(x, y, radius, color)
	{
		this.beginPath();
		this.arc(x, y, radius, 0, 2 * Math.PI, false);
		this.fillStyle = color;
		this.fill();
		this.lineWidth = 4;
		this.strokeStyle = 'black';
		this.stroke();
	}
	//Draws text.
	CanvasRenderingContext2D.prototype.pText = function(message, x, y, font, color, align)
	{
		//Set the font type and color.
		this.font = font || 'bold 16px arial';
		this.fillStyle = color || '#444';
		this.textAlign = align || 'left';
		this.fillText(message, x, y);
	}
	//Handles the logic.
	function update()
	{
		//If we currently do not have any enemies. Make some.
		if (enemies.length == 0) {
			for (var i = 0; i < 5; i++) {
				//This will create n amount of enemies with randomly generated properties.
				enemies.push(new Enemy({
					x:0,
					y:Math.floor((Math.random() * 600) + 0),
					speed:Math.floor((Math.random() * 8) + 1)
				}));
			}
		}
		//For each enemy, update their position and check for collision.
		enemies.forEach(function(enemy){
			enemy.update();
		});
		//Filter out inactive enemies.
		enemies = enemies.filter(function(enemy) {
			return enemy.active;
		});
	}
	//Clears the canvas and draws stuff.
	function draw()
	{
		//Clear the canvas.
		context.clearRect(0, 0, canvas.width, canvas.height);
		//For each enemy render them to the canvas.
		enemies.forEach(function(enemy){
			enemy.draw(enemies.length);	
		});
		//Draw the player.
		player.draw(enemies.length);
		context.pText("Mouse (" + player.x + ", " + player.y + ")", 10, 20);
	}
	//Call our two primary functions every n frames per second.
	setInterval(function(){
		//Only run our code if the user is hovering over the canvas.
		if (canvas.parentElement.querySelector(':hover') === canvas) {
			update();
			draw();
		}
	}, (1000 / FPS));
	//Introductory message.
	context.pText("MOVE MOUSE HERE!", canvas.width / 2, canvas.height / 2, 'bold 32px arial', 'deepSkyBlue', 'center');
};