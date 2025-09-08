<?php

require 'db.php';

$shopsettings = R::findOne('shopsettings', ' id = ? ', [ '1' ]);
$des = R::findOne('design', 'id = ?', ['1']);
$color = R::findOne('color', ' id = ? ', [ '1' ]);

$donate = R::findAll('donate');

$date = R::findOne('stats', ' date = ? ', [ date("m.d.y") ]);

if ($date) {
  $date->donate = $date->donate+1;
  $date->all = $date->all+1;
  R::store($date);
} else {
  $ss = R::dispense('stats');
  $ss->all = 1;
  $ss->main = 0;
  $ss->rules = 0;
  $ss->donate = 1;
  $ss->play = 0;
  $ss->docs = 0;
  $ss->date = date("m.d.y");
  R::store($ss);
}
$snow = R::findOne('snow', 'id = ?', ['1']);
?>
<!DOCTYPE html>
<html>
<head>
<!-- Менять тут -->
  <title><?php echo $shopsettings->name; ?> - описание доната</title>

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
  <?php $preloader = R::findOne('preloader', 'id = ?', ['1']); ?>
  <?php if ($preloader->on == "on"): ?>
<div class="<?php  echo $color->color; ?> preloader">
<div align="center" style="margin-top: 260px;">
  <h1 class="logo" style="font-size: 60px;"><?php echo $shopsettings->name; ?></h1>
  <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
</div>
</div>
<?php endif; ?>
<script>
  window.onload = function () {
    document.body.classList.add('loaded_hiding');
    window.setTimeout(function () {
      document.body.classList.add('loaded');
      document.body.classList.remove('loaded_hiding');
    }, 500);
  }
</script>
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
<script>
  window.onload = function () {
    document.body.classList.add('loaded_hiding');
    window.setTimeout(function () {
      document.body.classList.add('loaded');
      document.body.classList.remove('loaded_hiding');
    }, 500);
  }
</script>
<style type="text/css">
  @media screen and (max-width: 980px) {
    .opis {
    border-radius: 40px !important;
    padding: 40px;
    width: 100%;
    min-height: 600px !important;
  }
}
</style>
<div class="container">
  <div class="info">
  	<h1 align="center" class="logo dth" style="margin-bottom: 50px;">Описание доната</h1>
  	
    <?php foreach ($donate as $key): ?>
<div class="donate row" id="id<?php echo $key->id; ?>">
      <div class="nazv col <?php echo $color->color; ?>" >
        <h2 class="logo" align="center" ><?php echo $key->name; ?></h2>
        <h4 align="center"><?php echo $key->price; ?> <?php
                if ($key->curr == "USD") {
                  echo '<i class="fa-solid fa-dollar-sign"></i>';
                } if ($key->curr == "EUR") {
                  echo '<i class="fa-solid fa-euro-sign"></i>';
                } if ($key->curr == "UAH") {
                  echo '<i class="fa-solid fa-hryvnia-sign"></i>';
                } if ($key->curr == "KZT") {
                  echo '<i class="fa-solid fa-tenge-sign"></i>';
                } if ($key->curr == "RUB") {
                  echo '<i class="fa-solid fa-ruble-sign"></i>';
                }

              ?></h4>
              <div align="center"><img src="img/<?php echo $key->img; ?>"></div>
      </div>
      <div class="opis col-md-8" style="border-left: 0; <?php if ($des->on == "on") echo 'border: 1px solid rgba( 255, 255, 255, 0.18 );'; ?> border-top-left-radius: 0px; border-bottom-left-radius: 0px;">
        <!-- <h3>Команды:</h3>
        <p>бла бла бла бла бла бла бла <br>
        бла бла бла бла бла бла бла <br>
      бла бла бла бла бла бла бла <br>
    бла бла бла бла бла бла бла <br></p>
        <h3>Доп. возможности:</h3>
        <p>бла бла бла бла бла бла бла <br>
        бла бла бла бла бла бла бла <br>
      бла бла бла бла бла бла бла <br>
    бла бла бла бла бла бла бла <br></p>
        <h3>Регионы:</h3>
        <p>бла бла бла бла бла бла бла <br>
        бла бла бла бла бла бла бла <br>
      бла бла бла бла бла бла бла <br>
    бла бла бла бла бла бла бла <br></p> -->
    <p><?php  echo nl2br($key->text); ?></p>
    <a href="/#shop" style="color: black; text-decoration: none;"><button>Купить</button></a>
      </div>
    </div>

    <?php endforeach; ?>
    
  </div>
</div>


<div class="footer">
  <div class="row">
    <div class="col">
      <h1 class="logo list">
        <?php echo $shopsettings->name; ?>
      </h1>
      <?php if ($des->on == "on"): ?>
        <div class="new-dec <?php  echo $color->color; ?> list"></div>
      <?php endif; ?>
      <p>Copyright © <?php echo $shopsettings->name; ?> <?php echo date("Y"); ?>. Все права защищены. Сервер <?php echo $shopsettings->name; ?> не относятся к Mojang Studios.</p>
      <h5>Почта для связи: <a href="mailto:<?php echo $shopsettings->mail; ?>"><?php echo $shopsettings->mail; ?></a></h5>
    </div>
    <?php $docs = R::findOne('docs', 'id = ?', ['1']); ?>
        <?php if ($docs->on == "on"): ?>
    <div class="col">
      <h3><strong>Документы</strong></h3>
      <a href="/oferta" style="margin-top: 20px;">Договор-оферта</a><br>
      <a href="/privacy" style="margin-top: 20px;">Политика в отношении обработки персональных данных</a><br>
    </div>
  <?php endif; ?>
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