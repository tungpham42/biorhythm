<div id="game">
<div class="race_lane">
<div style="background: #<?=getRandomColorHex(); ?>" class="player" id="player"><div class="name">Player</div></div>
</div>
<span style="display: none" id="random_distance"></span>
<span style="display: none" id="current_distance"></span>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script>
$("#game").disableSelection();
function run() {
	$("#random_distance").load("./race/random_distance.php");
	var randomDistance = $("#random_distance").text();
	$("#player").animate({left: "+="+randomDistance+"px"},{duration: 1000, easing: "linear"});
	$("#current_distance").text() = $("#player").css("left");
}
$("body").mousedown(function(e){
	if(e.which == 1) {
		run();
	}
});
</script>
</div>