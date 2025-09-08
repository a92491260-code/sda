<?php

require 'db.php';

$shopsettings = R::findOne('shopsettings', ' id = ? ', [ '1' ]);
$color = R::findOne('color', ' id = ? ', [ '1' ]);
$text = R::findOne('maintext', ' id = ? ', [ '1' ]);
$o_nas = R::findOne('onas', 'id = ?', ['1']);
$socials = R::findOne('socials', 'id = ?', ['1']);
$conv = R::findOne('conv', 'id = ?', ['1']);
$donate = R::findAll('donate', 'ORDER BY list ASC');
$des = R::findOne('design', 'id = ?', ['1']);
$vers = R::findOne('serverversion', 'id = ?', ['1']);
if (!$vers) {
  $vers = false;
}

$status = json_decode(file_get_contents('https://api.mcstatus.io/v2/status/java/'.$shopsettings->ip));

$docs = R::findOne('docs', 'id = ?', ['1']);

$date = R::findOne('stats', ' date = ? ', [ date("m.d.y") ]);
$dsw = R::findOne('discord', 'id = ?', ['1']);
if ($date) {
  $date->main = $date->main+1;
  $date->all = $date->all+1;
  R::store($date);
} else {
  $ss = R::dispense('stats');
  $ss->all = 1;
  $ss->main = 1;
  $ss->rules = 0;
  $ss->donate = 0;
  $ss->play = 0;
  $ss->docs = 0;
  $ss->date = date("m.d.y");
  R::store($ss);
}

$links = R::findAll('links');

$kat = R::findAll('kategory');
$payments = R::findAll('payments', 'status = ? ORDER BY id DESC LIMIT 6', ['Оплачено']);

$ccolor = R::findOne('customcolor', 'id = ?', ['1']);
$snow = R::findOne('snow', 'id = ?', ['1']);

function wrapString($inputString, $maxLen) {
    $words = explode(' ', $inputString);
    $currentLine = '';
    $newString = '';

    foreach ($words as $word) {
        if (mb_strlen($currentLine . $word) <= $maxLen) {
            $currentLine .= $word . ' ';
        } else {
            $newString .= rtrim($currentLine) . "\n";
            $currentLine = $word . ' ';
        }
    }

    $newString .= rtrim($currentLine);

    return $newString;
}

function subtract_percent($price, $percent) {
    $proc = $price * ($percent / 100);
    return $price - $proc;
}

?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">

  <!-- Менять тут -->
	<title><?php echo $shopsettings->name; ?> - Главная</title>

	<link href="css/style.css" type="text/css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
 <link rel="shortcut icon" href="img/favicon.png" type="image/png">

  <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/20556d6d52.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/main.js"></script>
  <script src="https://mcapi.us/scripts/minecraft.min.js"></script>

  <?php if ($snow->on == "on"): ?>
    <script src="https://app.embed.im/snow.js" defer></script>
  <?php endif; ?>
</head>
<body class="bg">

<!-- 


Не обращайте внимание на гразь в коде, скоро все будет исправлено :З


 -->






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
<style type="text/css">
  @media screen and (max-width: 980px) {

    .tovars summary {
      font-size: 40px;
      
    }
    .tovars details {
      padding: 25px;
      border-radius: 30px;
      margin-bottom: 20px;
    }
    .tov {
      display: inline-block;
      margin-bottom: 10px;
      margin-top: 30px;
    }
  }
</style>

<div class="container adapt" style="color:white;">
  <div class="<?php  echo $color->color; ?> poster ">
    <div class="row">
      <div class="col chicken" style="display: flex; align-items: center; ">
        <img src="img/art.png">
      </div>
      <div class="col">
        <!-- Менять тут -->
        <h1 class="logo ssd"><?php echo $shopsettings->name; ?></h1>
        <h5><?php echo $text->text; ?></h5>
        <p><h6 class="ip m" id="ip" ><?php echo $shopsettings->ip; ?></h6> <h5 class="ico m g" onclick="copyText('ip')" style="width: 60px"><i class="fa-solid fa-copy "></i></h5></p>
        <a href="/play" style="color: black; text-decoration: none;"><button class="go" id="go">Начать играть</button></a>
      </div>
    </div>
  </div>
  <div class="info">
    <hr>
    <h1 class="logo" id="info">О нас</h1>
    <!-- Менять тут -->
    <p class="info-text-adapt"><?php echo nl2br($o_nas->text); ?>
      </p>
      <?php if(R::count('links') > 0): ?>
        <h1 class="logo">Мы в соц. сетях</h1>  
      <!-- Менять тут -->
      <?php foreach($links as $dsgf): ?>
              <a href="<?php echo $dsgf->link; ?>" class="l" target="_blank">
                <div class="social link<?php echo $dsgf->id; ?>" <?php if ($des->on == "on") echo 'style="border: 1px solid rgba( 255, 255, 255, 0.18 );
    transition: 0.25s;"'; ?>>
                  <div class="name l">
                    <h3 class="gf cl<?php echo $dsgf->id; ?>"><?php echo $dsgf->title; ?></h3><br>
                    <h2 class="fg"><?php echo $dsgf->title; ?></h2>
                  </div>
                </div>
              </a>

      <?php endforeach; ?>
      <?php endif; ?>

      <hr>
      <h1 class="logo" align="center" id="shop">Магазин</h1> 
      <!-- Менять тут -->
      
        <?php if (R::count('donate') > 0): ?>
          <div class="row">
        <div class="col tov">
          <div class="tovars" >
            <?php foreach ($kat as $k): ?>
              
                <details style=" " class="<?php if ($des->on == "on") echo "new-kat"; ?> ">
                <summary style="" class="kat"><?php echo $k->name; ?></summary>
                <div>
               <?php foreach ($donate as $don): ?>
                <?php if ($don->kategory == $k->name): ?>
                  <div class="tovar <?php if ($des->on == "on") echo "new-tovar"; ?>" id="d<?php echo $don->id; ?>" style="width: 100%; white-space: nowrap; position: relative;">
                <h5 style="margin-bottom: 15px; font-weight: 700;"><?php if ($don->sale != null or $don->sale != "-") {
                  $sl = R::findOne('sales', 'name = ?', [$don->sale]);
                  if($sl->daten <= date("Y-m-d") and $sl->datek >= date("Y-m-d")) {
                    echo '<br class="mh">'.$don->name;
                  } else {
                    echo $don->name;
                  }

                   
                } ?></h5>
                <p style="margin-bottom: 0px; "><?php if ($don->sale != null or $don->sale != "-") {
                  
                  if($sl->daten <= date("Y-m-d") and $sl->datek >= date("Y-m-d")) {
                    
                    if ($sl1->sale != 100) {
                      $result2 = subtract_percent($don->price, $sl->sale);
                    echo '<s style="opacity: 0.3;">'.$don->price.'</s> '.$result2;
                    } else {
                      echo '<s style="opacity: 0.3;">'.$don->price.'</s> 0';
                    }
                  } else {
                    echo $don->price;
                  }
                  
                } ?> <?php
                if ($don->curr == "USD") {
                  echo '<i class="fa-solid fa-dollar-sign"></i>';
                } if ($don->curr == "EUR") {
                  echo '<i class="fa-solid fa-euro-sign"></i>';
                } if ($don->curr == "UAH") {
                  echo '<i class="fa-solid fa-hryvnia-sign"></i>';
                } if ($don->curr == "KZT") {
                  echo '<i class="fa-solid fa-tenge-sign"></i>';
                } if ($don->curr == "RUB") {
                  echo '<i class="fa-solid fa-ruble-sign"></i>';
                }

              ?></p>
              <?php if($don->sale != null or $don->sale != "-"): ?>
                <?php $sl3 = R::findOne('sales', 'name = ?', [$don->sale]); ?>
                <?php if($sl3->daten <= date("Y-m-d") and $sl3->datek >= date("Y-m-d")): ?>
                  <div class="sabl"><?php echo $sl3->name; ?> -<?php echo $sl3->sale; ?>%</div>
<?php endif; ?>
              <?php endif; ?>



              </div>

              <script type="text/javascript">
                $(function() {
                  $("#d<?php echo $don->id; ?>").click(function() {
                    if (window.matchMedia("(max-width: 980px)").matches) {
                    $("#iframe").attr("src", "/buy?m=true&id=<?php echo $don->id; ?>");
                  } else {
                    $("#iframe").attr("src", "/buy?id=<?php echo $don->id; ?>");
                  }
                  });
                });
              </script>
                <?php endif; ?>
                <?php endforeach; ?>
                </div>
              </details>
                
              
            <?php endforeach; ?>

            <?php foreach ($donate as $don1): ?>
              <?php if ($don1->kategory == "Без" or $don1->kategory == NULL): ?>
                <div class="tovar <?php if ($des->on == "on") echo "new-tovar"; ?>" id="d<?php echo $don1->id; ?>" style=" white-space: nowrap; position: relative;">
                <h5 style="margin-bottom: 15px; font-weight: 700;"><?php if ($don1->sale != null or $don1->sale != "-") {
                  $sl1 = R::findOne('sales', 'name = ?', [$don1->sale]);
                  if($sl1->daten <= date("Y-m-d") and $sl1->datek >= date("Y-m-d")) {
                    echo '<br class="mh">'.$don1->name;
                  } else {
                    echo $don1->name;
                  }

                   
                } ?></h5>
                <p style="margin-bottom: 0px; "><?php if ($don1->sale != null or $don1->sale != "-") {
                  
                  if($sl1->daten <= date("Y-m-d") and $sl1->datek >= date("Y-m-d")) {
                    
                    if ($sl1->sale != 100) {
                      $result1 = subtract_percent($don1->price, $sl1->sale);
                    echo '<s style="opacity: 0.3;">'.$don1->price.'</s> '.$result1;
                    } else {
                      echo '<s style="opacity: 0.3;">'.$don1->price.'</s> 0';
                    }
                  } else {
                    echo $don1->price;
                  }
                  
                } ?> <?php
                if ($don1->curr == "USD") {
                  echo '<i class="fa-solid fa-dollar-sign"></i>';
                } if ($don1->curr == "EUR") {
                  echo '<i class="fa-solid fa-euro-sign"></i>';
                } if ($don1->curr == "UAH") {
                  echo '<i class="fa-solid fa-hryvnia-sign"></i>';
                } if ($don1->curr == "KZT") {
                  echo '<i class="fa-solid fa-tenge-sign"></i>';
                } if ($don1->curr == "RUB") {
                  echo '<i class="fa-solid fa-ruble-sign"></i>';
                }

              ?> </p>
              <?php if($don1->sale != null or $don1->sale != "-"): ?>
                <?php $sl = R::findOne('sales', 'name = ?', [$don1->sale]); ?>
                <?php if($sl->daten <= date("Y-m-d") and $sl->datek >= date("Y-m-d")): ?>
                  <div class="sabl"><?php echo $sl->name; ?> -<?php echo $sl->sale; ?>%</div>
<?php endif; ?>
              <?php endif; ?>
              </div>

              <script type="text/javascript">
                $(function() {
                  $("#d<?php echo $don1->id; ?>").click(function() {
                    $("#iframe").attr("src", "/buy?id=<?php echo $don1->id; ?>");
                  });
                });
              </script>
              <?php endif; ?>
            <?php endforeach; ?>

          </div>
        </div>
        <div class="col-md-9 adapt2" >
          <?php
$pageid = R::getCell('SELECT id FROM donate WHERE list = 1 LIMIT 1');
           ?>
           <script type="text/javascript">
             $(function(){
              if (window.matchMedia("(max-width: 980px)").matches) {
                let url = $("#iframe").attr("src");
                $("#iframe").attr("src", url+"&m=true");
              }
             });
           </script>
          <iframe src="/buy?id=<?php echo $pageid; ?>" width="100%"  id="iframe" style="border-radius: 20px;"></iframe>
        </div>

          
      </div>
    <?php else: ?>
      <br><br><br><br><h3 align="center">Пусто...</h3><br><br><br><br>
     <?php endif; ?>

<br><br><br><br><br><br><br>
      <div class="row" style="margin-top: -150px;"> 
        <div class="col">
          <h2 align="center" class="logo" style="margin-top:20px;">Онлайн на сервере</h2> 
          <div class="online <?php if ($des->on == "on") echo "new-monitor"; ?>">
            <div class="row">
              <div class="col adaptc">
                <div align="center" class="om">
                  <p><h6 class="ip m je" id="ip" style="display: inline-block; padding: 20px; padding-top: 18px;"></h6> <h5 class="ico m"  onclick="copyText('ip')" style="width: 60px"><i class="fa-solid fa-copy "></i></h5><br><span class="status">
                    <?php if ($status->online): ?>
                      Онлайн <?php echo $status->players->online." из ".$status->players->max; ?>
                    <?php else: ?>
                      Оффлайн
                    <?php endif; ?>
                  </span><br>
                  <span class="version" id="ver">
                    <?php if ($status->online and $vers != false): ?>
                      Версия <?php echo $vers->version; ?>
                    <?php endif; ?>
                  </span></p>

                  <script type="text/javascript">
                    $(function() {
                    
                    $("#ver").text($("#ver").text().replace("ВашСервер", " "));
                    });
                  </script>
                  
                </div>
              </div>
              <div class="col adaptc adaptc1">
                <div class="cycl">
                  <h3 class="logo circle-online" align="center">
                    <?php if ($status->online): ?>
                      <?php  echo $status->players->online; ?>
                    <?php else: ?>
                      -
                    <?php endif; ?>
                  </h3>
                </div>
                <div class="cycl1 <?php  echo $color->color; ?>">

                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col">
          <h2 align="center" class="logo" style="margin-top: 20px;">Последние покупки</h2>
          <div class="pok">
            <?php if (R::count('payments', 'status = ?', ['Оплачено']) > 0): ?>
              <?php foreach($payments as $yggfy): ?>
            <?php if ($yggfy->status == "Оплачено"): ?>
              <div class="pokupka <?php if ($des->on == "on") echo "new-pok"; ?>">
              <div class="skin">
                <img src="https://minotar.net/body/<?php echo $yggfy->nick; ?>/100.png" style="margin-left: 7px;">
              </div>
              <div class="sel ">
                <?php 

                $player_nick = $yggfy->nick;
                if (strlen($player_nick) > 7) {
                  $player_nick = substr($player_nick, 0, 7);
                  $player_nick = substr_replace($player_nick, "..", -2);
                }




                 ?>
                <h5 class="logo nsd" align="center"><?php echo $player_nick; ?></h5>
                <p align="center"><?php echo $yggfy->date; ?></p>
              </div>
            </div>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php else: ?>
          <br><br><br><div style="margin: auto;"><h4 align="center">Пусто...</h4></div>
        <?php endif; ?>
          </div>
        
          
        </div>
      </div>

  </div>
</div>

<!-- Менять тут -->
<div class="footer">
  <div class="row">
    <div class="col">
      <h1 class="logo list">
        <?php echo $shopsettings->name; ?>
      </h1>
      <?php if ($des->on == "on"): ?>
        <div class="new-dec <?php  echo $color->color; ?> list"></div>
      <?php endif; ?>
      <!-- <div class="list new-dec <?php  echo $color->color; ?>"></div> -->
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
  <?php if ($dsw->on == "on"): ?>
  <div class="col dis">
    <?php echo $dsw->link; ?>
  </div>
<?php endif; ?>
  </div>
</div>
<style>
  <?php foreach($links as $rgres): ?>
    .link<?php echo $rgres->id; ?>:hover .cl<?php echo $rgres->id; ?> {
      color: <?php echo $rgres->color; ?>;
      text-shadow: 0px 0px 10px <?php echo $rgres->color; ?>;
    }
  <?php endforeach; ?>
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