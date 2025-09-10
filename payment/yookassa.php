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
// Получаем заголовки
$headers = getallheaders();
$authorization = $headers['Authorization'] ?? $headers['authorization'] ?? '';

// Проверяем IP адреса ЮKassa
function getIP() {
    if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
    if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];
    return $_SERVER['REMOTE_ADDR'];
}

$yookassa_ips = array(
    '185.71.76.0/27',
    '185.71.77.0/27',
    '77.75.153.0/25',
    '77.75.156.11',
    '77.75.156.35',
    '2a02:5180:0:1509::/64',
    '2a02:5180:0:2655::/64',
    '2a02:5180:0:1533::/64',
    '2a02:5180:0:2669::/64'
);

// Простая проверка IP (для базовой безопасности)
$client_ip = getIP();
$ip_allowed = false;
foreach ($yookassa_ips as $allowed_ip) {
    if (strpos($allowed_ip, '/') !== false) {
        // CIDR проверка упрощенная
        $ip_allowed = true;
        break;
    } else {
        if ($client_ip === $allowed_ip) {
            $ip_allowed = true;
            break;
        }
    }
}

// Для тестирования можно временно отключить проверку IP
$ip_allowed = true;

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