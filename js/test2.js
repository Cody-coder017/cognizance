$(document).ready(function() {
	
	var draw = SVG('svg-display').size('100%', '100%');
	var circleDiameter = getAveragePixelDimension() * 0.1;
	var circle = draw.circle(circleDiameter, circleDiameter).fill('#fff');
	var d = [getMaxX() / 2, getMaxY() / 2];
	var v = [0, 0];
	var randomShapeQueue = [];
	var maxRandomShapes = 5;
	var ballVelocityVariation = getAveragePixelDimension() * 0.002;
	
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
			console.log(JSON.stringify(d));
		}
	}
	
	function getRandomColour() {
		return '#' + Math.random().toString(16).substring(2, 5);
	}

	function addRandomShape() {
		var size = getAveragePixelDimension() * 0.05 * (1 + Math.random());
		var x = Math.random() * (getMaxX() - size);
		var y = Math.random() * (getMaxY() - size);

		if (randomShapeQueue.length > maxRandomShapes) {
			randomShapeQueue[0].remove();
			randomShapeQueue.shift(); // remove the first from the queue.
		}
		var newShape;
		if (Math.random() < 0.5)
			newShape = draw.rect(size, size);
		else {
			newShape = draw.circle(size, size);
		}
		
		newShape.move(x, y);
		randomShapeQueue.push(newShape);
		newShape.animate().fill(getRandomColour());
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

	window.setInterval(moveBox, 20);
});