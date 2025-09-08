<?php
// ini_set('error_reporting', E_WARNING);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
require 'db.php';
require 'admin/rcon/rcon/rcon.php';
require_once("libs/WebsenderAPI.php");

if ($_POST['id'] == null) {
  header("Location: /");
}

if ($_POST['system'] == null) {
  header("Location: /");
}

$freekassa = R::findOne('freekassa', ' id = ? ', ['1']);
$enot = R::findOne('enot', ' id = ? ', ['1']);
$unitpay = R::findOne('unitpay', ' id = ? ', ['1']);
$yookassa = R::findOne('yookassa', ' id = ? ', ['1']);
$t = false;
$shopsettings = R::findOne('shopsettings', ' id = ? ', [ '1' ]);
$rcon = R::findOne('rcon', ' id = ? ', [ '1' ]);
$plugin = R::findOne('plugin', ' id = ? ', [ '1' ]);
$product = R::findOne('donate', ' id = ? ', [ $_POST['id'] ]);
$type = $product->type;
$promo = ($_POST['promo'] != null) ? R::findOne('promo', ' promo = ? ', [ $_POST['promo'] ]) : "";
$timeout = 3;

$rcon1 = new Rcon($rcon->host, $rcon->port, $rcon->password, $timeout);

function subtract_percent($price, $percent) {
    $proc = $price * ($percent / 100);
    return $price - $proc;
}

function getFormSignature($account, $currency, $desc, $sum, $secretKey) {
    $hashStr = $account.'{up}'.$currency.'{up}'.$desc.'{up}'.$sum.'{up}'.$secretKey;
    return hash('sha256', $hashStr);
}

function setPayment($nick1, $donate_id, $currr, $sum, $psystem, $tm, $is_promocode, $kol) {
  $post = R::dispense('payments');
  $post->nick = $nick1;
  $post->donate_id = $donate_id;
  $post->curr = $currr;
  $post->amount = $sum;
  $post->date = date("d.m.Y");
  $post->time = date("H:i");
  $post->payment_system = $psystem;
  $post->status = $tm;
  $post->promo = $is_promocode;
  if ($kol != null) {
    $post->kol = $kol;
  }
  R::store($post);
}

$nick = $_POST['nick'];
$i = false;
  if (isset($promo->ogr)) {
    if ($promo->ogr == "on") {
      if ($promo->isp <= 0) {
            $i = true;
          }
    }
  }

      if ($promo->date >= date("Y-m-d") and $i == false) {
        $promo=$promo;
      } else {
        $promo == "";
      }
    
$price = ($promo != "") ? subtract_percent($product->price, $promo->sale) : $product->price;
if ($type == "curr") {
  $price = $price * $_POST['kol'];
}
$email = ($_POST['mail'] != null) ? "&em=".$_POST['mail'] : "";
$curr = $product->curr;

$finalPrice = $price;
if ($product->on == "on") {
  if (R::count('payments', 'nick = ?', [$_POST['nick']]) > 0) {
    // Получение последней записи из таблицы по столбцу nick
    $lastRow = R::findOne('payments', 'nick = ? ORDER BY id DESC', [$_POST['nick']]);
    $product1 = R::findOne('donate', ' id = ? ', [ $lastRow->donate_id ]);
    if ($lastRow->status == "Оплачено") {
      if ($lastRow->donate_id != $_POST['id'] and $product1->price < $product->price) {
        $r = $product->price - $product1->price;
        $finalPrice = ($promo != "") ? subtract_percent($r, $promo->sale) : $r;
    } else {
        if ($product->on1 == "on") {
          $t = true;
        }
    }
    }
}
}
if ($product->sale != null or $product->sale != "-") {
  $sl1 = R::findOne('sales', 'name = ?', [$product->sale]);
  if($sl1->daten <= date("Y-m-d") and $sl1->datek >= date("Y-m-d")) {
    $finalPrice = subtract_percent($finalPrice,$sl1->sale);
  }
}


if ($freekassa == null and $enot == null and $unitpay == null and $yookassa == null) {
  header("Location: /error?err=3");
} else {
  if ($rcon1->connect()) {
    if ($t == false) {
      if ($finalPrice == 0) {
        $cmd = str_replace("%ИГРОК%", $nick, $product->cmd);
        if ($type == "curr") {
          $cmd = str_replace("%КОЛ%", $_POST['kol'], $cmd);
        }
        $rcon1->send_command($cmd);
        header("Location: /succes");
        if ($type == "curr") {
          setPayment($nick, $_POST['id'], $curr, $finalPrice, "Free", "Оплачено", $promo, $_POST['kol']); 
        } else {
          setPayment($nick, $_POST['id'], $curr, $finalPrice, "Free", "Оплачено", $promo, null); 
        }
        if ($promo != "") {
          if ($promo->ogr == "on") {
            $promo->isp = $promo->isp-1;
            R::store($promo);
          }
        }
      } else {
        if ($_POST['system'] == "freekassa") {
          $shop_id = $freekassa->shop_id;
          $word = $freekassa->word1;
          $freekassaHash = md5($shop_id.":".$finalPrice.":".$word.":".$curr.":".$nick);
          header("Location: https://pay.freekassa.ru/?m=".$shop_id."&oa=".$finalPrice."&currency=".$curr."&o=".$nick.$email."&s=".$freekassaHash);
          
          if ($type == "curr") {
          setPayment($nick, $_POST['id'], $curr, $finalPrice, "FreeKassa", "Не оплачено", $promo, $_POST['kol']); 
        } else {
          setPayment($nick, $_POST['id'], $curr, $finalPrice, "FreeKassa", "Не оплачено", $promo, null); 
        }
        }
        if ($_POST['system'] == "aaio") {
        if ($_POST['system'] == "yookassa") {
          $shop_id = $yookassa->shop_id;
          $secret_key = $yookassa->secret_key;
          
          if ($type == "curr") {
            setPayment($nick, $_POST['id'], $curr, $finalPrice, "ЮKassa", "Не оплачено", $promo, $_POST['kol']);
          } else {
            setPayment($nick, $_POST['id'], $curr, $finalPrice, "ЮKassa", "Не оплачено", $promo, null);
          }
          
          $payment_id = R::findOne('payments', 'ORDER BY id DESC');
          
          // Создание платежа через API ЮKassa
          $data = array(
            'amount' => array(
              'value' => number_format($finalPrice, 2, '.', ''),
              'currency' => 'RUB'
            ),
            'confirmation' => array(
              'type' => 'redirect',
              'return_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/succes'
            ),
            'capture' => true,
            'description' => 'Покупка товара ' . $product->name . ' для игрока ' . $nick,
            'metadata' => array(
              'payment_id' => $payment_id->id,
              'nick' => $nick
            )
          );
          
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, 'https://api.yookassa.ru/v3/payments');
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($shop_id . ':' . $secret_key),
            'Idempotence-Key: ' . uniqid()
          ));
          
          $response = curl_exec($ch);
          curl_close($ch);
          
          $payment_data = json_decode($response, true);
          
          if (isset($payment_data['confirmation']['confirmation_url'])) {
            header("Location: " . $payment_data['confirmation']['confirmation_url']);
          } else {
            header("Location: /error?err=3");
          }
        }
        if ($_POST['system'] == "unitpay") {
          $shop = $unitpay->shop_id;
          $unitsecret = $unitpay->secret_key;
          $unitpublic = $unitpay->public_key;
          $unitHash = getFormSignature($_POST['nick'], $curr, "Покупка игрового товара на ник ".$_POST['nick'], $finalPrice, $unitsecret);
          $unitmail = ($_POST['mail'] != null) ? "&customerEmail=".$_POST['mail'] : "";
          header("Location: https://unitpay.ru/pay/".$unitpublic."/".$_POST['unit_method']."?sum=".$finalPrice."&account=".$_POST['nick']."&desc=Покупка игрового товара на ник ".$_POST['nick']."&signature=".$unitHash."&currency=".$curr.$unitmail);
          
          if ($type == "curr") {
          setPayment($nick, $_POST['id'], $curr, $finalPrice, "UnitPay", "Не оплачено", $promo, $_POST['kol']);
        } else {
          setPayment($nick, $_POST['id'], $curr, $finalPrice, "UnitPay", "Не оплачено", $promo, null);
        }
        }
        if ($_POST['system'] == "enot") {
          $merchant = $enot->shop_id;
          $word1 = $enot->secret_key;
          $enotemail = ($_POST['mail'] != null) ? '"email": "'.$_POST['mail'].'",' : "";
          $enotjson = '{
          
                      "amount": '.$finalPrice.',
 "order_id": "'.$nick.'",
 
 "currency": "RUB",
                    }';
          
           if ($type == "curr") {
          setPayment($nick, $_POST['id'], $curr, $finalPrice, "Enot.io", "Не оплачено", $promo, $_POST['kol']);
        } else {
          setPayment($nick, $_POST['id'], $curr, $finalPrice, "Enot.io", "Не оплачено", $promo);
        }
        }
      }
    } else {
      header("Location: /error?err=1");
    }
  } else {
    header("Location: /error?err=2");
  }
}

?>