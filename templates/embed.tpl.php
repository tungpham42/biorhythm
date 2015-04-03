<section id="embed_chart_results">
<?php
if ($dob == ''):
	$dob = date('Y-m-d');
endif;
$embed_chart = new Chart($dob,0,0,date('Y-m-d'),$dob,$lang_code);
$embed_chart->render_embed_chart();
?>
</section>