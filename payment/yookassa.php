<?php

require '../db.php';
require '../admin/rcon/rcon/rcon.php';

$yookassa = R::findOne('yookassa', 'id = ?', ['1']);

$shop_id = $yookassa->shop_id;
$secret_key = $yookassa->secret_key;

// Получаем данные из POST запроса
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Проверяем подпись
$signature = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
if (strpos($signature, 'Basic ') === 0) {
    $signature = substr($signature, 6);
    $decoded = base64_decode($signature);
    list($received_shop_id, $received_secret) = explode(':', $decoded, 2);
    
    if ($received_shop_id !== $shop_id || $received_secret !== $secret_key) {
        http_response_code(401);
        die('Unauthorized');
    }
} else {
    http_response_code(401);
    die('Unauthorized');
}

// Проверяем, что это уведомление об успешном платеже
if ($data['event'] !== 'payment.succeeded') {
    http_response_code(200);
    die('OK');
}

$payment_id = $data['object']['metadata']['payment_id'];
$nick = $data['object']['metadata']['nick'];

$post = R::findOne('payments', 'id = ?', [$payment_id]);
if (!$post) {
    http_response_code(404);
    die('Payment not found');
}

$product = R::findOne('donate', 'id = ?', [$post->donate_id]);
$post->status = "Оплачено";
R::store($post);

$rcon = R::findOne('rcon', 'id = ?', ['1']);
$timeout = 3;
$rcon1 = new Rcon($rcon->host, $rcon->port, $rcon->password, $timeout);

$cmd = str_replace("%ИГРОК%", $nick, $product->cmd);
if ($product->type == "curr") {
    $cmd = str_replace("%КОЛ%", $post->kol, $cmd);
}

if ($rcon1->connect()) {
    $rcon1->send_command($cmd);
}

$promo = R::findOne('promo', 'promo = ?', [$post->promo]);
if ($promo != "") {
    if ($promo->ogr == "on") {
        if ($promo->isp > 0) {
            $promo->isp = $promo->isp - 1;
            R::store($promo);
        }
    }
}

http_response_code(200);
die('OK');

?>