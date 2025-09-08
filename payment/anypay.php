<?php

require '../db.php';
require '../admin/rcon/rcon/rcon.php';
require_once("../libs/WebsenderAPI.php");

$way = R::findOne('connection', 'id = ?', ['1']);
$plugin = R::findOne('plugin', 'id = ?', ['1']);
$anypay = R::findOne('anypay', 'id = ?', ['1']);

$merchant_id = $anypay->shop_id;
$merchant_secret = $anypay->secret_key;
$status = 'paid';

  $arr_ip = array(
      '185.162.128.38', 
      '185.162.128.39', 
      '185.162.128.88'
  );

    if(!in_array($_SERVER['REMOTE_ADDR'], $arr_ip)){
      die("bad ip!");
  } 

  $arr_sign = array(
      $_REQUEST['currency'], 
      $_REQUEST['amount'], 
      $_REQUEST['pay_id'],
      $merchant_id,
      $status,
      $merchant_secret
  );

  $sign = hash('sha256', implode(":", $arr_sign));

  if ($sign != $_REQUEST['sign']) die('wrong sign');

  //Оплата прошла успешно, можно проводить операцию.
  $post = R::findOne('payments', 'id = ?', [$_REQUEST['pay_id']]);
  $product = R::findOne('donate', ' id = ? ', [ $post->donate_id ]);
  $post->status = "Оплачено";
  R::store($post);
  $rcon = R::findOne('rcon', ' id = ? ', [ '1' ]);
  $timeout = 3;
    $cmd = str_replace("%ИГРОК%", $post->nick, $product->cmd);
    if ($product->type == "curr") {
      $cmd = str_replace("%КОЛ%", $post->kol, $cmd);
    }
    

      $rcon1 = new Rcon($rcon->host, $rcon->port, $rcon->password, $timeout);
      
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

  die("OK");

 ?>