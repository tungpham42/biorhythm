<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init_trigger.inc.php';
$count = (isset($_POST['count'])) ? $_POST['count']: 0;
$time = (isset($_POST['time'])) ? $_POST['time']: 0;
$player_names = array();
$player_colors = array();
$game_id = '';
for ($i = 0; $i < $count; $i++) {
	$player_names[$i] = (isset($_POST['player'.($i + 1)])) ? $_POST['player'.($i + 1)]: '';
}
for ($i = 0; $i < $count; $i++) {
	$player_colors[$i] = get_random_color_hex();
	$game_id .= $player_colors[$i];
	$game_id .= ($i < $count - 1) ? '-': '';
}
for ($i = 0; $i < $count; $i++) {
	echo ($i != 0) ? '<div class="race_lane">': '<div class="race_lane first">';
	echo '<div style="background: #'.$player_colors[$i].';border-color:#'.$player_colors[$i].';" class="player" id="player'.($i+1).'"><div class="name">'.$player_names[$i].'</div><span class="position timer"></span></div>';
	echo '</div>';
}
?>
<a class="button" id="start"><span>Chơi</span></a>
<a class="button" id="restart"><span>Chơi lại</span></a>
<a class="button" href="?p=race"><span>Quay về bước 1</span></a>
<div class="error_msg <?php echo $game_id; ?>"></div>
<script>
$('#start').click(function(){
	if (!$(this).hasClass('disabled')) {
		$(this).addClass('disabled');
<?php
for ($i = 0; $i < $count; $i++):
?>
		raceRandom('#player<?php echo ($i + 1); ?>');
<?php
endfor;
?>
	} else {
		$('.error_msg.<?php echo $game_id; ?>').html('Nút "Chơi" bị vô hiệu hóa, hãy ấn nút "Chơi lại" rồi ấn nút "Chơi').dialog({position:{my: 'center', at: 'center', of: 'main'}, open: function(event, ui){
			setTimeout("$('.error_msg').dialog('close')",2000);
		}});
		return false;
	}
});
$('#restart').click(function() {
	$('#game').load('triggers/game.php',{count: <?php echo $count; ?>,time: <?php echo $time; ?>,
<?php
for ($i = 0; $i < count($player_names); $i++) {
	echo 'player'.($i+1).': "'.$player_names[$i].'"'.(($i != (count($player_names) - 1)) ? ',': '');
}
?>
	});
});
</script>