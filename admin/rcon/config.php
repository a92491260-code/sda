<?php
require $_SERVER['DOCUMENT_ROOT'].'/db.php';
$post12 = R::findOne('rcon', 'id = ?', ['1']);
$rconHost = $post12->host;
$rconPort = $post12->port;
$rconPassword = $post12->password;
?>
