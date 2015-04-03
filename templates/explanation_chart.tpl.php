<div id="explanation_chart_results">
<?php
$explanation_chart = new Chart(date('Y-m-d'),0,1,date('Y-m-d'),date('Y-m-d'),$lang_code);
$explanation_chart->render_explanation_chart();
?>
</div>