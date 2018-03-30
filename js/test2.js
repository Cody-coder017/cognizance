$(document).ready(function() {
	var v = {'x': 0, 'y': 0};
	var p = {'x': 0, 'y': 0};
	var r = 10;
	
	function normalize(v, scale, max_change) {
		var r = Math.sqrt(v.x * v.x + v.y * v.y);
		if ( r < 0.0001 ) {
			return;
		}
		var change_amount = Math.min(r / scale * max_change, max_change);
		var ax = v.x / r;
		var ay = v.y / r;
		r = Math.max(change_amount, r - change_amount);
		v.x = ax * r;
		v.y = ay * r;
	}
	
	function limitPosition() {
		var radius = 10;
		p.x = Math.max(-50 + radius, p.x);
		p.x = Math.min(50 - radius, p.x);
		p.y = Math.max(-50 + radius, p.y);
		p.y = Math.min(50 - radius, p.y);
	}

	function moveCircle() {
		p.x += v.x;
		p.y += v.y;
		
		var new_position = {
			'cx': (p.x + 50) + '%',
			'cy': (p.y + 50) + '%',
			'r': r + '%'
		};

		v.x += Math.random() - 0.5;
		v.y += Math.random() - 0.5;
		r = Math.min(20, Math.max(0.1, r + Math.random() - 0.5));
		normalize(v, 5, 0.5);
		limitPosition();

		$('#followed-circle').css(new_position);
	}

	function addRandomShape() {
		
	}
	
	function animationUpdated() {
		moveCircle();
		if ( Math.random() < 0.01 ) {
			addRandomShape();
		}
	}
	
	setInterval(animationUpdated, 50);
});