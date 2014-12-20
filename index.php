<?php
$basepath = realpath($_SERVER['DOCUMENT_ROOT']);
$template_path = $basepath.'/templates/';
require_once $basepath.'/includes/init.inc.php';
?>
<!DOCTYPE html>
<html lang="<?php echo init_lang_code(); ?>">
<head>
<?php
include $template_path.'head.tpl.php';
?>
</head>
<body lang="<?php echo init_lang_code(); ?>" class="<?php echo $body_class; ?>">
<?php
include $template_path.'img_desc.tpl.php';
include $template_path.'clicktale_top.tpl.php';
if (isset($_SESSION['loggedin'])):
	include $template_path.'toolbar.tpl.php';
endif;
if (!is_birthday() && $show_ad):
	include $template_path.'adsense_top.tpl.php';
endif;
?>
	<div id="page_section">
		<!-- Start Header -->
		<header id="header">
<?php
include $template_path.'header.tpl.php';
?>
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
<?php
include $template_path.'footer.tpl.php';
?>
		</footer>
		<!-- End Footer -->
		<div class="clear"></div>
	</div>
<?php
include $template_path.'loading.tpl.php';
if (!isset($_GET['p']) && $embed == 0 || in_array($p, $navs)):
	include $template_path.'addthis.tpl.php';
	if (!is_birthday() && $show_ad):
		include $template_path.'banner_160x600.tpl.php';
	endif;
endif;
include $template_path.'clicktale_bottom.tpl.php';
include $template_path.'scripts_bottom.tpl.php';
?>
</body>
</html>