<?php

require 'db.php';

$d = R::findAll('donate');

foreach ($d as $key) {
	$key->list = 1;
	R::store($key);
}



echo "Успешно";

?>