$(function(){
	//alert(event.timeStamp);
	$('.new-com-bt').click(function(event){
		$(this).hide();
		$('.new-com-cnt').show();
		$('#name-com').focus();
	});
	/* when start writing the comment activate the "add" button */
	$('.the-new-com').bind('input propertychange', function() {
	   $(".bt-add-com").css({opacity:0.6});
	   var checklength = $(this).val().length;
	   if(checklength){ $(".bt-add-com").css({opacity:1}); }
	});
	/* on click  on the cancel button */
	$('.bt-cancel-com').click(function(){
		$('.the-new-com').val('');
		$('.new-com-cnt').fadeOut('fast', function(){
			$('.new-com-bt').fadeIn('fast');
		});
	});
	// on post comment click 
	$('.bt-add-com').click(function(){
		var theCom = $('.the-new-com');
		var theName = $('#name-com');
		var theMail = $('#mail-com');
		if( !theCom.val()){ 
			alert('You need to write a comment!'); 
		}else{ 
			$.ajax({
				type: "POST",
				url: "triggers/add_comment.php",
				data: 'act=add-com&id_post='+window.location.pathname.substr(1)+'&name='+theName.val()+'&email='+theMail.val()+'&comment='+theCom.val(),
				success: function(html){
					theCom.val('');
					theMail.val('');
					theName.val('');
					$('.new-com-cnt').hide('fast', function(){
						$('.new-com-bt').show('fast');
						$('.new-com-bt').before(html);  
					})
				}  
			});
		}
	});
});