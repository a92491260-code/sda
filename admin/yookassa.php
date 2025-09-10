<?php

require '../config.php';
$conn = mysqli_connect($host, $login, $pass, $db);
$f = explode(':', $_COOKIE['login'], 2);
$login_to_find = $f[0];
$sql = "SELECT * FROM login WHERE login = '$login_to_find'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['id'] != 1) {
            $root_value = json_decode($row['root'], true);
            if ($root_value['root4'] == "") {
                if (isset($_COOKIE['login'])) {
                    if($_COOKIE['login'] != $row['login'].":".$row['password']){
                        header("Location: /admin/login");
                    }
                } else {
                    header("Location: /admin/login");
                }
            } 
        } 
    }
} else {
    echo "Пользователь с login '$login_to_find' не найден.";
}

require '../db.php';

$color = R::findOne('color', ' id = ? ', [ '1' ]);
$yookassa = R::findOne('yookassa', ' id = ? ', [ '1' ]);

if (!$yookassa) {
    $yookassa = R::dispense('yookassa');
    $yookassa->id = 1;
    $yookassa->shop_id = '';
    $yookassa->secret_key = '';
    R::store($yookassa);
    $yookassa = R::findOne('yookassa', ' id = ? ', [ '1' ]);
}

$data = $_POST;
$showError = False;

if (isset($data['save'])) {
    $errors = array();
    $showError = True;
    
    $yookassa->shop_id = $data['shop_id'];
    $yookassa->secret_key = $data['secret_key'];
    R::store($yookassa);
    
    $errors[] = "Настройки сохранены.";
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ЮKassa - Админ панель</title>
    <link href="css/style.css" type="text/css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="shortcut icon" href="img/allay.png" type="image/png">
    <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/18d0e7723d.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/main.js"></script>
</head>
<body class="bg">

<div class="sidenav">
    <a href="/admin" class="fffff"><i class="fa-solid fa-house"></i> Главная</a>
    <a href="/admin/settings" class="fffff"><i class="fa-solid fa-gear"></i> Настройки</a>
    <a href="/admin/donate" class="fffff"><i class="fa-solid fa-bag-shopping"></i> Донат товары</a>
    <a href="/admin/freekassa" class="fffff"><i class="fa-solid fa-credit-card"></i> FreeKassa</a>
    <a href="/admin/unitpay" class="fffff"><i class="fa-solid fa-credit-card"></i> UnitPay</a>
    <a href="/admin/enot" class="fffff"><i class="fa-solid fa-credit-card"></i> Enot.io</a>
    <a href="/admin/yookassa" class="fffff-sel"><i class="fa-solid fa-credit-card"></i> ЮKassa</a>
    <a href="/admin/payments" class="fffff"><i class="fa-solid fa-money-bill"></i> Платежи</a>
    <a href="/admin/promo" class="fffff"><i class="fa-solid fa-percent"></i> Промокоды</a>
    <a href="/admin/rules" class="fffff"><i class="fa-solid fa-scale-balanced"></i> Правила</a>
    <a href="/admin/links" class="fffff"><i class="fa-solid fa-link"></i> Соц. сети</a>
    <a href="/admin/rcon" class="fffff"><i class="fa-solid fa-terminal"></i> RCON консоль</a>
    <a href="/admin/logout" class="fffff"><i class="fa-solid fa-right-from-bracket"></i> Выход</a>
</div>

<div class="main-content">
    <div class="block">
        <h1><i class="fa-solid fa-credit-card"></i> Настройки ЮKassa</h1>
        
        <?php if ($showError): ?>
            <div class="pass" role="alert">
                <?php echo showError($errors); ?>
            </div>
        <?php endif; ?>
        
        <form action="yookassa" method="POST">
            <label for="shop_id">Shop ID (Идентификатор магазина)</label><br>
            <input type="text" name="shop_id" value="<?php echo $yookassa->shop_id; ?>" placeholder="Введите Shop ID"><br>
            
            <label for="secret_key">Секретный ключ</label><br>
            <input type="text" name="secret_key" value="<?php echo $yookassa->secret_key; ?>" placeholder="Введите секретный ключ"><br>
            
            <button type="submit" name="save" class="btn-color <?php echo $color->color; ?>">Сохранить</button>
        </form>
        
        <hr>
        
        <h3>Инструкция по настройке</h3>
        <ol>
            <li>Зарегистрируйтесь на <a href="https://yookassa.ru" target="_blank">yookassa.ru</a></li>
            <li>Войдите в личный кабинет и перейдите в раздел "Настройки" → "Магазины"</li>
            <li>Скопируйте Shop ID (идентификатор магазина)</li>
            <li>Создайте секретный ключ в разделе "Настройки" → "Ключи API"</li>
            <li>Укажите URL для уведомлений: <code><?php echo 'http://'.$_SERVER['HTTP_HOST']; ?>/payment/yookassa.php</code></li>
            <li>Сохраните настройки</li>
        </ol>
        
        <div class="alert alert-info">
            <strong>Важно:</strong> ЮKassa работает только с рублями (RUB). Убедитесь, что ваши товары настроены на рублевую валюту.
        </div>
    </div>
</div>

<?php
$ccolor = R::findOne('customcolor', 'id = ?', ['1']);
?>
<?php if($color->color == "custom"): ?>
<?php 
$hex1 = $ccolor->color1;
$rgb1 = sscanf($hex1, "#%02x%02x%02x");
$hex2 = $ccolor->color2;
$rgb2 = sscanf($hex2, "#%02x%02x%02x");
?>
<style type="text/css">
    .custom {
        background: <?php echo $ccolor->color1; ?>;
        background: linear-gradient(141deg, rgba(<?php echo $rgb1[0].",".$rgb1[1].",".$rgb1[2]; ?>,1) 0%, rgba(<?php echo $rgb2[0].",".$rgb2[1].",".$rgb2[2]; ?>,1) 100%);
        box-shadow: 5px 5px 30px 5px rgba(<?php echo $rgb2[0].",".$rgb2[1].",".$rgb2[2]; ?>,0.3), -10px -7px 30px 1px rgba(<?php echo $rgb1[0].",".$rgb1[1].",".$rgb1[2]; ?>,0.3), 5px 5px 30px 5px rgba(0,0,0,0);
    }
</style>
<?php endif; ?>

</body>
</html>