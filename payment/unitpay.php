<?php

require '../db.php';
require '../admin/rcon/rcon/rcon.php';

$unitpay = R::findOne('unitpay', 'id = ?', ['1']);

$shop_id = $unitpay->shop_id;
$secret = $unitpay->secret_key;


function getIP() {
    if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
    return $_SERVER['REMOTE_ADDR'];
  }

if (!in_array(getIP(), array('31.186.100.49', '52.29.152.23', '52.19.56.234'))) header("Location: /");

function getFormSignature($account, $currency, $desc, $sum, $secretKey) {
    $hashStr = $account.'{up}'.$currency.'{up}'.$desc.'{up}'.$sum.'{up}'.$secretKey;
    return hash('sha256', $hashStr);
}

if (getFormSignature($_REQUEST['account'], $_REQUEST['currency'], $_REQUEST['desc'], $_REQUEST['sum'], $_REQUEST['secretKey']) != $_REQUEST['signature']) {
	die('bad sign!');
}

$donate = $_REQUEST['account'];
  $post = R::findOne('payments', 'nick = ? ORDER BY id DESC', [$donate]);
  $product = R::findOne('donate', ' id = ? ', [ $post->donate_id ]);
  $post->status = "Оплачено";
  R::store($post);
  $rcon = R::findOne('rcon', ' id = ? ', [ '1' ]);
  $timeout = 3;
  $rcon1 = new Rcon($rcon->host, $rcon->port, $rcon->password, $timeout);
    $cmd = str_replace("%ИГРОК%", $_REQUEST['account'], $product->cmd);
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

?>