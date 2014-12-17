<?php
$sponsor_id = prevent_xss($_GET['sponsor_id']);
?>
<h2>Thank you for your sponsor</h2>
<p>This is your Sponsor ID: <strong><?php echo $sponsor_id; ?></strong> , please <strong>REMEMBER</strong> this KEY to verify your payment! Should you have any question, please contact me via Email <a title="tung.42@gmail.com" href="mailto:tung.42@gmail.com" class="rotate"><span data-title="tung.42@gmail.com">tung.42@gmail.com</span></a>.</p>
<a class="button" href="/?p=race">Bonus Game</a>