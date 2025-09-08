<?php

require 'db.php';

if ($_GET['id'] == null) {
  header("Location: /");
}

$shopsettings = R::findOne('shopsettings', ' id = ? ', [ '1' ]);
$color = R::findOne('color', ' id = ? ', [ '1' ]);
$des = R::findOne('design', 'id = ?', ['1']);
$donate = R::findOne('donate', ' id = ? ', [$_GET['id']]);
$opis = R::findOne('opis', 'id = ?', ['1']);
$obj = R::findOne('obj', ' id = ? ', [ '1' ]);

$promo = R::findAll('promo');

$freekassa = R::findOne('freekassa', ' id = ? ', ['1']);
$enot = R::findOne('enot', ' id = ? ', ['1']);
$unitpay = R::findOne('unitpay', ' id = ? ', ['1']);
$anypay = R::findOne('anypay', ' id = ? ', ['1']);
$payok = R::findOne('payok', ' id = ? ', ['1']);
$aaio = R::findOne('aaio', ' id = ? ', ['1']);

$ccolor = R::findOne('customcolor', 'id = ?', ['1']);
$conv = R::findOne('curr', 'id = ?', ['1']);

function subtract_percent($price, $percent) {
    $proc = $price * ($percent / 100);
    return $price - $proc;
}

?>
<!DOCTYPE html>
<html>
<head>

<!-- Менять тут -->
  <title>Донат</title>

  <link href="css/style.css" type="text/css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/20556d6d52.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <link rel="shortcut icon" href="img/favicon.png" type="image/png">

</head>
<body class="bg" style="color: white;">
<style type="text/css">
  <?php if($_GET['m'] == true): ?>
    img {
    height: 100px;
  }
  .donate-name {
    font-size: 40px;
  }
  .buy1 {
    padding: 40px;
    border-radius: 30px;
  }
  .salebuy {
    font-size: 30px !important;
    padding: 5px 20px !important;
    border-radius: 20px !important;
  }
  #res {
    font-size: 30px;
  }
  .donate-price {
    margin-bottom: 0px;
  }
  select {
    font-size: 30px;
    border-radius: 20px !important;
    margin-top: 45px !important;
  }
  .buy {
    border-radius: 30px;
    padding: 60px;
  }
  .pass {
    font-size: 30px;
    padding: 20px;
    border-radius: 20px;
  }
  .moredbtn {
    font-size: 30px;
  }
  h3 {
    font-size: 40px;
  }
  label {
    font-size: 25px;
  }
  input {
    font-size: 30px;
    width: 80%;
  }
  #paycheck {
    font-size: 25px;
  }
  #buyg {
    font-size: 30px !important;
    display: inline-block !important;
  }
  h4 {
    font-size: 50px;
  }
  .va i {
    font-size: 30px;
  }
  <?php else: ?>
  img {
    height: 90px;
  }
  
  
<?php endif; ?>
.salebuy {
    display: inline-block; padding: 2px 10px; color: white; border-radius: 12px; background: rgba( 210, 38, 38, 0.55 );
backdrop-filter: blur( 12px );
-webkit-backdrop-filter: blur( 12px ); font-size: 20px; transform: translateY(-2px);
  }
</style>
<div style="margin: 30px;">
  <div class="buy1 <?php  echo $color->color; ?>">
            <div class="row">
              <?php if ($donate->img != NULL): ?>
              <div class="col">
                <div style="margin:auto; height: 95%; width: 95%;">
                  
                    <div align="center">
                      <img src="img/<?php echo $donate->img; ?>" style=" margin: auto;">
                    </div>
                  
                </div>
              </div>
              <?php endif; ?>
              <div class="col-md-10">
                <div class="row">
                  <div class="col">

                    <h1><strong class="donate-name"><?php echo $donate->name; ?> <?php if ($donate->sale != null or $donate->sale != "-") {
                      $sl3 = R::findOne('sales', 'name = ?', [$donate->sale]);
                      if ($sl3->daten <= date("Y-m-d") and $sl3->datek >= date("Y-m-d")) {
                        echo '<div class="salebuy">-'.$sl3->sale.'%</div>';
                      }
                    } ?></strong></h1>
                <p class="donate-price"><span id="res"><?php if ($donate->sale != null or $donate->sale != "-") {
                  if ($sl3->daten <= date("Y-m-d") and $sl3->datek >= date("Y-m-d")) {
                    if ($sl3->sale != 100) {
                      $result1 = subtract_percent($donate->price, $sl3->sale);
                    echo '<s style="opacity: 0.5;">'.$donate->price.'</s> '.$result1;
                    } else {
                      echo '<s style="opacity: 0.5;">'.$donate->price.'</s> 0';
                    }                 } else {
                  echo $donate->price;
                }
                }  ?></span> <span class="va"><?php
                if ($donate->curr == "USD") {
                  echo '<i class="fa-solid fa-dollar-sign"></i>';
                } if ($donate->curr == "EUR") {
                  echo '<i class="fa-solid fa-euro-sign"></i>';
                } if ($donate->curr == "UAH") {
                  echo '<i class="fa-solid fa-hryvnia-sign"></i>';
                } if ($donate->curr == "KZT") {
                  echo '<i class="fa-solid fa-tenge-sign"></i>';
                } if ($donate->curr == "RUB") {
                  echo '<i class="fa-solid fa-ruble-sign"></i>';
                }

              ?></span></p>
                  </div>
                  <?php if ($conv->on == "on"): ?>
                    <div class="col">
                    <select style="outline: none; background-color: white; border: 0; border-radius: 10px; padding: 10px 20px; float: right; margin-top: 25px;" id="curr">
                      <option value="USD" <?php if ($donate->curr == "USD") echo "selected"; ?>>USD</option>
                      <option value="EUR" <?php if ($donate->curr == "EUR") echo "selected"; ?>>EUR</option>
                      <option value="UAH" <?php if ($donate->curr == "UAH") echo "selected"; ?>>UAH</option>
                      <option value="KZT" <?php if ($donate->curr == "KZT") echo "selected"; ?>>KZT</option>
                      <option value="RUB" <?php if ($donate->curr == "RUB") echo "selected"; ?>>RUB</option>
                    </select>
                  </div>

                  <script type="text/javascript">
                    $(function(){
                      
                      $( "#curr" ).on( "change", function() {
                        var b = <?php echo $donate->price; ?>;
                        const apiKey = '05d57f263d094106bcae73c98a79ab91';


// Замените 'USD' на нужный вам валютный код
const baseCurrency = '<?php echo $donate->curr; ?>';

// Замените 'EUR' на нужный вам валютный код
const targetCurrency = $("#curr").val();

// Формирование URL для запроса
const url = `https://openexchangerates.org/api/latest.json?app_id=${apiKey}&base=${baseCurrency}`;

// Отправка HTTP-запроса и получение ответа
fetch(url)
  .then(response => response.json())
  .then(data => {
    // Получение курса валюты
    const exchangeRate = data.rates[targetCurrency]*b;
    const roundedSum = exchangeRate.toFixed(1);
    $("#res").text(roundedSum);
    if (targetCurrency == "USD") {
      $(".va").html('<i class="fa-solid fa-dollar-sign"></i>');
    } if (targetCurrency == "EUR") {
      $(".va").html('<i class="fa-solid fa-euro-sign"></i>');
    } if (targetCurrency == "UAH") {
        $(".va").html('<i class="fa-solid fa-hryvnia-sign"></i>');
    } if (targetCurrency == "KZT") {
        $(".va").html('<i class="fa-solid fa-tenge-sign"></i>');
    } if (targetCurrency == "RUB") {
      $(".va").html('<i class="fa-solid fa-ruble-sign"></i>');
    }
  })
  .catch(error => {
    console.log('Произошла ошибка при получении курса валюты:', error);
  });
                      } );
                    });
                  </script>
                  <?php endif; ?>
                </div>
              </div> 
            </div>
          </div>
<!-- Менять тут -->
          <div class="buy <?php if ($des->on == "on") echo "new-buy"; ?>">
            <?php if ($obj): ?>
              <div class="pass" role="alert">
  <i class="fa-sharp fa-solid fa-circle-exclamation"></i> <?php echo $obj->text; ?>
</div>
            <?php endif; ?>
            <?php if ($opis->on == "on"): ?>
              <p class="donate-text" ><?php echo nl2br($donate->text); ?></p>
            <?php else: ?>
              <a style="text-decoration: none;" target="_parent" href="/donate#id<?php echo $_GET['id']; ?>"><button style="color: black; border-radius: 15px; display: inline-block; padding: 5px 20px; font-weight: 500;" class="moredbtn">Описание доната</button></a>
            <?php endif; ?>
            <h3>Введите данные</h3>
            <form method="POST" action="/pay">
              <label style="margin-top: 0px;"><i class="fa-solid fa-user"></i> Ник</label><br>
              <input type="text" name="nick" class="nick" placeholder="Введите ваш ник" required><br>

              <?php if ($donate->type == "curr"): ?>
              <label><i class="fa-solid fa-bag-shopping"></i> Количество товара</label><br>
              <input type="number" name="kol" class="kolv" id="kolv" placeholder="Введите кол-во товара" required value="1"><br>
              <script type="text/javascript">
                $(function() {
                  $("#kolv").on("input", function () {
                    if ($(this).val() <= 0) {
                      $(this).val(1);
                    }
                  });
                });
              </script>
              <?php endif; ?>

              <label><i class="fa-solid fa-tag"></i> Промокод</label><br>
              <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
              <input type="text" id="promo" name="promo" placeholder="Введите промокод (если есть)"><br>
              <span id="text-result"></span><br>
              <span style="cursor: pointer; transition: 0.35s;" id="paycheck"><i class="fa-solid fa-receipt"></i> Нажмите, если нужен чек</span><br>

              <div class="email">
                <br>
                <label style="margin-top: 0px;"><i class="fa-solid fa-envelopes-bulk"></i> Почта</label><br>
                <input type="email" name="mail" placeholder="Введите вашу почту" ><br>
              </div>


              <style type="text/css">
                #paycheck:hover {
                  color: #ccc;
                }
              </style>
              <script type="text/javascript">
                $(function() {
                  let numOfClicks = 0;
                  var y = false;
                  $(".email").hide();
                  $("#paycheck").click(function(){
                      $(".email").show();
                      ++numOfClicks;
                      if(numOfClicks % 2 !== 0) $(".email").show();
                      else $(".email").hide();
                  });


                  $("#promo").keyup(function () {
                    var val =$(this).val();
                      

                    var url = "scripts/promo?promo=" + val;
                     $.get(url, function(data) {
                      var parts = data.split(" ");
                      if (val != "") {
                        if (parts[0] == "true") {
                          $("#text-result").html("<br>Промокод активирован. Скидка "+parts[1]+"%<br>");
                          $("#text-result").css("color", "green");
                          document.getElementById("buyg").disabled = false; 
                          y = false;
                        } if (data == "false") {
                          $("#text-result").html("<br>Промокод не найден<br>");
                          $("#text-result").css('color', 'red');
                          document.getElementById("buyg").disabled = true;
                          y = true;
                        }
                      }
                    });

                    
                        if (val == "") {
document.getElementById("buyg").disabled = false; 
$("#text-result").html("");
y = false;
                      } 
 
                  });
                  $("#buyg").click(function() {
      if (y == false) {
        $(".dialog1").show();
      }
    });
                });
              </script>
              <input type="hidden" name="system" id="sis">
              <input type="hidden" name="unit_method" id="unit_method">
              <div id="buyg" style="background-color: white; color: black; padding: 5px; border-radius: 40px; cursor: pointer; padding-left: 40px; padding-right: 40px; display: inline-block !important; margin-top: 20px;">Купить</div>
              

<script type="text/javascript">
  $(function() {
    $(".dialog1").hide();
    $(".dialog2").hide();

    $("#free").click(function() {
      $("#sis").val("freekassa");
    });
    $("#unit").click(function() {
      $("#sis").val("unitpay");
      $(".dialog1").hide();
      $(".dialog2").show();
    });
    $("#enot").click(function() {
      $("#sis").val("enot");
    });
    $("#anypay").click(function() {
      $("#sis").val("anypay");
    });
    $("#payok").click(function() {
      $("#sis").val("payok");
    });
    $("#aaio").click(function() {
      $("#sis").val("aaio");
    });
    $("#close").click(function() {
      $(".dialog1").hide();
      $(".dialog2").hide();
    });
    $("#close1").click(function() {
      $(".dialog1").hide();
      $(".dialog2").hide();
    });



    $(".card").click(function() {
      $("#unit_method").val("card");
    });
$(".qiwi").click(function() {
      $("#unit_method").val("qiwi");
    });
$(".ap").click(function() {
      $("#unit_method").val("applepay");
    });
$(".gp").click(function() {
      $("#unit_method").val("googlepay");
    });
$(".wmz").click(function() {
      $("#unit_method").val("webmoney");
    });

  $(".as").click(function(){
    if($(".nick").val() == "") {
      $(".dialog1").hide();
      $(".dialog2").hide();
    }
  });

  });
</script>

<div class="dialog1">
  <div style="margin-bottom: 0px; background: rgba( 50, 50, 50, 1 );
  backdrop-filter: blur( 15px );
  -webkit-backdrop-filter: blur( 15px );
  border-top-left-radius: 20px; border-top-right-radius: 20px; padding: 30px;" class="vvef">
    <h4 align="center" class="logo" style="">Выберите способ оплаты</h4>
  </div>
  <div style="margin-top: 0px; background-color: rgba( 50, 50, 50, 0.7); border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; padding: 30px;">

    <?php if ($freekassa != null): ?>

    <button id="free" class="as" formtarget="_parent" type="submit" style="width: 100%; background-color: white; border-radius: 15px; padding: 0px; margin-top: 0px; margin-bottom: 10px; border: 0;"><img src="img/free.jpg" style="height: 50px;"></button>
  <?php endif; ?>
<?php if ($unitpay != null): ?>

    <div id="unit" class="as" style="width: 100%; background-color: white; border-radius: 15px; padding: 0px; margin-top: 0px; margin-bottom: 10px; border: 0; cursor: pointer;"><img src="img/unit.jpg" style="height: 50px;"></div>
      <?php endif; ?>
<?php if ($enot != null): ?>
    <button id="enot" class="as" formtarget="_parent" type="submit" style="width: 100%; background-color: white; border-radius: 15px; padding: 0px; margin-top: 0px; border: 0;"><img src="img/enot.jpg" style="height: 50px;"></button>

  <?php endif; ?>

  <?php if ($anypay != null): ?>
    <button id="anypay" class="as" formtarget="_parent" type="submit" style="width: 100%; background-color: white; border-radius: 15px; padding: 0px; margin-top: 10px; border: 0; margin-bottom: 10px;"><img src="img/any.jpg" style="height: 50px;"></button>

  <?php endif; ?>
  <?php if ($payok != null): ?>
    <button id="payok" class="as" formtarget="_parent" type="submit" style="width: 100%; background-color: white; border-radius: 15px; padding: 0px; margin-top: 0px; border: 0; margin-bottom: 15px;"><img src="img/payok.jpg" style="height: 45px; margin-top: 5px;"></button>

  <?php endif; ?>
  <?php if ($aaio != null): ?>
    <button id="aaio" class="as" formtarget="_parent" type="submit" style="width: 100%; background-color: white; border-radius: 15px; padding: 0px; margin-top: 0px; border: 0; margin-bottom: 15px;"><img src="img/aaio.jpg" style="height: 45px; margin-top: 5px;"></button>

  <?php endif; ?>

  <?php if ($freekassa == null and $enot == null and $unitpay == null and $anypay == null and $payok == null and $aaio == null): ?>
    <br><h5 align="center">Пусто...</h5><br><br>
  <?php endif; ?>

    <div id="close" style="width: 100%; background-color: red; border-radius: 15px; padding: 0px; margin-top: 0px; border: 0; padding: 10px; margin-top: 10px; color: #FFF; cursor: pointer;">Закрыть</div>
  </div>
</div>


<div class="dialog2">
  <div style="margin-bottom: 0px; background: rgba( 50, 50, 50, 1 );
  backdrop-filter: blur( 15px );
  -webkit-backdrop-filter: blur( 15px );
  border-top-left-radius: 20px; border-top-right-radius: 20px; padding: 30px;">
    <h4 align="center" class="logo" style="">Выберите способ оплаты</h4>
  </div>
  <div style="margin-top: 0px; background-color: rgba( 50, 50, 50, 0.7); border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; padding: 30px;">

      <button class="card as" formtarget="_parent" type="submit" style="width: 100%; background-color: white; border-radius: 15px; padding: 10px; margin-top: 0px; margin-bottom: 10px; border: 0;"><img src="img/card.svg" style="height: 60px; margin: auto;"></button>
      <button class="qiwi as" formtarget="_parent" type="submit" style="width: 100%; background-color: white; border-radius: 15px; padding: 10px; margin-top: 0px; margin-bottom: 10px; border: 0;"><img src="img/qiwi.svg" style="height: 30px;"></button>
      <button class="gp as" formtarget="_parent" type="submit" style="width: 100%; background-color: white; border-radius: 15px; padding: 10px; margin-top: 0px; margin-bottom: 10px; border: 0;"><img src="img/googlepay.svg" style="height: 30px;"></button>
      <button class="ap as" formtarget="_parent" type="submit" style="width: 100%; background-color: white; border-radius: 15px; padding: 10px; margin-top: 0px; margin-bottom: 10px; border: 0;"><img src="img/applepay.svg" style="height: 30px;"></button>
      <button class="wmz as" formtarget="_parent" type="submit" style="width: 100%; background-color: white; border-radius: 15px; padding: 10px; margin-top: 0px; margin-bottom: 10px; border: 0;"><img src="img/wmz.svg" style="height: 30px;"></button>
      <br><br>
    <div id="close1" style="width: 100%; background-color: red; border-radius: 15px; padding: 0px; margin-top: 0px; border: 0; padding: 10px; margin-top: 10px; color: #FFF; cursor: pointer;">Закрыть</div>
  </div>
</div>





            </form>
          </div>
</div>

<style type="text/css">
  .dialog1 {
/*    visibility: hidden;*/
position: absolute;
left: 0;
top: 0;
width: 50%;
padding: 40px;
text-align: center;
position: fixed;
z-index: 1000;
left: 50%;
top: 300px;
transform: translate(-50%, -50%);
-ms-transform: translate(-50%, -50%);
-webkit-transform: translate(-50%, -50%);
display: none;
  }
  .dialog2 {
/*    visibility: hidden;*/
position: absolute;
left: 0;
top: 0;
width: 50%;
padding: 40px;
text-align: center;
position: fixed;
z-index: 1000;
left: 50%;
top: 350px;
transform: translate(-50%, -50%);
-ms-transform: translate(-50%, -50%);
-webkit-transform: translate(-50%, -50%);
display: none;
  }
  .al {
    display: inline-block;
    vertical-align: middle;
  }
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