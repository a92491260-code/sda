<?php

require 'db.php';

$shopsettings = R::findOne('shopsettings', ' id = ? ', [ '1' ]);
$color = R::findOne('color', ' id = ? ', [ '1' ]);
$docs = R::findOne('docs', 'id = ?', ['1']);

$privacy = R::findOne('privacy', ' id = ? ', [ '1' ]);

$date = R::findOne('stats', ' date = ? ', [ date("m.d.y") ]);

if ($date) {
  $date->docs = $date->docs+1;
  $date->all = $date->all+1;
  R::store($date);
} else {
  $ss = R::dispense('stats');
  $ss->all = 1;
  $ss->main = 0;
  $ss->rules = 0;
  $ss->donate = 0;
  $ss->play = 0;
  $ss->docs = 1;
  $ss->date = date("m.d.y");
  R::store($ss);
}

$ccolor = R::findOne('customcolor', 'id = ?', ['1']);

?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">

  <!-- Менять тут -->
	<title><?php echo $shopsettings->name; ?> - Документы</title>

	<link href="css/style.css" type="text/css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
 <link rel="shortcut icon" href="img/allay.png" type="image/png">

  <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/20556d6d52.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/main.js"></script>
  <script src="https://mcapi.us/scripts/minecraft.min.js"></script>

</head>
<body class="bg">
  <?php $preloader = R::findOne('preloader', 'id = ?', ['1']); ?>
  <?php if ($preloader->on == "on"): ?>
<div class="<?php  echo $color->color; ?> preloader">
<div align="center" style="margin-top: 260px;">
  <h1 class="logo" style="font-size: 60px;"><?php echo $shopsettings->name; ?></h1>
  <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
</div>
</div>
<?php endif; ?>
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
<script>
  window.onload = function () {
    document.body.classList.add('loaded_hiding');
    window.setTimeout(function () {
      document.body.classList.add('loaded');
      document.body.classList.remove('loaded_hiding');
    }, 500);
  }
</script>
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
<style type="text/css">
  @media screen and (max-width: 980px) {
    .dsd {
      padding-top: 200px;
    }
.dsdda {
  font-size: 40px !important;
  }
  p {
    font-size: 40px;
  }
}
</style>
<div class="container dsd">
  <div class="<?php  echo $color->color; ?> poster ">
    <h1 class="logo dsdda" style="text-transform: uppercase;">Политика в отношении обработки персональных данных</h1>

  </div>
     <p>
      <?php echo nl2br($privacy->text);  ?>
    </p>
</div>

<!-- Менять тут -->
<div class="footer">
  <div class="row">
    <div class="col">
      <h1 class="logo">
        <?php echo $shopsettings->name; ?>
      </h1>
      <p>Copyright © <?php echo $shopsettings->name; ?> <?php echo date("Y"); ?>. Все права защищены. Сервер <?php echo $shopsettings->name; ?> не относятся к Mojang Studios.</p>
      <h5>Почта для связи: <a href="mailto:<?php echo $shopsettings->mail; ?>"><?php echo $shopsettings->mail; ?></a></h5>
    </div>
    <?php if ($docs->on == "on"): ?>
    <div class="col">
      <h3><strong>Документы</strong></h3>
      <a href="/oferta" style="margin-top: 20px;">Договор-оферта</a><br>
      <a href="/privacy" style="margin-top: 20px;">Политика в отношении обработки персональных данных</a><br>
    </div>
  <?php endif; ?>
  </div>
</div>

<style type="text/css">
    <?php if($color != "custom"): ?>
<?php 

$hex1 = $ccolor->color1;
$rgb1 = sscanf($hex1, "#%02x%02x%02x");

$hex2 = $ccolor->color2;
$rgb2 = sscanf($hex2, "#%02x%02x%02x");

?>

    .custom {

          background: <?php echo $ccolor->color1; ?>;
          background: linear-gradient(141deg, rgba(<?php echo $rgb1[0].",".$rgb1[1].",".$rgb1[2]; ?>,1) 0%, rgba(<?php echo $rgb2[0].",".$rgb2[1].",".$rgb2[2]; ?>,1) 100%);
          box-shadow: 5px 5px 30px 5px rgba(<?php echo $rgb2[0].",".$rgb2[1].",".$rgb2[2]; ?>,0.3), -10px -7px 30px 1px rgba(<?php echo $rgb1[0].",".$rgb1[1].",".$rgb1[2]; ?>,0.3), 5px 5px 30px 5px rgba(0,0,0,0);
    }


<?php endif; ?>
</style>
</body>
</html>