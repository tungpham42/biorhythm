<?php
$avatar_url = get_gravatar(load_member()['email']);
$header = get_http_response_code($avatar_url);
if ($header != '404'):
?>
<img id="avatar" src="<?php echo $avatar_url; ?>" alt="avatar" />
<?php
endif;
?>