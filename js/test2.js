$(document).ready(function() {

	function ViewportResize(width, height) {
		var self = this;

		self.getEventData = function() {
			return {
				'type': 'viewport/resize',
				'width': width,
				'height': height
			};
		};
	}

	function TouchPointMoved(x, y) {
		var self = this;
		
		self.getEventData = function() {
			return {
				'type': 'input/touchmove',
				'x': x,
				'y': y
			};
		};
	}

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
	var ballVelocityVariation = getAveragePixelDimension() * 0.001;
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

	function viewportResized() {
		var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
		var h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
		gamePlayEvents.push(new ViewportResize(w, h).getEventData());
	};

	function moveBox() {
		processInterval();
		d[0] += v[0];
		d[1] += v[1];
		gamePlayEvents.push({
			'type': 'position/move',
			'x': d[0],
			'y': d[1]
		});
		randomizeVelocity();
		if (Math.random() < 0.01) {
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
		var game_play_data = {
			'events': gamePlayEvents,
			'guessed_number': $('input').val()
		};
		var data = {
			'test_id': 2,
			'game_play_data': JSON.stringify(game_play_data)
		};
		return $.ajax({
			'url': 'api/save_test_results.php',
			'method': 'POST',
			'data': data,
			'error': function(jqXHR, textStatus, errorThrown) {
				processAJAXError(jqXHR, textStatus, errorThrown);
			}
		});
	}

	function seeResults() {
		submitResults().then(function(response) {
			if (typeof response === 'string') {
				response = JSON.parse(response);
			}
			if (!response || !response.user_rating_id) {
				throw new Error('response = ' + response);
			}
			location.href = 'results.php?user_rating_id=' + response.user_rating_id;
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
	
	function touchPointMoved(event) {
		var x = event.clientX, y = event.clientY;
		if( x === undefined || y === undefined ) {
			x = event.originalEvent.touches[0].pageX;
			y = event.originalEvent.touches[0].pageY;
		}
		var evt = new TouchPointMoved(x, y);
		gamePlayEvents.push(evt.getEventData());
		$('.touch-point-marker').removeClass('hidden').css({
			'top': y + 'px',
			'left': x + 'px'
		});
	}

	function preventBehavior(e) {
		e.preventDefault(); 
		e.stopPropagation();
		e.returnValue = false;
		return false;
	};

	// Prevent dragging your finger from swapping pages.
	document.addEventListener("touchmove", preventBehavior, false);

	$('input').on('change keypress keyup', updateNavigateDisabled);
	$('body').on('touchmove touchstart touchend mousemove mousedown mouseup', touchPointMoved);
	$('.main-navigation-button').attr('type', 'button').click(seeResults);
	timer = window.setInterval(moveBox, 20);
	window.setTimeout(endGame, 10 * 1000);
	viewportResized();
	$(window).resize(viewportResized);
});