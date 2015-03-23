<input id="user_search" type="text" name="user_search" size="60" maxlength="128" />
<div id="admin_user">
<?php
echo list_users();
?>
</div>
<script>
$("#user_search").on({
	keyup: function(){
		$("#admin_user").load("/triggers/admin_user.php",{page:1,keyword:$("#user_search").val()});
	},
	keydown: function(){
		$("#admin_user").load("/triggers/admin_user.php",{page:1,keyword:$("#user_search").val()});
	},
	change: function(){
		$("#admin_user").load("/triggers/admin_user.php",{page:1,keyword:$("#user_search").val()});
	}
});
</script>