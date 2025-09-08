<?php

require '../db.php';
require '../admin/rcon/rcon/rcon.php';

$aaio = R::findOne('aaio', 'id = ?', ['1']);
$f = R::findOne('payments', 'id = ?', [$_POST['order_id']]);

$secret = $aaio->secret_key2; // Секретный ключ №2 из настроек магазина
$amount = $f->amount; // Сумма заказа
$currency = $f->curr; // Валюта

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
  die("wrong request method");
}

if($_POST['amount'] < $amount) {
  die("wrong amount");
}

if($_POST['currency'] !== $currency) {
  die("wrong currency");
}

function getIP() {
  $ip = $_SERVER['REMOTE_ADDR'];
    
  if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
    
  if(isset($_SERVER['HTTP_X_REAL_IP'])) {
    $ip = $_SERVER['HTTP_X_REAL_IP'];
  }
  
  if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
    $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
  }

  $explode = explode(',', $ip);
    
  if(count($explode) > 1) {
    $ip = $explode[0];
  }
  
  return trim($ip);
}
  
// Проверка на IP адрес сервиса (по желанию)
$ctx = stream_context_create([
  'http' => [
          'timeout' => 10
      ]
]);

$ips = json_decode(file_get_contents('https://aaio.io/api/public/ips', false, $ctx));
if (isset($ips->list) && !in_array(getIP(), $ips->list)) {
  die("hacking attempt");
}
// Конец проверки на IP адрес сервиса

$sign = hash('sha256', implode(':', [$_POST['merchant_id'], $_POST['amount'], $_POST['currency'], $secret, $_POST['order_id']]));

if (!hash_equals($_POST['sign'], $sign)) {
  die("wrong sign");
}

$f->status = "Оплачено";
R::store($f);
$product = R::findOne('donate', ' id = ? ', [ $f->donate_id ]);
$rcon = R::findOne('rcon', ' id = ? ', [ '1' ]);
  $timeout = 3;
  $rcon1 = new Rcon($rcon->host, $rcon->port, $rcon->password, $timeout);
    $cmd = str_replace("%ИГРОК%", $f->nick, $product->cmd);
    if ($product->type == "curr") {
      $cmd = str_replace("%КОЛ%", $f->kol, $cmd);
    }
      if($rcon1->connect()) {
        $rcon1->send_command($cmd);
      }
    
    $promo = R::findOne('promo', ' promo = ? ', [ $f->promo ]);
  if ($promo != "") {
          if ($promo->ogr == "on") {
            if ($promo->ips > 0) {
              $promo->isp = $promo->isp-1;
              R::store($promo);
            }
          }
        }

die('OK');

 ?>