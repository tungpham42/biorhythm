<nav>
	<ul id="nav_buttons">
		<li><a id="member_link" class="nav_button button member" href="/member/login/"><i class="icon-<?php echo isset($_COOKIE['NSH:member']) ? 'user' : 'log-in'; ?>"></i> <?php echo isset($_COOKIE['NSH:member']) ? translate_button('profile') : translate_button('login'); ?></a></li>
	</ul>
</nav>