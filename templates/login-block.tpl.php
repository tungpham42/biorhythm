<?php
if($_SESSION['loggedin'])
{
?>
	Welcome, <b>Tung</b>
	<ul style="list-style:none">
	<li style="float:left">
	<input type="button" value="Log Out" onclick="window.location.href='triggers/logout.php'"/>
	</li>
	</ul>
<?php } ?>