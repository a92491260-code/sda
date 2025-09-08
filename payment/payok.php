<?php

require '../db.php';
require '../admin/rcon/rcon/rcon.php';

$payok = R::findOne('payok', 'id = ?', ['1']);

$merchant_id = $payok->shop_id;
$secret = $payok->secret_key;

$ips = array("195.64.101.191", "194.124.49.173", "45.8.156.144", "5.180.194.179", "5.180.194.127", "2a0b:1580:5ad7:0dea:de47:10ae:ecbf:111a");

if(!in_array($_SERVER['REMOTE_ADDR'], $ips)){
  die("Плохой айпи");
} 

$array = array (

$secret,
$desc = $_POST['desc'],
$currency = $_POST['currency'],
$shop = $_POST['shop'],
$payment_id = $_POST['payment_id'],
$amount = $_POST['amount']

);

$sign = md5 ( implode ( '|', $array ) );

if ( $sign != $_POST[ 'sign' ] ) {
  die( 'Ошибка подписи' );
}
  $p = explode(":", $_POST['payment_id']);
 $post = R::findOne('payments', 'nick = ? ORDER BY id DESC', [$p[0]]);
  $product = R::findOne('donate', ' id = ? ', [ $post->donate_id ]);
  $post->status = "Оплачено";
  R::store($post);
  $rcon = R::findOne('rcon', ' id = ? ', [ '1' ]);
  
  $timeout = 3;
  $rcon1 = new Rcon($rcon->host, $rcon->port, $rcon->password, $timeout);
    $cmd = str_replace("%ИГРОК%", $p[0], $product->cmd);
    if ($product->type == "curr") {
      $cmd = str_replace("%КОЛ%", $post->kol, $cmd);
    }
      if($rcon1->connect()) {
    $rcon1->send_command($cmd);
  }
$promo = R::findOne('promo', ' promo = ? ', [ $post->promo ]);
  if ($promo != "") {
          if ($promo->ogr == "on") {
            if ($promo->ips > 0) {
              $promo->isp = $promo->isp-1;
              R::store($promo);
            }
          }
        }
    

  die("YES");

 ?>