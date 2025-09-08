<?php 

require '../db.php';
require '../admin/rcon/rcon/rcon.php';

$enot = R::findOne('enot', 'id = ?', ['1']);

$shop_id = $enot->shop_id;
$secret_word2 = $enot->secret_key2;


$sign = md5($shop_id.':'.$_REQUEST['amount'].':'.$secret_word2.':'.$_REQUEST['merchant_id']);
 
if ($sign != $_REQUEST['sign_2']) {
    die('bad sign!');
}
echo "Good";

  $donate = $_REQUEST['merchant_id'];
  $post = R::findOne('payments', 'nick = ? ORDER BY id DESC', [$donate]);
  $product = R::findOne('donate', ' id = ? ', [ $post->donate_id ]);
  $post->status = "Оплачено";
  R::store($post);
  $rcon = R::findOne('rcon', ' id = ? ', [ '1' ]);
  $timeout = 3;
  $rcon1 = new Rcon($rcon->host, $rcon->port, $rcon->password, $timeout);
    $cmd = str_replace("%ИГРОК%", $_REQUEST['merchant_id'], $product->cmd);
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

 header("Location: /");

?>