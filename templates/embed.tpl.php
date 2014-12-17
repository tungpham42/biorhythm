<section id="embed_chart_results">
<?php
$embed_chart = new Chart($dob,0,0,date('Y-m-d'),$lang_code);
$embed_chart->render_embed_chart();
?>
</section>