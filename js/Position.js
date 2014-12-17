var Position = function()
{
		var board = [0, 0, 0, 0, 0, 0, 0, 0, 0];
		
		return {
			get : function(index){
				if(index == undefined) return board;
				return board[index];
			},
			
			set : function(index, value){
				board[index] = value;
			},
			
			update : function(boardObj){
				for(var i in boardObj){
					this.set(i, boardObj[i]);
				}
			}
		};
}();

var Const = {
		HUMAN : 1,
		BLANK : 0,
		COM : -1,
		
		TURN : this.HUMAN	//indicates who should play now
};