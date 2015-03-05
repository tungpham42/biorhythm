<script id="chart_script">
<?php
if (has_dob() && $embed == 0) {
	$chart->render_main_chart_script();
} else if (!has_dob()) {
	$explanation_chart->render_explanation_chart_script();
} else if ($embed == 1) {
	$embed_chart->render_embed_chart_script();
}
?>
</script>