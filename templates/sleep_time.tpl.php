<section id="sleep_time">
	<h5><?php echo translate_span('sleep_time'); ?></h5>
	<p><?php echo translate_span('sleep_time_head'); ?></p>
<?php
echo translate_span('hour','hour_text');
echo translate_span('minute','minute_text');
?>
	<select id="sleep_time_hour" class="m-wrap">
		<option><?php echo $span_interfaces['hour'][$lang_code]; ?></option>
		<option>0</option>
		<option>1</option>
		<option>2</option>
		<option>3</option>
		<option>4</option>
		<option>5</option>
		<option>6</option>
		<option>7</option>
		<option>8</option>
		<option>9</option>
		<option>10</option>
		<option>11</option>
		<option>12</option>
		<option>13</option>
		<option>14</option>
		<option>15</option>
		<option>16</option>
		<option>17</option>
		<option>18</option>
		<option>19</option>
		<option>20</option>
		<option>21</option>
		<option>22</option>
		<option>23</option>
		<option>24</option>
	</select>
	<select id="sleep_time_minute" class="m-wrap">
		<option><?php echo $span_interfaces['minute'][$lang_code]; ?></option>
		<option>00</option>
		<option>05</option>
		<option>10</option>
		<option>15</option>
		<option>20</option>
		<option>25</option>
		<option>30</option>
		<option>35</option>
		<option>40</option>
		<option>45</option>
		<option>50</option>
		<option>55</option>
	</select>
	<div>
		<p><?php echo translate_span('sleep_time_results'); ?></p>
		<span id="sleep_time_results"></span>
	</div>
	<p><?php echo translate_span('wake_up_time_head'); ?></p>
	<a class="m-btn green" id="sleep_now"><?php echo translate_button('sleep_now'); ?></a>
	<div>
		<p><?php echo translate_span('wake_up_time_results'); ?></p>
		<span id="wake_up_time_results"></span>
	</div>
</section>