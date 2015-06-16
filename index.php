<?php
$basepath = realpath($_SERVER['DOCUMENT_ROOT']);
$template_path = $basepath.'/templates/';
require_once $basepath.'/includes/redirect.inc.php';
require_once $basepath.'/includes/init.inc.php';
?>
<!DOCTYPE html>
<html lang="<?php echo $lang_code; ?>">
<head>
<?php
include $template_path.'head.tpl.php';
?>
</head>
<body lang="<?php echo $lang_code; ?>" class="<?php echo $body_class.(has_one_lang() ? ' one_lang': ''); ?>">
<?php
include $template_path.'variables.tpl.php';
if (!isset($_GET['p']) || $_GET['p'] == 'home'):
	include $template_path.'sitelinks_searchbox.tpl.php';
endif;
include $template_path.'img_desc.tpl.php';
include $template_path.'clicktale_top.tpl.php';
include $template_path.'fb_root.tpl.php';
if (isset($_SESSION['loggedin'])):
	include $template_path.'toolbar.tpl.php';
endif;
if (!is_birthday() && $show_ad):
	include $template_path.'adsense_top.tpl.php';
endif;
?>
	<!-- Start Header -->
	<header id="header">
		<div class="inner">
<?php
include $template_path.'header.tpl.php';
?>
		</div>
	</header>
	<!-- End Header -->
	<!-- Start Main -->
	<main id="main">
		<div id="content">
<?php
include $template_path.'router.tpl.php';
?>
		</div>
	</main>
	<!-- End Main -->
	<!-- Start Footer -->
	<footer id="footer">
		<div class="inner">
<?php
include $template_path.'footer.tpl.php';
?>
		</div>
	</footer>
	<!-- End Footer -->
	<div class="clear"></div>
<?php
include $template_path.'loading.tpl.php';
include $template_path.'to_top.tpl.php';
if (!isset($_GET['p']) && $embed == 0 || in_array($p, $navs)):
	if ($show_sumome):
		include $template_path.'sumome.tpl.php';
	endif;
	if ($show_addthis):
		include $template_path.'addthis.tpl.php';
	endif;
	if (!is_birthday() && $show_ad && (isset($_COOKIE['NSH:show_ad']) && $_COOKIE['NSH:show_ad'] == 1)):
		include $template_path.'banner_160x600.tpl.php';
	endif;
endif;
include $template_path.'clicktale_bottom.tpl.php';
include $template_path.'scripts_bottom.tpl.php';
?>
</body>
</html>
<?php
ob_end_flush();
?>