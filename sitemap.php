<?php
header('Content-type: application/xml');
header('Pragma: public');
header('Cache-Control: private');
header('Expires: -1');
require realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init.inc.php';
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
	<url>
		<loc>http://<?php echo $_SERVER['SERVER_NAME']; ?>/</loc>
		<xhtml:link rel="alternate" hreflang="vi" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','vi'); ?>"/>
		<xhtml:link rel="alternate" hreflang="en" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','en'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ru" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','ru'); ?>"/>
		<xhtml:link rel="alternate" hreflang="es" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','es'); ?>"/>
		<xhtml:link rel="alternate" hreflang="zh" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','zh'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ja" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','ja'); ?>"/>
		<changefreq>monthly</changefreq>
		<priority>0.8</priority>
	</url>
	<url>
		<loc>http://<?php echo $_SERVER['SERVER_NAME']; ?>/?lang=vi</loc>
		<xhtml:link rel="alternate" hreflang="en" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','en'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ru" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','ru'); ?>"/>
		<xhtml:link rel="alternate" hreflang="es" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','es'); ?>"/>
		<xhtml:link rel="alternate" hreflang="zh" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','zh'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ja" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','ja'); ?>"/>
		<xhtml:link rel="alternate" hreflang="vi" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','vi'); ?>"/>
		<changefreq>monthly</changefreq>
		<priority>0.8</priority>
	</url>
	<url>
		<loc>http://<?php echo $_SERVER['SERVER_NAME']; ?>/?lang=en</loc>
		<xhtml:link rel="alternate" hreflang="vi" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','vi'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ru" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','ru'); ?>"/>
		<xhtml:link rel="alternate" hreflang="es" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','es'); ?>"/>
		<xhtml:link rel="alternate" hreflang="zh" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','zh'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ja" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','ja'); ?>"/>
		<xhtml:link rel="alternate" hreflang="en" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','en'); ?>"/>
		<changefreq>monthly</changefreq>
		<priority>0.8</priority>
	</url>
	<url>
		<loc>http://<?php echo $_SERVER['SERVER_NAME']; ?>/?lang=ru</loc>
		<xhtml:link rel="alternate" hreflang="vi" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','vi'); ?>"/>
		<xhtml:link rel="alternate" hreflang="en" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','en'); ?>"/>
		<xhtml:link rel="alternate" hreflang="es" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','es'); ?>"/>
		<xhtml:link rel="alternate" hreflang="zh" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','zh'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ja" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','ja'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ru" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','ru'); ?>"/>
		<changefreq>monthly</changefreq>
		<priority>0.8</priority>
	</url>
	<url>
		<loc>http://<?php echo $_SERVER['SERVER_NAME']; ?>/?lang=es</loc>
		<xhtml:link rel="alternate" hreflang="vi" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','vi'); ?>"/>
		<xhtml:link rel="alternate" hreflang="en" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','en'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ru" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','ru'); ?>"/>
		<xhtml:link rel="alternate" hreflang="zh" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','zh'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ja" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','ja'); ?>"/>
		<xhtml:link rel="alternate" hreflang="es" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','es'); ?>"/>
		<changefreq>monthly</changefreq>
		<priority>0.8</priority>
	</url>
	<url>
		<loc>http://<?php echo $_SERVER['SERVER_NAME']; ?>/?lang=zh</loc>
		<xhtml:link rel="alternate" hreflang="vi" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','vi'); ?>"/>
		<xhtml:link rel="alternate" hreflang="en" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','en'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ru" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','ru'); ?>"/>
		<xhtml:link rel="alternate" hreflang="es" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','es'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ja" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','ja'); ?>"/>
		<xhtml:link rel="alternate" hreflang="zh" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','zh'); ?>"/>
		<changefreq>monthly</changefreq>
		<priority>0.8</priority>
	</url>
	<url>
		<loc>http://<?php echo $_SERVER['SERVER_NAME']; ?>/?lang=ja</loc>
		<xhtml:link rel="alternate" hreflang="vi" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','vi'); ?>"/>
		<xhtml:link rel="alternate" hreflang="en" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','en'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ru" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','ru'); ?>"/>
		<xhtml:link rel="alternate" hreflang="es" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','es'); ?>"/>
		<xhtml:link rel="alternate" hreflang="zh" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','zh'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ja" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/','ja'); ?>"/>
		<changefreq>monthly</changefreq>
		<priority>0.8</priority>
	</url>
	<url>
		<loc>http://<?php echo $_SERVER['SERVER_NAME']; ?>/bmi</loc>
		<changefreq>monthly</changefreq>
		<priority>0.8</priority>
	</url>
	<url>
		<loc>http://<?php echo $_SERVER['SERVER_NAME']; ?>/xemngay</loc>
		<changefreq>monthly</changefreq>
		<priority>0.8</priority>
	</url>
	<url>
		<loc>http://<?php echo $_SERVER['SERVER_NAME']; ?>/game</loc>
		<changefreq>monthly</changefreq>
		<priority>0.8</priority>
	</url>
	<url>
		<loc>http://<?php echo $_SERVER['SERVER_NAME']; ?>/blog</loc>
		<changefreq>monthly</changefreq>
		<priority>0.8</priority>
	</url>
	<url>
		<loc>http://<?php echo $_SERVER['SERVER_NAME']; ?>/?p=bmi</loc>
		<changefreq>monthly</changefreq>
		<priority>0.8</priority>
	</url>
	<url>
		<loc>http://<?php echo $_SERVER['SERVER_NAME']; ?>/?p=lunar</loc>
		<changefreq>monthly</changefreq>
		<priority>0.8</priority>
	</url>
	<url>
		<loc>http://<?php echo $_SERVER['SERVER_NAME']; ?>/?p=pong</loc>
		<changefreq>monthly</changefreq>
		<priority>0.8</priority>
	</url>
	<url>
		<loc>http://<?php echo $_SERVER['SERVER_NAME']; ?>/?p=race</loc>
		<changefreq>monthly</changefreq>
		<priority>0.8</priority>
	</url>
<?php
$users = load_all_array('nsh_users');
usort($users,'sort_name_ascend');
$count = count($users);
for ($i = 0; $i < $count; $i++):
?>
	<url>
		<loc>http://<?php echo $_SERVER['SERVER_NAME']; ?>/?fullname=<?php echo str_replace(' ','+',$users[$i]['name']); ?>&amp;dob=<?php echo $users[$i]['dob']; ?></loc>
		<xhtml:link rel="alternate" hreflang="vi" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'vi'); ?>"/>
		<xhtml:link rel="alternate" hreflang="en" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'en'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ru" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'ru'); ?>"/>
		<xhtml:link rel="alternate" hreflang="es" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'es'); ?>"/>
		<xhtml:link rel="alternate" hreflang="zh" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'zh'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ja" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'ja'); ?>"/>
		<changefreq>monthly</changefreq>
		<priority>0.8</priority>
	</url>
	<url>
		<loc>http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'vi'); ?></loc>
		<xhtml:link rel="alternate" hreflang="en" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'en'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ru" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'ru'); ?>"/>
		<xhtml:link rel="alternate" hreflang="es" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'es'); ?>"/>
		<xhtml:link rel="alternate" hreflang="zh" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'zh'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ja" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'ja'); ?>"/>
		<xhtml:link rel="alternate" hreflang="vi" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'vi'); ?>"/>
		<changefreq>monthly</changefreq>
		<priority>0.8</priority>
	</url>
	<url>
		<loc>http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'en'); ?></loc>
		<xhtml:link rel="alternate" hreflang="vi" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'vi'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ru" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'ru'); ?>"/>
		<xhtml:link rel="alternate" hreflang="es" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'es'); ?>"/>
		<xhtml:link rel="alternate" hreflang="zh" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'zh'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ja" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'ja'); ?>"/>
		<xhtml:link rel="alternate" hreflang="en" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'en'); ?>"/>
		<changefreq>monthly</changefreq>
		<priority>0.8</priority>
	</url>
	<url>
		<loc>http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'ru'); ?></loc>
		<xhtml:link rel="alternate" hreflang="vi" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'vi'); ?>"/>
		<xhtml:link rel="alternate" hreflang="en" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'en'); ?>"/>
		<xhtml:link rel="alternate" hreflang="es" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'es'); ?>"/>
		<xhtml:link rel="alternate" hreflang="zh" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'zh'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ja" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'ja'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ru" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'ru'); ?>"/>
		<changefreq>monthly</changefreq>
		<priority>0.8</priority>
	</url>
	<url>
		<loc>http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'es'); ?></loc>
		<xhtml:link rel="alternate" hreflang="vi" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'vi'); ?>"/>
		<xhtml:link rel="alternate" hreflang="en" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'en'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ru" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'ru'); ?>"/>
		<xhtml:link rel="alternate" hreflang="zh" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'zh'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ja" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'ja'); ?>"/>
		<xhtml:link rel="alternate" hreflang="es" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'es'); ?>"/>
		<changefreq>monthly</changefreq>
		<priority>0.8</priority>
	</url>
	<url>
		<loc>http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'zh'); ?></loc>
		<xhtml:link rel="alternate" hreflang="vi" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'vi'); ?>"/>
		<xhtml:link rel="alternate" hreflang="en" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'en'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ru" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'ru'); ?>"/>
		<xhtml:link rel="alternate" hreflang="es" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'es'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ja" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'ja'); ?>"/>
		<xhtml:link rel="alternate" hreflang="zh" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'zh'); ?>"/>
		<changefreq>monthly</changefreq>
		<priority>0.8</priority>
	</url>
	<url>
		<loc>http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'ja'); ?></loc>
		<xhtml:link rel="alternate" hreflang="vi" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'vi'); ?>"/>
		<xhtml:link rel="alternate" hreflang="en" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'en'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ru" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'ru'); ?>"/>
		<xhtml:link rel="alternate" hreflang="es" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'es'); ?>"/>
		<xhtml:link rel="alternate" hreflang="zh" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'zh'); ?>"/>
		<xhtml:link rel="alternate" hreflang="ja" href="http://<?php echo change_url_lang($_SERVER['SERVER_NAME'].'/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'],'ja'); ?>"/>
		<changefreq>monthly</changefreq>
		<priority>0.8</priority>
	</url>
<?php
endfor;
?>
</urlset>