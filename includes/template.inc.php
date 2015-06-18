<?php
function template($filename) {
	return realpath($_SERVER['DOCUMENT_ROOT']).'/templates/'.$filename.'.tpl.php';
}