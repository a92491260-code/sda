<?php

require '../db.php';
require '../admin/rcon/rcon/rcon.php';

$freekassa = R::findOne('freekassa', 'id = ?', ['1']);

$merchant_id = $freekassa->shop_id;
$merchant_secret = $freekassa->word2;

  function getIP() {
    if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
    return $_SERVER['REMOTE_ADDR'];
  }

  if (!in_array(getIP(), array('168.119.157.136', '168.119.60.227', '138.201.88.124', '178.154.197.79'))) header("Location: /");

  $sign = md5($merchant_id.':'.$_REQUEST['AMOUNT'].':'.$merchant_secret.':'.$_REQUEST['MERCHANT_ORDER_ID']);

  if ($sign != $_REQUEST['SIGN']) die('wrong sign');

  //Оплата прошла успешно, можно проводить операцию.
  $post = R::findOne('payments', 'nick = ? ORDER BY id DESC', [$_REQUEST['MERCHANT_ORDER_ID']]);
  $product = R::findOne('donate', ' id = ? ', [ $post->donate_id ]);
  $post->status = "Оплачено";
  R::store($post);
  $rcon = R::findOne('rcon', ' id = ? ', [ '1' ]);
  
  $timeout = 3;
  $rcon1 = new Rcon($rcon->host, $rcon->port, $rcon->password, $timeout);
    $cmd = str_replace("%ИГРОК%", $_REQUEST['MERCHANT_ORDER_ID'], $product->cmd);
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