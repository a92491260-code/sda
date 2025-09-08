<?php

require 'db.php';

$shopsettings = R::findOne('shopsettings', ' id = ? ', [ '1' ]);
$snow = R::findOne('snow', 'id = ?', ['1']);
?>
<!DOCTYPE html>
<html>
<head>

<!-- Менять тут -->
  <title>Ой....</title>

  <link href="css/style.css" type="text/css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/20556d6d52.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/main.js"></script>
  <link rel="shortcut icon" href="img/favicon.png" type="image/png">
<?php if ($snow->on == "on"): ?>
    <script src="https://app.embed.im/snow.js" defer></script>
  <?php endif; ?>
</head>
<body class="bg">

<div class="menu">
  <div style="margin: auto;">
    <!-- Менять тут -->
    <?php $static = R::findAll('static'); ?>
    
    <h1 class="list logo"><?php echo $shopsettings->name; ?></h1>
    <a class="list a" href="/">Главная</a>
    <a class="list a" href="/#go">О нас</a>
    <a class="list a" href="/donate">Описание доната</a>
    <a class="list a" href="/rules">Правила</a>
    <?php foreach($static as $sta): ?>
      <a class="list a" href="/<?php echo $sta->name; ?>"><?php echo $sta->title; ?></a>
  <?php endforeach; ?>
  </div>
</div>
<div class="mobile-menu" >
  <div style="margin-bottom: 50px;" align="center">
    <!-- Менять тут -->
    <h1 class="list logo"><?php echo $shopsettings->name; ?></h1>
    <div class="burger list">
      <i class="fa-solid fa-bars"></i>
    </div>
  </div>
  <div style="margin-left: 60px; height: 100%; width: 100%;">
        <?php $static = R::findAll('static'); ?>
    <a class="list a" href="/">Главная</a><br><br>
    <a class="list a" href="/#go">О нас</a><br><br>
    <a class="list a" href="/donate">Описание доната</a><br><br>
    <a class="list a" href="/rules">Правила</a><br><br>
    <?php foreach($static as $sta): ?>
      <a class="list a" href="/<?php echo $sta->name; ?>"><?php echo $sta->title; ?></a><br><br>
  <?php endforeach; ?>
  </div>
</div>

<script type="text/javascript">
  $(function() {
    // @media only screen and (max-width: 600px)
    if (window.matchMedia("(max-width: 980px)").matches) {
      $(".mobile-menu").hide();
      $(".menu").hide();
    let numOfClicks = 0;
    $(".burger").click(function(){
                      
                      ++numOfClicks;
                      if(numOfClicks % 2 !== 0) $(".mobile-menu").show();
                      else $(".mobile-menu").hide();
                  });
    $(".chicken").hide();
    $(".adapt").removeClass("container");
    $(".tov").removeClass("col");
    $(".adapt").addClass("container-fluid");
    $(".adaptc").removeClass("col");
    $(".adapt2").removeClass("col-md-9");
    $('.gf').replaceWith(function(){
    return $("<h2 />", {html: $(this).html()});
});
    $('.fg').replaceWith(function(){
    return $("<h1 />", {html: $(this).html()});
});


    } else {
      $(".mobile-menu").hide();
    $(".mobile-menu1").hide();
    }

    
  });
</script>

<div class="mobile-menu1">
  <div style="margin: auto;" align="center">
    <!-- Менять тут -->
    <h1 class="list logo"><?php echo $shopsettings->name; ?></h1>
    <div class="burger list">
      <i class="fa-solid fa-bars"></i>
    </div>
  </div>
</div>
<div class="container" style="align-items: center; align-content: center; width: 100%; height:100%;">
  <div style="margin: 30px;" align="center">
    <img src="img/allay.png" style="margin-top: 60px;">
      <h1 class="logo" align="center" style="font-size: 60px;">
    Ошибка!
  </h1>
  <h3 align="center">
    <?php if (isset($_GET['err'])): ?>
       <?php if ($_GET['err'] == 1): ?>
        Вы уже купили этот товар.
       <?php elseif ($_GET['err'] == 2): ?>
         Ошибка подключения к серверу.
        <?php elseif ($_GET['err'] == 3): ?>
        Ошибка подключения кассы.
         <?php else: ?>
          Страница не найдена!
          <?php endif; ?>
  <?php else: ?>
    Страница не найдена!
  <?php endif; ?>
  </h3>
  </div>
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