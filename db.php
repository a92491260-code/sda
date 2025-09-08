<?php
require 'libs/rb.php';
require 'config.php';

R::setup("mysql:host=$host;dbname=$db", $login, $pass);
function showError($errors) {
	return array_shift($errors);
}
?>