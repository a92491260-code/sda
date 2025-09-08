<?php

require '../db.php';
$color = R::findOne('color', ' id = ? ', [ '1' ]);
$data = $_POST;
$showError = False;

if (isset($data['signin'])) {
    $errors = array();
    $showError = True;
    if (trim($data['login']) == "") {
        $errors[] = "Укажите логин.";
    } if (trim($data['password']) == "") {
        $errors[] = "Укажите пароль.";
    }

    $user = R::findOne('login', 'login = ?', array($data['login']));
    if ($user) {
        if (password_verify($data['password'], $user->password)) {
            setcookie("login", $user->login.":".$user->password, time()+3600*24);
            $user->lastlogin = date('d.m.Y в H:i');
R::store($user);            
header("Location: /admin");
        } else {
            $errors[] = "Неверный пароль.";
            
        }
    } else {
        $errors[] = "Неверный логин.";
    }
}

?>


<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">

  <!-- Менять тут -->
	<title>Вход в админ панель</title>

	<link href="css/style.css" type="text/css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
 <link rel="shortcut icon" href="img/allay.png" type="image/png">

  <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/18d0e7723d.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/main.js"></script>
  <script src="https://mcapi.us/scripts/minecraft.min.js"></script>

</head>
<body class="bg">
    
    <div class="container">
        <div class="poster <?php echo $color->color;  ?>">
            <h3 class="logo">ВХОД В АДМИН ПАНЕЛЬ</h3>
        </div>
                <div class="form"><form action="login.php" method="POST">
                    <?php
                    if ($showError) {
                        echo '<div class="pass" role="alert">
                      '.showError($errors).'
                    </div>';
                    }

                    ?>
                    <label for="login">Введите логин</label><br>
                    <input type="text" name="login" required placeholder="Логин"><br>
                    <label for="login">Введите пароль</label><br>
                    <input type="password" name="password" required placeholder="********"><br>
                    <button type="submit" name="signin" class="btn-color <?php echo $color->color;  ?>">Войти</button>
                </form></div>
    </div>

<?php
$ccolor = R::findOne('customcolor', 'id = ?', ['1']);
?>
 <?php if($color != "custom"): ?>
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