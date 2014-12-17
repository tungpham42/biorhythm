<div class="m-input-prepend">
	<span class="add-on label">Un Hashed:</span>
	<input id="unhashed" type="text" class="m-wrap" required="required">
</div>
<div class="m-input-prepend">
	<span class="add-on label">Hashed:</span>
	<input id="hashed" type="text" class="m-wrap">
</div>
<script>
$('#unhashed').change(function(){
	loadHash($(this).val());
}).keyup(function(){
	loadHash($(this).val());
});
</script>