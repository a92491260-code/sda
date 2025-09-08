<?php 
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
require 'routing.php';
require 'config.php';

$conn = mysqli_connect($host, $login, $pass, $db);

if (!isset($conn)) {
	die("Ошибка подключения к базе данных.");
}

$sql = "SELECT * FROM static";

$url = key($_GET);

$r = new Router();

$r->addRoute("/", "main.php");
$r->addRoute("/rules", "rules.php");
$r->addRoute("/donate", "donate.php");
$r->addRoute("/play", "play.php");
$r->addRoute("/oferta", "oferta.php");
$r->addRoute("/privacy", "privacy.php");
$r->addRoute("/buy", "buy.php");
$r->addRoute("/pay", "pay.php");
$r->addRoute("/succes", "succes.php");
$r->addRoute("/fail", "fail.php");
$r->addRoute("/error", "error.php");
if($result = $conn->query($sql)){
    foreach($result as $row){
    	$r->addRoute("/".$row['name'], "static".$row['page'].".php");
    }
}

$r->route("/".$url);

?>

