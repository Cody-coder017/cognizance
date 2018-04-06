$(document).ready(function() {
	
	function Square(colour, size, x, y) {
		var self = this;

		Shape.apply(self, [colour, size, x, y]);
		
		self.draw = function() {
			var newShape = draw.rect(size, size);
			newShape.move(x, y);
			newShape.animate().fill(colour);
			return newShape;
		};
		
		self.getEventType = function() {
			return 'shape/square';
		};
	}
	
	function Circle(colour, size, x, y) {
		var self = this;

		Shape.apply(self, [colour, size, x, y]);
		
		self.draw = function() {
			var newShape = draw.circle(size, size);
			newShape.move(x, y);
			newShape.animate().fill(colour);
			return newShape;
		};

		self.getEventType = function() {
			return 'shape/circle';
		};
	}

	function Shape(colour, x, y, size) {
		var self = this;
		self.getDrawEventData = function() {
			return {
				'type': 'shape/square',
				'action_name': 'draw',
				'when': new Date().getTime(),
				'parameters': {
					'colour': colour,
					'size': size,
					'x': x,
					'y': y
				}
			};
		};
	}
	
	function createRandomShape() {
		var size = getAveragePixelDimension() * 0.05 * (1 + Math.random());
		var x = Math.random() * (getMaxX() - size);
		var y = Math.random() * (getMaxY() - size);
		var colour = getRandomColour();
		if (Math.random() < 0.5) {
			return new Circle(colour, size, x, y);
		}
		else {
			return new Square(colour, size, x, y);
		}
	}
	
	var timer;
	var draw = SVG('svg-display').size('100%', '100%');
	var circleDiameter = getAveragePixelDimension() * 0.1;
	var circle = draw.circle(circleDiameter, circleDiameter).fill('#fff');
	var d = [getMaxX() / 2, getMaxY() / 2];
	var v = [0, 0];
	var randomShapeQueue = [];
	var randomShapeCount = 0;
	var maxRandomShapes = 5;
	var ballVelocityVariation = getAveragePixelDimension() * 0.002;
	var gamePlayEvents = [];
	
	function randomizeVelocity() {
		v[0] += (Math.random() - 0.5) * ballVelocityVariation;
		v[1] += (Math.random() - 0.5) * ballVelocityVariation;
	}
	
	function getAveragePixelDimension() {
		return (getMaxX() + getMaxY()) / 2;
	}
	
	function getMaxX() {
		var result = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
		return result;
	}
	
	function getMaxY() {
		var result = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
		return result;
	}

	function processBoundaryCollision() {
		if( v[0] + d[0] < 0 ) {
			v[0] = Math.abs(v[0]);
		}
		else if( v[0] + d[0] > getMaxX() - circleDiameter ) {
			v[0] = -Math.abs(v[0]);
		}
		if( v[1] + d[1] < 0 ) {
			v[1] = Math.abs(v[1]);
		}
		else if( v[1] + d[1] > getMaxY() - circleDiameter ) {
			v[1] = -Math.abs(v[1]);
		}
		return false;
	}

	function processInterval() {
		if (!processBoundaryCollision()) {
			circle.x(d[0]);
			circle.y(d[1]);
		}
	}
	
	function getRandomColour() {
		var result = '';
		var digits = '89abcdef';
		for (var i = 0; i < 3; i++) {
			result += digits.charAt(Math.floor(Math.random() * digits.length));
		}
		return '#' + result;
	}

	function addRandomShape() {
		var newShape = createRandomShape();

		if (randomShapeQueue.length > maxRandomShapes) {
			randomShapeQueue[0].remove();
			randomShapeQueue.shift(); // remove the first from the queue.
		}
		randomShapeQueue.push(newShape.draw());
		gamePlayEvents.push(newShape.getDrawEventData());
		randomShapeCount++;
	}

	function moveBox() {
		processInterval();
		d[0] += v[0];
		d[1] += v[1];
		randomizeVelocity();
		if (Math.random() < 0.05) {
			addRandomShape();
		}
	}

	function endGame() {
		draw.remove();
		window.clearInterval(timer);
		$('.content').remove();
		$('body').addClass('game-over');
	}
	
	function submitResults() {
		var data = {
			'events': gamePlayEvents,
			'guessed_number': $('input').val()
		};
		// FIXME: change this to run $.ajax and POST eventsData to server.
		var deferred = $.Deferred().resolve();
		return deferred.promise();
	}
	
	function seeResults() {
		submitResults().then(function() {
			location.href = 'results.php';
		});
	}
	
	function updateNavigateDisabled() {
		var val = $('input[type="number"]').val();
		if (!isNaN(val) && val && parseInt(val) > 0) {
			$('.main-navigation-button').removeAttr('disabled');
		}
		else {
			$('.main-navigation-button').attr('disabled', true);
		}
	}

	$('input').bind('change keypress', updateNavigateDisabled);
	$('.main-navigation-button').attr('type', 'button').click(seeResults);
	timer = window.setInterval(moveBox, 20);
	setTimeout(endGame, 20 * 1000);
});