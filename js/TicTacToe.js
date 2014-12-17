var TicTacToe = function(paperId, options)
{
	var defaults = {
			size : 500,
			background : '#EEEF95',
			cell_fill : '45-#C0C0C0-#666',
			cell_stroke : '#C2C2C2',
			stroke_width : 6,
			padding : 10
	};
	
	options = options || {};
	this.properties = $.extend(defaults, options);
	this.isPlaying = true;
	$('#'+paperId).css({'width' : this.properties.size});
	this.canvas = Raphael(document.getElementById(paperId), this.properties.size, this.properties.size);
	this.makeBoard();
};

/**
 * Creates the TicTacToe board 
 */
TicTacToe.prototype.makeBoard = function()
{
	this.canvas.clear();
	this.canvas.rect(0, 0, this.properties.size, this.properties.size).attr('fill', this.properties.background);
	var cellWidth = Math.round(this.properties.size / 3);
	for ( i = 0; i < 3; i++) {
		for ( j = 0; j < 3; j++) {
			var x =  i * cellWidth + this.properties.padding;
			var y = j * cellWidth + this.properties.padding;
			var num = i * 3 + j;
			var cell = this.canvas.rect( y, x, cellWidth-this.properties.padding*2, cellWidth-this.properties.padding*2, 10)
			.attr({'stroke' : this.properties.cell_stroke, 'fill' : this.properties.cell_fill});

			cell.node.setAttribute('id', 'cell' + num); 
			var _this = this;
			cell.node.onclick = function(e){
				if($.browser.mozilla == true){
					var target = e.target;
				}else{
					var target =	window.event.srcElement;
				}
				_this.clickHandler(target);
			};
		}
	}
};

TicTacToe.prototype.clickHandler = function(target)
{
	if (!this.isPlaying) return;
	if (Const.TURN == Const.COM) return;
	
	var cellIndex = target.raphael.id-1;
	this.o(target);
	Position.set(cellIndex, Const.HUMAN);	//update the board
	Const.TURN = Const.COM;
	this.post();
};

TicTacToe.prototype.x = function(target)
{
	var width = parseInt(target.raphael.attrs.width);
	var height = parseInt(target.raphael.attrs.height);
	var startX = parseInt(target.raphael.attrs.x) + (2*this.properties.padding);
	var startY = parseInt(target.raphael.attrs.y) + (2*this.properties.padding);
	var endX = startX+ width - (4*this.properties.padding); 
	var endY = startY + height - (4*this.properties.padding); 
	this.canvas.path('M '+startX+' '+startY+'L'+endX+' '+endY).attr('stroke-width', this.properties.stroke_width);
	this.canvas.path('M '+endX+' '+startY+'L'+startX+' '+endY).attr('stroke-width', this.properties.stroke_width);
};

TicTacToe.prototype.o = function(target)
{
		var x = parseInt(target.raphael.attrs.x);
		var y = parseInt(target.raphael.attrs.y);
		var centerX = parseInt(target.raphael.attrs.width) / 2 + x; 
		var centerY = parseInt(target.raphael.attrs.height) / 2 + y; 
		this.canvas.circle(centerX, centerY, parseInt(target.raphael.attrs.width)/3).attr('stroke-width', this.properties.stroke_width);
};

TicTacToe.prototype.post = function()
{
	var _this = this;
	var data = 'board='+Position.get();
	$.post('index.php', data, function(data){
		for(var i in data.board){
			if (data.board[i] != Position.get(i)) {
				_this.x(document.getElementById('cell'+i));
				break;
			}
		}
		Position.update(data.board);
		Const.TURN = Const.HUMAN;
		if(data.status != null){
			switch (data.status) {
			case Const.COM:
				_this.isPlaying = false;
				alert('You Lost');
				break;
			case Const.HUMAN:
				_this.isPlaying = false;
				alert('You Won');
				break;
			case (0):
				_this.isPlaying = false;
				alert('The Game is Drawn');
				break;
				
			default:
				alert('Unknown status');
				break;
			}
		}
		
	}, 'json');
};