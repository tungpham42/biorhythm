<<<<<<< HEAD
<h2 id="comments_head"><?php echo translate_span('comments_head'); ?> <i class="icon-red icon-heart"></i></h2>
=======
>>>>>>> origin/master
<div id="comments" data-href="<?php echo str_replace('&', '&amp;', current_url()); ?>">
<?php
include template('fb_root');
include template('fb_comments');
include template('g_comments');
?>
</div>