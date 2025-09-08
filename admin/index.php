<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require "../db.php";
$data = $_POST;
ini_set('file_uploads', 'On');
require 'rcon/rcon/rcon.php';
$f = explode(':', $_COOKIE['login'], 2);
$l = R::findOne('login', ' login = ? ', [ $f[0] ]);

$t = false;

if (isset($_COOKIE['login'])) {
    if($_COOKIE['login'] != $l->login.":".$l->password){
        header("Location: /admin/login");
    }
} else {
    header("Location: /admin/login");
}


if ($_GET['page'] == null) {
    header("Location: /admin/?page=stats");
}
$pages = array("stats", "main", "settings", "links", "rules", "cat", "gd", "ads", "docs", "rcon", 
    "promo", "payment", "static", "all_purch", "users", "sales");
if (!in_array($_GET['page'], $pages)) {
    header("Location: /admin/?page=stats");
}

if (isset($data['del-user'])) {
    if (password_verify($data['passwordo'], $l->password)) {
        $l2 = R::findOne('login', 'id = ?', [htmlspecialchars(trim($data['id']))]);
        R::trash($l2);
        header("Location: /admin/?page=users");
    } else {
        header("Location: /admin/?page=users&err=1");
    }
}

if (isset($data['add-user'])) {
    if (password_verify($data['passwordo'], $l->password)) {
        $is = R::findOne('login', 'login = ?', [htmlspecialchars($data['login'])]);
        if ($is) {
            header("Location: /admin/?page=users&err=2");
        } else {
            $l1 = R::dispense('login');
            $l1->login = htmlspecialchars(trim($data['login']));
            $l1->password = password_hash($data['password'], PASSWORD_DEFAULT);
            $l1->lastlogin = "0";
            $l1->root = json_encode(array(
                "root1" => htmlspecialchars($data['roots1']),
                "root2" => htmlspecialchars($data['roots2']),
                "root3" => htmlspecialchars($data['roots3']),
                "root4" => htmlspecialchars($data['roots4']),
                "root5" => htmlspecialchars($data['roots5']),
                "root6" => htmlspecialchars($data['roots6']),
                "root7" => htmlspecialchars($data['roots7']),
                "root8" => htmlspecialchars($data['roots8']),
                "root9" => htmlspecialchars($data['roots9']),
                "root10" => htmlspecialchars($data['roots10']),
                "root11" => htmlspecialchars($data['roots11']),
                "root12" => htmlspecialchars($data['roots11']),
                "root13" => htmlspecialchars($data['roots13']),
            ));
            R::store($l1);
            header("Location: /admin/?page=users");
        }
        
    } else {
        header("Location: /admin/?page=users&err=1");
    }
}


if (isset($data['shop-settings'])) {
    R::wipe('shopsettings');
    $sett = R::dispense('shopsettings');
    $sett->name = trim($data['name']);
    $sett->ip = trim($data['ip']);
    $sett->mail = trim($data['mail']);
    R::store($sett);
    $t = true;

}

$shopsettings = R::findOne('shopsettings', ' id = ? ', [ '1' ]);

if (isset($data['set-pass'])) {
    R::wipe('login');
    $sett1 = R::dispense('login');
    $sett1->login = trim($data['login']);
    $sett1->password = trim(password_hash($data['password'], PASSWORD_DEFAULT));
    R::store($sett1);
    $t = true;
}

if (isset($data['shop-color'])) {
    R::wipe('color');
    $sett2 = R::dispense('color');
    $sett2->color = trim($data['color']);
    if ($data['color'] == "custom") {
        R::wipe('customcolor');
        $dw3rf = R::dispense('customcolor');
        $dw3rf->color1 = $data['color1'];
        $dw3rf->color2 = $data['color2'];
        R::store($dw3rf);
    }
    R::store($sett2);
$t = true;
}

if (isset($data['main-text'])) {
    R::wipe('maintext');
    $sett3 = R::dispense('maintext');
    $sett3->text = trim($data['text']);
    R::store($sett3);
    $t = true;
}

$text = R::findOne('maintext', ' id = ? ', [ '1' ]);
$ccolor = R::findOne('customcolor', ' id = ? ', [ '1' ]);

if (isset($data['o-nas-text'])) {
    R::wipe('onas');
    $sett4 = R::dispense('onas');
    $sett4->text = trim($data['o-nas']);
    R::store($sett4);
    $t = true;
}

$o_nas = R::findOne('onas', 'id = ?', ['1']);

if (isset($data['socials'])) {
    R::wipe('socials');
    $sett5 = R::dispense('socials');
    $sett5->telegram = trim($data['telegram']);
    $sett5->youtube = trim($data['youtube']);
    $sett5->tiktok = trim($data['tiktok']);
    R::store($sett5);
    $t = true;
}

$socials = R::findOne('socials', 'id = ?', ['1']);

if (isset($data['rules'])) {
    $sett6 = R::dispense('rules');
    $sett6->name = trim($data['kategory-name']);
    $sett6->text = trim($data['kategory-text']);
    R::store($sett6);
    $t = true;
}

$rules = R::findAll('rules');

if (isset($data['rules_del'])) {
    $post = R::findOne('rules', 'id = ?', array($data['id']));
    R::trash($post);
    header("Location: /admin/?page=rules");
    $t = true;
}

if (isset($data['rules_prim'])) {
    $post1 = R::findOne('rules', 'id = ?', array($data['id']));
    $post1->name = $data['rul-name'];
    $post1->text = $data['rul-text'];
    R::store($post1);
 $t = true;
    header("Location: /admin/?page=rules");
}

if (isset($data['donate'])) {
    
        $name = $_FILES["file12"]["name"];
        move_uploaded_file($_FILES["file12"]["tmp_name"], $name);
        $name2 = time();
        rename($name, "../img/".$name);
    $sett7 = R::dispense('donate');
    $sett7->name = trim($data['donate-name']);
    $sett7->price = trim($data['donate-price']);
    $sett7->text = trim($data['donate-text']);
    $sett7->curr = $data['donate-cur'];
    $sett7->cmd = trim($data['donate-cmd']);
    $sett7->img = $_FILES["file12"]["name"];
    $sett7->on = (isset($data['on'])) ? "on" : "off";
    $sett7->on1 = (isset($data['on11'])) ? "on" : "off";
    $sett7->kategory = $data['kategory1'];
    $sett7->type = $data['donate-type'];
    $sett7->list = 1;
    R::store($sett7);
    $t = true;
}

$donate = R::findAll('donate', 'ORDER BY list ASC');

if (isset($data['donate_del'])) {
    $post = R::findOne('donate', 'id = ?', array($data['id']));
    R::trash($post);
    header("Location: /admin/?page=gd");
    $t = true;
}

if (isset($data['donate_prim'])) {
    $idf = "file13".$data['id'];
$name = $_FILES[$idf]["name"];
        move_uploaded_file($_FILES[$idf]["tmp_name"], $name);
        $name2 = time();
        rename($name, "../img/".$name);
    $post2 = R::findOne('donate', 'id = ?', array($data['id']));
    $post2t = R::findOne('donate', 'id = ?', array($data['id']));
    $post2->name = $data['donate-name'];
    $post2->price = $data['donate-price'];
    $post2->text = $data['donate-opis-text'];
    $post2->curr = $data['donate-cur'];
    $post2->cmd = trim($data['donate-cmd']);
    $post2->img = ($_FILES[$idf]["name"] != null) ? $_FILES[$idf]["name"] : $post2t->img;
    $post2->on = (isset($data['on'])) ? "on" : "off";
    $post2->on1 = (isset($data['on1'])) ? "on" : "off";
    $post2->kategory = $data['kategory2'];
    $post2->type = $data['donate-type1'];
    R::store($post2);
    header("Location: /admin/?page=gd");
    $t = true;
}

if (isset($data['sort'])) {
    $order = explode(',', $_POST['order']);
    $order = array_reverse($order);

    if ($_POST['order'] != null) {
        foreach ($order as $index => $productId) {
        $product = R::load('donate', $productId);
        $product->list = $index + 1;
        R::store($product);
    }
    }
    header("Location: /admin/?page=gd");
}

if (isset($data['on-pages'])) {
    R::wipe('docs');
    $pag = R::dispense('docs');
    $pag->on = trim($data['is']);
    R::store($pag);
    header("Location: /admin/?page=settings");
    $t = true;
}

$docs = R::findOne('docs', 'id = ?', ['1']);

if (isset($data['is-delete-code'])) {
    R::wipe('code');
    $pag1 = R::dispense('code');
    $pag1->on = trim($data['bv']);
    R::store($pag1);
    header("Location: /admin/?page=settings");
    $t = true;
}

$code = R::findOne('code', 'id = ?', ['1']);

if (isset($data['on-preloader'])) {
    R::wipe('preloader');
    $pag12 = R::dispense('preloader');
    $pag12->on = trim($data['dd']);
    R::store($pag12);
    header("Location: /admin/?page=settings");
    $t = true;
}

if (isset($data['on-conv'])) {
    R::wipe('curr');
    $pag12azx = R::dispense('curr');
    $pag12azx->on = trim($data['dd']);
    R::store($pag12azx);
    header("Location: /admin/?page=settings");
    $t = true;
}

if (isset($data['on-design'])) {
    R::wipe('design');
    $pag12azxcs = R::dispense('design');
    $pag12azxcs->on = trim($data['des']);
    R::store($pag12azxcs);
    header("Location: /admin/?page=settings");
    $t = true;
}

if (isset($data['on-snow'])) {
    // вы не шарите это не говно код это топ название 
    R::wipe('snow');
    $fdafsfdrtgfdsgtrfvdgfsvrdrfsgfdrs = R::dispense('snow');
    $fdafsfdrtgfdsgtrfvdgfsvrdrfsgfdrs->on = trim($data['snow1']);
    R::store($fdafsfdrtgfdsgtrfvdgfsvrdrfsgfdrs);
    header("Location: /admin/?page=settings");
    $t = true;
}

if (isset($data['on-op'])) {
    R::wipe('opis');
    $pag12azxcsefs = R::dispense('opis');
    $pag12azxcsefs->on = trim($data['opis']);
    R::store($pag12azxcsefs);
    header("Location: /admin/?page=settings");
    $t = true;
}

if (isset($data['on-version'])) {
    R::wipe('serverversion');
    $vers = R::dispense('serverversion');
    $vers->version = trim($data['version']);
    R::store($vers);
    header("Location: /admin/?page=settings");
    $t = true;
}
$svers = R::findOne("serverversion", "id = ?", ['1']);

$preloader = R::findOne('preloader', 'id = ?', ['1']);
$conv = R::findOne('curr', 'id = ?', ['1']);
$des = R::findOne('design', 'id = ?', ['1']);
$snow = R::findOne('snow', 'id = ?', ['1']);
$opis = R::findOne('opis', 'id = ?', ['1']);

$color = R::findOne('color', ' id = ? ', [ '1' ]);

if (isset($data['add-obj'])) {
    R::wipe('obj');
    $pag14 = R::dispense('obj');
    $pag14->text = trim($data['obj-text']);
    R::store($pag14);
    
    $t = true;
}

$obj = R::findAll('obj');

if (isset($data['obj_del'])) {
    $post12 = R::findOne('obj', 'id = ?', ['1']);
    R::trash($post12);
    header("Location: /admin/?page=ads");
    $t = true;
}

if (isset($data['oferta_prim'])) {
    R::wipe('oferta');
    $pag1d4 = R::dispense('oferta');
    $pag1d4->text = trim($data['text']);
    R::store($pag1d4);
    $t = true;
}

$oferta = R::findOne('oferta', ' id = ? ', [ '1' ]);
$privacy = R::findOne('privacy', ' id = ? ', [ '1' ]);

if (isset($data['privacy_prim'])) {
    R::wipe('privacy');
    $pag1ad4 = R::dispense('privacy');
    $pag1ad4->text = trim($data['text']);
    R::store($pag1ad4);
    $t = true;
}

$date = R::findOne('stats', ' date = ? ', [ date("m.d.y") ]);

if (!$date) {
    $ss = R::dispense('stats');
  $ss->all = 0;
  $ss->main = 0;
  $ss->rules = 0;
  $ss->donate = 0;
  $ss->play = 0;
  $ss->docs = 0;
  $ss->date = date("m.d.y");
  R::store($ss);
}

$date1 = R::findOne('stats', ' date = ? ', [ date("m.d.y") ]);

if (isset($data['add-rcon'])) {
        R::wipe('rcon');
    $pag1ad41 = R::dispense('rcon');
    $pag1ad41->host = trim($data['host']);
    $pag1ad41->port = trim($data['port']);
    $pag1ad41->password = trim($data['password']);
    R::store($pag1ad41);
    $t = true;
}

if (isset($data['add-plugin'])) {
        R::wipe('plugin');
    $pag1ad411 = R::dispense('plugin');
    $pag1ad411->host = trim($data['host']);
    $pag1ad411->port = trim($data['port']);
    $pag1ad411->password = trim($data['password']);
    R::store($pag1ad411);
    $t = true;
}

$rcon = R::findOne('rcon', 'id = ?', ['1']);
$plug = R::findOne('plugin', 'id = ?', ['1']);

if (isset($data['add_promo'])) {
    $pr = R::dispense('promo');
    $pr->promo = trim($data['promo']);
    $pr->sale = trim($data['sale']);
    $pr->date = trim($data['date']);
    if (isset($data['isp'])) {
        $pr->ogr = trim($data['isp']);
        $pr->kol = trim($data['kol']);
        $pr->isp = trim($data['kol']);
    } else {
        $pr->ogr = "off";
    }
    R::store($pr);
    $t = true;
}

$promo = R::findAll('promo');

if (isset($data['promo_del'])) {
    $g4 = R::findOne('promo', 'id = ?', array($data['id']));
    R::trash($g4);
    header("Location: /admin/?page=promo");
    $t = true;
}

if (isset($data['set-favicon'])) {
    $name = $_FILES["file"]["name"];
    move_uploaded_file($_FILES["file"]["tmp_name"], $name);
    rename($_FILES["file"]["name"], "../img/favicon.png");
    $t = true;
}

if (isset($data['add-link'])) {
    $pr11 = R::dispense('links');
    $pr11->title = trim($data['title']);
    $pr11->link = trim($data['link']);
    $pr11->color = trim($data['color']);
    R::store($pr11);
    $t = true;
}

$links = R::findAll('links');

if (isset($data['set-link'])) {
    $pffgf = R::findOne('links', 'id = ?', array($data['id']));
    $pffgf->title = $data['title'];
    $pffgf->link = $data['link'];
    $pffgf->color = $data['color'];
    R::store($pffgf);
    header("Location: /admin/?page=links");
    $t = true;
}

if (isset($data['del-link'])) {
    $postdwdw = R::findOne('links', 'id = ?', array($data['id']));
    R::trash($postdwdw);
    header("Location: /admin/?page=links");
    $t = true;
}

if (isset($data['set-freekassa'])) {
    R::wipe('freekassa');
    $prffg11 = R::dispense('freekassa');
    $prffg11->shop_id = trim($data['shop_id']);
    $prffg11->word1 = trim($data['word1']);
    $prffg11->word2 = trim($data['word2']);
    R::store($prffg11);
    $t = true;
}

if (isset($data['set-unitpay'])) {
    R::wipe('unitpay');
    $prffg11ff = R::dispense('unitpay');
    $prffg11ff->shop_id = trim($data['shop_id']);
    $prffg11ff->publicKey = trim($data['publicKey']);
    $prffg11ff->secretKey = trim($data['secretKey']);
    R::store($prffg11ff);
    $t = true;
}

if (isset($data['set-enot'])) {
    R::wipe('enot');
    $prffg11ffa = R::dispense('enot');
    $prffg11ffa->shop_id = trim($data['shop_id']);
    $prffg11ffa->secretKey = trim($data['secretKey']);
    $prffg11ffa->secretKey2 = trim($data['secretKey2']);
    R::store($prffg11ffa);
    $t = true;
}
if (isset($data['set-anypay'])) {
    R::wipe('anypay');
    $rf = R::dispense('anypay');
    $rf->shop_id = trim($data['shop_id']);
    $rf->secret_key = trim($data['secretKey']);
    R::store($rf);
    $t = true;
}
if (isset($data['set-aaio'])) {
    R::wipe('aaio');
    $rf111 = R::dispense('aaio');
    $rf111->shop_id = trim($data['shop_id']);
    $rf111->secret_key = trim($data['secret_key']);
    $rf111->secret_key2 = trim($data['secret_key2']);
    R::store($rf111);
    $t = true;
}
if (isset($data['set-payok'])) {
    R::wipe('payok');
    $rf11s = R::dispense('payok');
    $rf11s->shop_id = trim($data['shop_id']);
    $rf11s->secret_key = trim($data['secretKey']);
    R::store($rf11s);
    $t = true;
}


$freekassa = R::findOne('freekassa', 'id = ?', ['1']);
$enot = R::findOne('enot', 'id = ?', ['1']);
$unitpay = R::findOne('unitpay', 'id = ?', ['1']);
$anypay = R::findOne('anypay', 'id = ?', ['1']);
$payok = R::findOne('payok', 'id = ?', ['1']);
$aaio = R::findOne('aaio', 'id = ?', ['1']);

$dsw = R::findOne('discord', 'id = ?', ['1']);

if (isset($data['set-new-anypay'])) {
    $rf1 = R::findOne('anypay', 'id = ?', ['1']);
    $rf1->shop_id = $data['shop_id'];
    $rf1->secret_key = $data['secretKey'];
    R::store($rf1);
    header("Location: /admin/?page=payment");
    $t = true;
}

if (isset($data['set-new-aaio'])) {
    $rf12211 = R::findOne('aaio', 'id = ?', ['1']);
    $rf12211->shop_id = $data['shop_id'];
    $rf12211->secret_key = $data['secret_key'];
    $rf12211->secret_key2 = $data['secret_key2'];
    R::store($rf12211);
    header("Location: /admin/?page=payment");
    $t = true;
}


if (isset($data['set-new-payok'])) {
    $rfasf1 = R::findOne('payok', 'id = ?', ['1']);
    $rfasf1->shop_id = $data['shop_id'];
    $rfasf1->secret_key = $data['secretKey'];
    R::store($rfasf1);
    header("Location: /admin/?page=payment");
    $t = true;
}

if (isset($data['set-new-enot'])) {
    $bdfdf1cc = R::findOne('enot', 'id = ?', ['1']);
    $bdfdf1cc->shop_id = $data['shop_id'];
    $bdfdf1cc->secretKey = $data['secretKey'];
    $bdfdf1cc->secretKey2 = $data['secretKey2'];
    R::store($bdfdf1cc);
    header("Location: /admin/?page=payment");
    $t = true;
}

if (isset($data['set-new-unitpay'])) {
    $bdfdf1cc1 = R::findOne('unitpay', 'id = ?', ['1']);
    $bdfdf1cc1->shop_id = $data['shop_id'];
    $bdfdf1cc1->publicKey = $data['publicKey'];
    $bdfdf1cc1->secretKey = $data['secretKey'];
    R::store($bdfdf1cc1);
    header("Location: /admin/?page=payment");
    $t = true;
}

if (isset($data['del-freekassa'])) {
    $b554e46 = R::findOne('freekassa', 'id = ?', ['1']);
    R::trash($b554e46);
    header("Location: /admin/?page=payment");
    $t = true;
}

if (isset($data['del-anypay'])) {
    $re = R::findOne('anypay', 'id = ?', ['1']);
    R::trash($re);
    header("Location: /admin/?page=payment");
    $t = true;
}
if (isset($data['del-aaio'])) {
    $redsa1 = R::findOne('aaio', 'id = ?', ['1']);
    R::trash($redsa1);
    header("Location: /admin/?page=payment");
    $t = true;
}
if (isset($data['del-payok'])) {
    $redas = R::findOne('payok', 'id = ?', ['1']);
    R::trash($redas);
    header("Location: /admin/?page=payment");
    $t = true;
}

if (isset($data['del-enot'])) {
    $b554e46ffd = R::findOne('enot', 'id = ?', ['1']);
    R::trash($b554e46ffd);
    header("Location: /admin/?page=payment");
    $t = true;
}

if (isset($data['del-unitpay'])) {
    $b554e46dwdw = R::findOne('unitpay', 'id = ?', ['1']);
    R::trash($b554e46dwdw);
    header("Location: /admin/?page=payment");
    $t = true;
}

if (isset($data['add-page'])) {
    $feg = R::dispense('static');
    $feg->name = $data['name'];
    $feg->title = $data['title'];
    $feg->page = $data['page'];
    R::store($feg);
    header("Location: /admin/?page=static");
}
if (isset($data['add-kat'])) {
    $fegdddd = R::dispense('kategory');
    $fegdddd->name = $data['name'];
    R::store($fegdddd);
    header("Location: /admin/?page=cat");
}
$pages = R::findAll('static');

$kat = R::findAll('kategory');
$kat1 = R::findAll('kategory');

if (isset($data['del-page'])) {
    $hthtd = R::findOne('static', 'id = ?', [$data['id']]);
    R::trash($hthtd);
    header("Location: /admin/?page=static");
}

$payments1 = R::findAll('payments', 'status = ? ORDER BY id DESC LIMIT 5', ['Оплачено']);

if (isset($data['del-cat'])) {
    $dsf = R::findOne('kategory', 'id = ?', [$data['id']]);
    $beans = R::find('donate', 'kategory = ?', [$dsf->name]);

// Изменить значение "kategory" на "без" для каждой найденной записи.
foreach ($beans as $bean) {
    $bean->kategory = 'Без';
    R::store($bean);
}
    
    R::trash($dsf);
    header("Location: /admin/?page=cat");
}

if (isset($data['on-dsw'])) {
    R::wipe('discord');
    $zxcursed_i_love_you = R::dispense('discord');
    $zxcursed_i_love_you->on = trim($data['dsw']);
    if ($data['dsw'] == "on") {
        $zxcursed_i_love_you->link = trim($data['dsw-i']);
    }
    R::store($zxcursed_i_love_you);
    header("Location: /admin/?page=settings");
    $t = true;
}
if ($l->root != null) {
    $lg = json_decode($l->root);
}

if (isset($data['createsale'])) {
    if ($data['donatelisr'] != "" or $data['donatelisr'] != "[]" or $data['donatelisr'] != null) {
        $sal = R::dispense('sales');
    $sal->name = $data['name'];
    $sal->sale = $data['sale'];
    $sal->daten = $data['daten'];
    $sal->datek = $data['datek'];
    // штооооооо
    $phpArray = json_decode($data['donatelisr'], true);
    $sal->donates = json_encode($phpArray);
    R::store($sal);
    foreach($phpArray as $phptop) {
        $prikol = R::findOne('donate', 'id = ?', [$phptop]);
        $prikol->sale = $data['name'];
        R::store($prikol);
    }
    $t= true;
    }
}

$sales = R::findAll("sales");

if (isset($data['delsales'])) {
$hthtd11 = R::findOne('sales', 'id = ?', [$data['id']]);
$fedsa = json_decode($hthtd11->donates);
foreach ($fedsa as $grf){
    $ef = R::findOne('donate', 'id = ?', [$grf]);
    $ef->sale = "-";
    R::store($ef);
}
    R::trash($hthtd11);
    header("Location: /admin/?page=sales");
}





?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">

  <!-- Менять тут -->
    <title>Админ панель</title>

    <link href="css/style.css" type="text/css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
 <link rel="shortcut icon" href="../img/favicon.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.4/font/bootstrap-icons.min.css" integrity="sha512-yU7+yXTc4VUanLSjkZq+buQN3afNA4j2ap/mxvdr440P5aW9np9vIr2JMZ2E5DuYeC9bAoH9CuCR7SJlXAa4pg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/20556d6d52.js" crossorigin="anonymous"></script>
  <script src="https://mcapi.us/scripts/minecraft.min.js"></script>
  <script type="text/javascript" src="js/index.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


</head>
<body class="bg">


<?php if($color != "custom"): ?>
<?php 

$hex1 = $ccolor->color1;
$rgb1 = sscanf($hex1, "#%02x%02x%02x");

$hex2 = $ccolor->color2;
$rgb2 = sscanf($hex2, "#%02x%02x%02x");

?>
<style type="text/css">
    .custom {
        transition: 0.25s;
          padding: 30px;
          background: <?php echo $ccolor->color1; ?>;
          background: linear-gradient(141deg, rgba(<?php echo $rgb1[0].",".$rgb1[1].",".$rgb1[2]; ?>,1) 0%, rgba(<?php echo $rgb2[0].",".$rgb2[1].",".$rgb2[2]; ?>,1) 100%);
          box-shadow: 5px 5px 30px 5px rgba(<?php echo $rgb2[0].",".$rgb2[1].",".$rgb2[2]; ?>,0.3), -10px -7px 30px 1px rgba(<?php echo $rgb1[0].",".$rgb1[1].",".$rgb1[2]; ?>,0.3), 5px 5px 30px 5px rgba(0,0,0,0);
          border-radius: 15px;
    }
</style>

<?php endif; ?>


<div class="<?php  echo $color->color; ?> preloader">
<div align="center" style="margin-top: 260px;">
  <h1 class="logo" style="font-size: 60px;"><?php echo $shopsettings->name; ?></h1>
  <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
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
<?php if($t): ?>
    <div id="snackbar" style="border-radius: 20px; padding: 30px;"><i class="fa-sharp fa-solid fa-circle-check <?php echo $color->color; ?>" style="padding: 10px;" id="rgrgr"></i>&nbsp;&nbsp; Изменения успешно применены.</div>

<script>
    $(function(){
        var x = document.getElementById("snackbar");
        var y = document.getElementById("rgrgr");

  // Add the "show" class to DIV
  x.className = "show";

  // After 3 seconds, remove the show class from DIV
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
  setTimeout(function(){ $("#rgrgr").hide(); }, 3000);
    });
</script>
<?php endif; ?>

<div class="sidenav">
    <h4 class="logo <?php echo $color->color; ?>" style="padding-left: 16px; border-radius: 0px; padding: 10px; "><?php echo $shopsettings->name; ?></h4>
    <a  class="eveve <?php if($_GET['page'] == "stats" or $_GET['page'] == "all_purch") {echo "fffff-sel";}else{echo"fffff";} ?>" href="/admin?page=stats"><i class="bi bi-graph-down"></i> Статистика</a>
    <?php if($l->id == 1 or  $lg->root12 == "on" ): ?>
  <a  class="wefd <?php if($_GET['page'] == "settings") {echo "fffff-sel";}else{echo"fffff";} ?> "  href="/admin?page=settings"><i class="bi bi-gear"></i> Настройки магазина</a>
  <?php endif; ?>
  <?php if($l->id == 1): ?>
  <a  class="ghbtw436436 <?php if($_GET['page'] == "users") {echo "fffff-sel";}else{echo"fffff";} ?>" style="margin-bottom:0px;"  href="/admin?page=users"><i class="bi bi-people"></i> Пользователи</a>
<?php endif; ?>
<?php if($l->id == 1 or $lg->root2 == "on"): ?>
  <a  class="wevd <?php if($_GET['page'] == "main") {echo "fffff-sel";}else{echo"fffff";} ?>"  href="/admin?page=main"><i class="bi bi-person-badge"></i> Главная</a>
  <?php endif; ?>
  <?php if($l->id == 1 or $lg->root3 == "on"): ?>
  <a  class="trtrtry <?php if($_GET['page'] == "links") {echo "fffff-sel";}else{echo"fffff";} ?>"  href="/admin?page=links"><i class="bi bi-box-arrow-up-right"></i> Ссылки</a>
  <?php endif; ?>
  <?php if($l->id == 1 or  $lg->root4 == "on"): ?>
  <a  class="vtbd <?php if($_GET['page'] == "rules") {echo "fffff-sel";}else{echo"fffff";} ?>"  href="/admin?page=rules"><i class="bi bi-book"></i> Правила</a>
  <?php endif; ?>
  <?php if($l->id == 1 or  $lg->root6 == "on"): ?>
  <a  class="shstsht <?php if($_GET['page'] == "cat") {echo "fffff-sel";}else{echo"fffff";} ?>"  href="/admin?page=cat"><i class="bi bi-ui-checks-grid"></i> Категории</a>
  <?php endif; ?>
  <?php if($l->id == 1 or $lg->root5 == "on"): ?>
  <a  class="wrgr <?php if($_GET['page'] == "gd") {echo "fffff-sel";}else{echo"fffff";} ?>"  href="/admin?page=gd"><i class="bi bi-coin"></i> Товары</a>
  <?php endif; ?>
  <?php if($l->id == 1 or $lg->root7 == "on"): ?>
  <a  class="abfs <?php if($_GET['page'] == "ads") {echo "fffff-sel";}else{echo"fffff";} ?>"  href="/admin?page=ads"><i class="bi bi-card-text"></i> Объявление</a>
  <?php endif; ?>
    <?php if($l->id == 1 or $lg->root8 == "on"): ?>
  <a  class="vedve <?php if($_GET['page'] == "docs") {echo "fffff-sel";}else{echo"fffff";} ?>"  href="/admin?page=docs"><i class="bi bi-envelope-paper"></i> Документы</a>
    <?php endif; ?>
    <?php if($l->id == 1 or $lg->root9 == "on"): ?>

      <a  class="rerere <?php if($_GET['page'] == "rcon") {echo "fffff-sel";}else{echo"fffff";} ?>"  href="/admin?page=rcon"><i class="bi bi-terminal"></i> Ркон</a>
      
  <?php endif; ?>
  <?php if($l->id == 1 or $lg->root11 == "on"): ?>
  <a  class="efegers <?php if($_GET['page'] == "promo") {echo "fffff-sel";}else{echo"fffff";} ?>"  href="/admin?page=promo"><i class="bi bi-tags"></i> Промокоды</a>
  <?php endif; ?>
  <?php if($l->id == 1 or $lg->root10 == "on"): ?>
  <a  class="gbvgbv <?php if($_GET['page'] == "payment") {echo "fffff-sel";}else{echo"fffff";} ?>"  href="/admin?page=payment"><i class="bi bi-credit-card"></i> Платежные системы</a>
  <?php endif; ?>
  <?php if($l->id == 1 or $lg->root1 == "on"): ?>
  <a  class="ghbtw436436 <?php if($_GET['page'] == "static") {echo "fffff-sel";}else{echo"fffff";} ?>" href="/admin?page=static"><i class="bi bi-display"></i> Статические страницы</a>
  <?php endif; ?>
    <?php if($l->id == 1 or $lg->root13 == "on"): ?>
  <a  class="ghbtw436436 <?php if($_GET['page'] == "sales") {echo "fffff-sel";}else{echo"fffff";} ?>" style="margin-bottom:0px;"  href="/admin?page=sales"><i class="bi bi-cart4"></i> Акции</a>
  <?php endif; ?>
<br><hr style="color: #FFF;"><br>
<a href="/" class="lllllll" target="_blank"><h6>В магазин</h6></a>
  <?php if($l->id == 1): ?>
    <a href="https://discord.gg/EE5zASXUh3" target="_blank" class="lllllll"><h6>Дискорд сервер</h6></a>
  <a href="https://dr1ko-42.gitbook.io/dark./" target="_blank" class="lllllll"><h6>Вики</h6></a>
  <?php endif; ?>
  <a href="/admin/logout.php" class="lllllll"><h6>Выйти</h6></a>
</div>

<div class="menu">
  <div style="margin-left: 270px;">
    <h1 class="list logo" style="margin: auto; text-shadow: 0px 0px 6px white;">Админ панель</h1>
  </div>
</div>




   <div class="main-content">
        <div class="container" style="padding-top: 110px;">
        

      <?php if ($_GET['page'] == "stats"): ?>
         <div class="stat11">
    <div class="container">
        <h3 class="logo" style="margin-top: 20px; margin-left: 70px; margin-bottom: 30px;"><i class="bi bi-graph-down <?php echo $color->color; ?>" style="padding: 10px; padding-left: 15px; padding-right: 15px; border-radius: 15px;"></i>&nbsp;  Статистика</h3>
        <hr style="color: #FFF;">
        <?php 
        $count1 = R::count('payments', 'date = ? AND status = ?', [date('d.m.Y'), 'Оплачено']);
$count2 = R::count('payments', 'date = ? AND status = ?', [date('d.m.Y'), 'Не оплачено']);
$count3 = R::count('payments', 'date = ?', [date('d.m.Y')]);
        ?>

        <div align="center">
            <div style="background-color: rgba( 46, 46, 46, 0.3);
    border: 1px solid rgba(255, 255, 255, 0.18); padding: 30px; border-radius: 40px; width: 350px; margin-bottom: 40px; margin-top: 40px; margin-right: 20px; text-align: left;" class="list">
            <h5 class="logo" style="margin-bottom: 0px;">Успешных платежей</h5>
            <p style="margin-bottom: 0px; color: white; opacity: 0.5;">За последние 24 часа</p>
            <div style="background-color: rgba(255, 255, 255, 0.18); width: 100%; height: 2px; margin-top: 10px;"></div>
            <h3 class="logo" style="margin-bottom: 0px; margin-top: 10px;"><?php echo $count1; ?></h3>
        </div>

        <div style="background-color: rgba( 46, 46, 46, 0.3);
    border: 1px solid rgba(255, 255, 255, 0.18); padding: 30px; border-radius: 40px; width: 350px; margin-bottom: 40px; margin-top: 40px; margin-right: 20px; text-align: left;" class="list">
            <h5 class="logo" style="margin-bottom: 0px;">Неопл. платежей</h5>
            <p style="margin-bottom: 0px; color: white; opacity: 0.5;">За последние 24 часа</p>
            <div style="background-color: rgba(255, 255, 255, 0.18); width: 100%; height: 2px; margin-top: 10px;"></div>
            <h3 class="logo" style="margin-bottom: 0px; margin-top: 10px;"><?php echo $count2; ?></h3>
        </div>

        <div style="background-color: rgba( 46, 46, 46, 0.3);
    border: 1px solid rgba(255, 255, 255, 0.18); padding: 30px; border-radius: 40px; width: 350px; margin-bottom: 40px; margin-top: 40px; margin-right: 20px; text-align: left;" class="list">
            <h5 class="logo" style="margin-bottom: 0px;">Всего платежей</h5>
            <p style="margin-bottom: 0px; color: white; opacity: 0.5;">За последние 24 часа</p>
            <div style="background-color: rgba(255, 255, 255, 0.18); width: 100%; height: 2px; margin-top: 10px;"></div>
            <h3 class="logo" style="margin-bottom: 0px; margin-top: 10px;"><?php echo $count3; ?></h3>
        </div>
        </div>

        <div class="row">

            <div class="col">
                <div class="block">
                     <div class="<?php echo $color->color; ?>" style="padding: 20px; border-radius: 20px;">
                        <h3 class="logo" style="margin-bottom: 0px;">Статистика посещений</h3>
                        
                     </div><br>
                     <b>Всего: <?php echo $date1->all; ?></b><br>
                        Главная: <?php echo $date1->main; ?><br>
                        Правила: <?php echo $date1->rules; ?><br>
                        Описание доната: <?php echo $date1->donate; ?><br>
                        Начать играть: <?php echo $date1->play; ?><br>
                        Документы: <?php echo $date1->docs; ?>
                </div>
                 <div class="block">
                    <div class="<?php echo $color->color; ?>" style="padding: 20px; border-radius: 20px;">
                        <h3 class="logo" style="margin-bottom: 0px;">Сервер</h3>
                        
                     </div><br>
                      <?php

$status1 = json_decode(file_get_contents('https://api.mcsrvstat.us/2/'.$shopsettings->ip));
                        if ($status1->online) {
                            echo "Текущий онлайн: ".$status1->players->online;
                        } else {
                            echo "Оффлайн";
                        }
                      ?>
                </div>
            </div>
            <div class="col">
               <div class="block">
                   <div class="<?php echo $color->color; ?>" style="padding: 20px; border-radius: 20px;">
                        <h3 class="logo" style="margin-bottom: 0px;">Последние покупки</h3>
                        
                     </div><br>
                     <?php if(R::count('payments', 'status = ?', ['Оплачено']) > 0): ?>
                     <?php foreach($payments1 as $hghjn): ?>
                        <?php if ($hghjn->status == "Оплачено"): ?>
                            <div style="width: 100%; padding: 20px; border-radius: 15px; background-color: rgba( 46, 46, 46, 0.5); margin-bottom: 15px;">
                         <img src='https://minotar.net/avatar/<?php echo $hghjn->nick; ?>' class="list" style="margin-right: 0px; margin-left: 10px; height: 50px; border-radius: 10px;" />
                         <div class="list" align="left" style="text-align: left; margin-left: 30px;">
                             Ник: <b><?php echo $hghjn->nick; ?></b><br>
                             Дата: <b style="margin-right:50px;"><?php echo $hghjn->date; ?> в <?php echo $hghjn->time; ?></b><br>
                             Сумма: <b style="margin-right:10px;"><?php echo $hghjn->amount; ?> <?php echo $hghjn->curr; ?></b><br>
                             Статус: <b style="color: green;">Оплачено</b><br>
                             Касса: <b><?php echo $hghjn->payment_system; ?></b>
                             <?php if ($hghjn->promo != null): ?>
                                <?php $je = json_decode($hghjn->promo); ?>
                                <br>Промокод: <b><?php echo $je->promo; ?></b>
                             <?php endif; ?>
                         </div>
                         
                     </div>
                    <?php endif; ?>
                     <?php endforeach; ?>
                     <a href="/admin?page=all_purch"><button class="<?php echo $color->color; ?> m-f" style="border: 0px; width: 100%; color: white; font-weight: 500; padding: 10px; margin-bottom: 0px; margin-top: 10px;">Все покупки</button></a>
                 <?php else: ?>
                    <br>
                    <h4 align="center">Пусто...</h4>
                 <?php endif; ?>




               </div>
               
            </div>
        </div>
    </div>
</div>
      <?php endif;?>



      <?php if($_GET['page'] == "all_purch"): ?>
        <div style="margin-left: 30px;">
            <a href="/admin/?page=stats" style="text-decoration: none;"><div style="display: inline-block; padding: 7px 30px; background-color: rgba( 46, 46, 46, 0.3); color: #fff; border-radius: 12px;"><i class="fa-solid fa-arrow-left"></i> Назад</div></a>
        </div>
        <?php 
            $p_date = R::findAll('payments', 'ORDER BY id DESC'); 
            $dates = [];
            foreach ($p_date as $date1) {
                $currentDate = $date1->date;
$_monthsList = array(
  ".01." => "января",
  ".02." => "февраля",
  ".03." => "марта",
  ".04." => "апреля",
  ".05." => "мая",
  ".06." => "июня",
  ".07." => "июля",
  ".08." => "августа",
  ".09." => "сентября",
  ".10." => "октября",
  ".11." => "ноября",
  ".12." => "декабря"
);
 
//Наша задача - вывод русской даты, 
//поэтому заменяем число месяца на название:
$_mD = date(".m.", strtotime($currentDate)); //для замены
$currentDate = str_replace($_mD, " ".$_monthsList[$_mD]." ", $currentDate);
                $dates[] = $currentDate.":".$date1->date.":".$date1->status;
            }

            $dates1 = array_unique($dates);
        ?>
        <?php foreach($dates1 as $pipiskaaaa): ?>
            <div style="margin-top: 50px; margin-left: 30px; color: white;">
                <?php $dt = explode(":", $pipiskaaaa); ?>
                <?php if($dt[2] == "Оплачено"): ?>
                    <h3><?php echo $dt[0]; ?></h3>
                    <hr>
                    <?php foreach($p_date as $dota): ?>
                        <?php if($dota->date == $dt[1] and $dota->status == "Оплачено"): ?>
                            <div class="poke" style="margin-top: 20px; border-radius: 20px; padding: 20px; color: white; background-color: rgba( 46, 46, 46, 0.3);">
                                <img src="https://minotar.net/avatar/<?php echo $dota->nick; ?>" style="border-radius: 12px; height: 60px;" class="list">
                                <div class="list" style="text-align: left; margin-top: 3px;"><h5 style="margin-bottom:0px;"><?php echo $dota->nick; ?></h5>
                                    <?php $dota1 = R::findOne('donate', 'id = ?', [$dota->donate_id]); ?>
                                    в <?php echo $dota->time; ?>
                                </div>
                                <hr>
                                <div style="margin-bottom: 10px;">
                                    <span style="padding: 4px 15px; background-color: rgba( 69, 69, 69, 0.3); border-radius: 9px; margin-right: 5px; ">Товар:</span> <?php 

                                    if ($dota1->name == "") {
                                        echo '<b style="color:red;">Товар не найден</b>';
                                    } else {
                                        echo $dota1->name;
                                    }


                                     ?><br>
                                </div>
                                <div style="margin-bottom: 10px;">
                                    <span style="padding: 4px 15px; background-color: rgba( 69, 69, 69, 0.3); border-radius: 9px; margin-right: 5px; ">Сумма:</span> <?php echo $dota->amount; ?> <?php echo $dota->curr; ?><br>
                                </div>
                                <div style="margin-bottom: 10px;">
                                    <span style="padding: 4px 15px; background-color: rgba( 69, 69, 69, 0.3); border-radius: 9px; margin-right: 5px; ">Платежная система:</span> <?php echo $dota->payment_system; ?><br>
                                </div>
                                <?php if($dota->kol != null): ?>
                                    <div style="margin-bottom: 10px;">
                                        <span style="padding: 4px 15px; background-color: rgba( 69, 69, 69, 0.3); border-radius: 9px; margin-right: 5px; ">Количество:</span> <?php echo $dota->kol; ?><br>
                                    </div>
                                <?php endif; ?>
                                <?php if($dota->promo != null): ?>
                                    <div style="margin-bottom: 10px;">
                                        <?php $je1 = json_decode($dota->promo); ?>
                                        <span style="padding: 4px 15px; background-color: rgba( 69, 69, 69, 0.3); border-radius: 9px; margin-right: 5px; ">Промокод:</span> <?php echo $je1->promo; ?><br>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
      <?php endif; ?>


            

        <?php if($_GET['page'] == "settings"): ?>
            <div class="mag1">
                <h3 class="logo" style=" margin-left: 70px; margin-bottom: 30px;"><i class="bi bi-gear <?php echo $color->color; ?>" style="padding: 10px; padding-left: 15px; padding-right: 15px; border-radius: 15px;"></i>&nbsp;  Настройки магазина</h3>
        <hr style="color: #FFF;">
        <div class="row" >
            <div class="col">
                <div class="block">
                    
                    <form action="/admin/?page=settings" method="POST">
                        <label for="name" style="margin-bottom: 10px;">Название магазина</label><br>
                        <input type="text" name="name" required 
                        value="<?php echo $shopsettings->name; ?>"><br>
                        <label for="ip" style="margin-bottom: 10px; margin-top: 10px;">IP сервера</label><br>
                        <input type="text" name="ip" required value="<?php echo $shopsettings->ip; ?>"><br>
                        <label for="mail" style="margin-bottom: 10px; margin-top: 10px;">Почта для связи</label><br>
                        <input type="text" name="mail" required value="<?php echo $shopsettings->mail; ?>"><br>
                        <button type="submit" name="shop-settings" class="<?php echo $color->color; ?>">Применить</button>
                    </form>
                </div>

<div class="block">
                    <form action="/admin/?page=settings" method="POST">
                        <label for="is" style="margin-bottom: 10px;">Укажите версию сервера</label><br>
                        <input type="text" name="version" required <?php if($svers) echo 'value="'.$svers->version.'"'; ?>><br>
                        <button type="submit" name="on-version" class="<?php echo $color->color; ?>">Применить</button>
                    </form>
                </div>
                <?php if($l->id == 1): ?>
                <div class="block">
                    <form action="/admin/?page=settings" method="POST">
                        <label for="login" style="margin-bottom: 10px;">Новый логин</label><br>
                        <input type="text" name="login" required ><br>
                        <label for="ip" style="margin-bottom: 10px; margin-top: 10px;">Новый пароль</label><br>
                        <input type="password" name="password" required ><br><br>
                        <button type="submit" name="set-pass" class="<?php echo $color->color; ?>">Применить</button>
                    </form>
                </div>
            <?php endif; ?>

                <div class="block">
                    <form action="/admin/?page=settings" method="POST">
                        <label for="bv" style="margin-bottom: 10px;">Включить/выключить проверочное слово для удаления блока</label><br>
                        <input type="checkbox" name="bv" class="input" <?php echo ($code->on == "on") ? "checked" : ""; ?>><br>
                        <button type="submit" name="is-delete-code" class="<?php echo $color->color; ?>">Применить</button>
                    </form>
                </div>

                <div class="block">
                    <form action="/admin/?page=settings" method="POST" enctype="multipart/form-data">
                        <label for="dd" style="margin-bottom: 10px;">Изменить картинку в адресной строке</label><br>
                        <input type="file" name="file" id="file" class="inputfile" />
                        <label for="file" style="  color: white;
  outline: none;
  padding: 10px;
  padding-left: 20px;
  padding-right: 20px;
  border-radius: 15px;
  background-color: rgba( 46, 46, 46, 0.8);
  border: 0px;
  margin-top: 5px;
  cursor: pointer;
  margin-bottom: 5px;"><i class="bi bi-card-image"></i> Выбрать изображение</label>
                            <br>
                        <button type="submit" name="set-favicon" class="<?php echo $color->color; ?>">Применить</button>
                    </form>
                </div>




                 <div class="block">
                    <form action="/admin/?page=settings" method="POST">
                        <label for="dd" style="margin-bottom: 10px;">Включить/выключить описание доната в магазине</label><br>
                        <input type="checkbox" name="opis" class="input" <?php echo ($opis->on == "on") ? "checked" : ""; ?>><br>
                        <button type="submit" name="on-op" class="<?php echo $color->color; ?>">Применить</button>
                    </form>
                </div>

                <div class="block">
                    <form action="/admin/?page=settings" method="POST">
                        <label for="dd" style="margin-bottom: 10px;">Виджет Дискорд сервера</label><br>
                        <input type="checkbox" name="dsw" class="input" <?php echo ($dsw->on == "on") ? "checked" : ""; ?>><br><br>
                        <input type="text" name="dsw-i" <?php echo ($dsw->on == "on") ? "value='".$dsw->link."'" : ""; ?> class="dsw-i" style="display: none;" placeholder="Вставьте виджет"><br class="s" style="display: none;">
                        <script>
                            $(function() {
                                let eee = 0;
                                if ($("input[name=dsw]").attr("checked")) {
                                    $(".dsw-i").show();
                                    $(".s").show();
                                    eee++;
                                }
                                $("input[name=dsw]").click(function() {
                                    if (eee % 2 === 0) {
                                        $(".dsw-i").show();
                                        $(".s").show();
                                       $(".dsw-i").attr("required", "");

                                    } else {
                                        $(".dsw-i").hide();
                                        $(".s").hide();
                                        $(".dsw-i").removeAttr("required");
                                    }
                                    eee++;
                                });
                            });
                        </script>
                        <button type="submit" name="on-dsw" class="<?php echo $color->color; ?>">Применить</button>
                    </form>
                </div>


            </div>
            <div class="col">
                <div class="block">
                    <form action="/admin/?page=settings" method="POST">
                        <label style="margin-bottom: 20px;">Выберите цвет магазина</label><br>
                        <div class="purple list1">
                            
                        </div>
                        <div class="green list1">
                            
                        </div>
                        <div class="orange list1">
                            
                        </div>
                        <div class="blue list1">
                            
                        </div>
                        <div class="red list1">
                            
                        </div><br><br>
                        <div class="yellow list1">
                            
                        </div>
                        <div class="cyan list1">
                            
                        </div>
                        <div class="pink list1">
                            
                        </div>
                        <div class="gray list1">
                            
                        </div>
                        <div>
                            <input type="radio" name="color" style="margin-top: 30px;" id="purple" value="purple" required>
                            <label for="purple">Фиолетовый</label><br>
                            <input type="radio" name="color" id="green" value="green" required>
                            <label for="green">Зеленый</label><br>
                            <input type="radio" name="color" id="orange" value="orange" required>
                            <label for="orange">Оранжевый</label><br>
                            <input type="radio" name="color" id="blue" value="blue" required>
                            <label for="blue">Синий</label><br>
                            <input type="radio" name="color" id="red" value="red" required>
                            <label for="red">Красный</label><br>
                            <input type="radio" name="color" id="yellow" value="yellow" required>
                            <label for="yellow">Желтый</label><br>
                            <input type="radio" name="color" id="cyan" value="cyan" required>
                            <label for="cyan">Бирюзовый</label><br>
                            <input type="radio" name="color" id="pink" value="pink" required>
                            <label for="pink">Розовый</label><br>
                            <input type="radio" name="color" id="gray" value="gray" required>
                            <label for="gray">Серый</label><br>
                            <hr>
                            <input type="radio" name="color" id="custom" value="custom" required>
                            <label for="custom">Кастомный</label><br>
                            <script type="text/javascript">
                                $(function() {
                                    
                                      $("#custom1").hide();
                                      $("input[name=color]").click(function(){
                                         
                                          
                                          if($("#custom").prop('checked')) $("#custom1").show();
                                          else $("#custom1").hide();
                                      });
                                      if ($("#custom").prop('checked')) {}
                                });
                            </script>
                            <div id="custom1" style="background-color: rgba( 46, 46, 46, 0.3); border-radius: 15px; padding: 20px; margin-top: 10px;">
                                <label for="color1">1 цвет</label><br>
                                <input type="color" name="color1" style="height: 30px; border-radius: 10px;"><br>
                                <label for="color2">2 цвет</label><br>
                                <input type="color" name="color2" style="height: 30px; border-radius: 10px;"><br>
                            </div>
                        </div>

                        <button type="submit" name="shop-color" class="<?php echo $color->color; ?>">Применить</button>
                    </form>
                </div>

                <div class="block">
                    <form action="/admin/?page=settings" method="POST">
                        <label for="is" style="margin-bottom: 10px;">Включить/выключить страницы с документами</label><br>
                        <input type="checkbox" name="is" class="input" <?php echo ($docs->on == "on") ? "checked" : ""; ?>><br>
                        <button type="submit" name="on-pages" class="<?php echo $color->color; ?>">Применить</button>
                    </form>
                </div>



                <div class="block">
                    <form action="/admin/?page=settings" method="POST">
                        <label for="dd" style="margin-bottom: 10px;">Включить/выключить прелоадер</label><br>
                        <input type="checkbox" name="dd" class="input" <?php echo ($preloader->on == "on") ? "checked" : ""; ?>><br>
                        <button type="submit" name="on-preloader" class="<?php echo $color->color; ?>">Применить</button>
                    </form>
                </div>

                <div class="block">
                    <form action="/admin/?page=settings" method="POST">
                        <label for="dd" style="margin-bottom: 10px;">Включить/выключить конвертер валют</label><br>
                        <input type="checkbox" name="dd" class="input" <?php echo ($conv->on == "on") ? "checked" : ""; ?>><br>
                        <button type="submit" name="on-conv" class="<?php echo $color->color; ?>">Применить</button>
                    </form>
                </div>


                <div class="block">
                    <form action="/admin/?page=settings" method="POST">
                        <label for="dd" style="margin-bottom: 10px;">Включить/выключить новый дизайн</label><br>
                        <input type="checkbox" name="des" class="input" <?php echo ($des->on == "on") ? "checked" : ""; ?>><br>
                        <button type="submit" name="on-design" class="<?php echo $color->color; ?>">Применить</button>
                    </form>
                </div>

                <!-- <div class="block">
                    <form action="/admin/?page=settings" method="POST">
                        <label for="dd" style="margin-bottom: 10px;">Способ подключения к серверу</label><br>
                        <select name="conn" required>
                            <option value="rcon" <?php if ($con->type == "rcon" or $con->type == null) echo "selected"; ?>>Ркон</option>
                            <option value="plugin" <?php if ($con->type == "plugin") echo "selected"; ?>>Плагин</option>
                        </select><br>
                        <button type="submit" name="set-connection" class="<?php echo $color->color; ?>">Применить</button>
                    </form>
                </div> -->

                <div class="block">
                    <form action="/admin/?page=settings" method="POST">
                        <label for="snow1" style="margin-bottom: 10px;">Включить/выключить снег</label><br>
                        <input type="checkbox" name="snow1" class="input" <?php echo ($snow->on == "on") ? "checked" : ""; ?>><br>
                        <button type="submit" name="on-snow" class="<?php echo $color->color; ?>">Применить</button>
                    </form>
                </div>

                
            </div>
        </div>
            </div>
        <?php endif; ?>




        <?php if($_GET['page'] == "main"): ?>
            <div class="onas1">
                <h3 class="logo" style="margin-top: 20px; margin-left: 70px; margin-bottom: 30px;"><i class="bi bi-person-badge <?php echo $color->color; ?>" style="padding: 10px; padding-left: 15px; padding-right: 15px; border-radius: 15px;"></i>&nbsp;  Главная страница</h3>
        <hr style="color: #FFF;">
        <div class="row" >
            <div class="col">
                <div class="block">
                    <form action="/admin/?page=main" method="POST">
                        <label for="text" style="margin-bottom: 10px;">Приветственный текст</label><br>
                        <script type="text/javascript">
                            $(function(){
                            $("#text").each(function () {
                              this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
                            }).on("input", function () {
                              this.style.height = 0;
                              this.style.height = (this.scrollHeight) + "px";
                            });
                            });
                                                    </script>
                        <textarea name="text" required id="text"><?php  
                        echo $text->text;
                    ?></textarea><br>
                        <button type="submit" name="main-text" class="<?php echo $color->color; ?>">Применить</button>
                    </form>
                </div>

            

            </div>
            <div class="col">
                <div class="block">
                    <form action="/admin/?page=main" method="POST">
                        <label for="o-nas" style="margin-bottom: 10px;">О нас</label><br>
                        <script type="text/javascript">
                            $(function(){
                            $("#text1").each(function () {
                              this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
                            }).on("input", function () {
                              this.style.height = 0;
                              this.style.height = (this.scrollHeight) + "px";
                            });
                            });
                                                    </script>
                        <textarea name="o-nas" required id="text1"><?php echo $o_nas->text; ?></textarea><br>                        <button type="submit" name="o-nas-text" class="<?php echo $color->color; ?>">Применить</button>
                    </form>
                </div>
            </div>
        </div>
            </div>
        <?php endif;?>
            



        <?php  if($_GET['page'] == "rules"): ?>
            <div class="rul1">
            <h3 class="logo" style="margin-top: 20px; margin-left: 70px; margin-bottom: 30px;"><i class="bi bi-book <?php echo $color->color; ?>" style="padding: 10px; padding-left: 15px; padding-right: 15px; border-radius: 15px;"></i>&nbsp;  Правила</h3>
        <hr style="color: #FFF;">
        <div class="row">
            <div class="row">
                <div class="col">
                    <div class="block">
                        <form action="/admin/?page=rules" method="POST" >
                            
                            <label for="kategory-name" style="margin-bottom: 10px;">Заголовок</label><br>
                            <input type="text" name="kategory-name"><br>
                            <label for="kategory-text" style="margin-bottom: 10px; margin-top: 10px;">Текст</label><br>
                            <script type="text/javascript">
                            $(function(){
                            $("#text2").each(function () {
                              this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
                            }).on("input", function () {
                              this.style.height = 0;
                              this.style.height = (this.scrollHeight) + "px";
                            });
                            });
                                                    </script>
                            <textarea name="kategory-text" required id="text2"></textarea><br>
                        <button type="submit" name="rules" class="<?php echo $color->color; ?>">Создать</button>
                        </form>
                    </div>
                </div>
                <div class="col">
                    <?php foreach ($rules as $key): ?>

<div class="block">
                        <form method="POST" action="/admin/?page=rules">
                            
                            <input type="text" name="rul-name" 
                            value="<?php echo $key->name; ?>"><br>
                            <script type="text/javascript">
                            $(function(){
                            $("#text<?php echo $key->id; ?>").each(function () {
                              this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
                            }).on("input", function () {
                              this.style.height = 0;
                              this.style.height = (this.scrollHeight) + "px";
                            });
                            });
                                                    </script>
                                                    
                            <textarea name="rul-text" required id="text<?php echo $key->id; ?>"><?php echo $key->text; ?></textarea><br>
                            <input type="mail" name="id" value="<?php echo $key->id; ?>" style="background-color: rgba(0, 0, 0, 0);
                                                    color:  rgba( 46, 46, 46, 0.3); border: 0px; outline: none; height: 1px; margin: 0px;"  >

                                                    <?php if ($code->on == "on"): ?>
                                                        <br><label for="kod" style="margin-bottom: 10px;">Введите слово "Код", чтобы удалить этот блок.</label><br>
                                                    <script type="text/javascript">
                                                        $(function() {
                                                            document.getElementById("isdel<?php echo $key->id; ?>").disabled = true;

                                                            $(".ada<?php echo $key->id; ?>").keyup(function(e){
                                                                if (e.target.value == "Код") {
                                                                    document.getElementById("isdel<?php echo $key->id; ?>").disabled = false;
                                                                }
                                                            });
                                                        });
                                                    </script>
                            <input type="text" name="kod" class="ada<?php echo $key->id; ?>" placeholder="Код"><br>
                        <?php endif; ?>


                        
                        <button type="submit" name="rules_prim" class="<?php echo $color->color; ?>">Применить</button>
                        <button type="submit" name="rules_del" id="isdel<?php echo $key->id; ?>" class="del-btn">Удалить</button>
                    </form>

                    </div>

                    <?php endforeach; ?>
                </div>
            </div>
        </div>
</div>
        <?php endif; ?>

        


           <?php if($_GET['page'] == "gd"): ?>
             <div class="d1on" id="wdwd">
                <h3 class="logo" style="margin-top: 20px; margin-left: 70px; margin-bottom: 30px;"><i class="bi bi-coin <?php echo $color->color; ?>" style="padding: 10px; padding-left: 15px; padding-right: 15px; border-radius: 15px;"></i>&nbsp;  Товары</h3>
        <hr style="color: #FFF;">
        <div class="row">
                <div class="col">
                    <div class="block">
                        <form action="/admin/?page=gd" method="POST" enctype="multipart/form-data">
                            <label for="donate-type" style="margin-bottom: 10px;">Тип товара</label><br>
                            <select name="donate-type" required id="fees">
                                <option value="donate">Привилегия</option>
                                <option value="curr">Валюта (выбор кол-ва товара)</option>
                            </select><br><br>
                            <label for="donate-name" style="margin-bottom: 10px;">Название</label><br>
                            <input type="text" name="donate-name" required><br>
                            <label for="donate-price" style="margin-bottom: 10px;">Цена</label><br>
                            <input type="number" name="donate-price" required><br>
                            <label for="donate-cur" style="margin-bottom: 10px;">Валюта</label><br>
                            <select name="donate-cur" required >
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                                <option value="UAH">UAH</option>
                                <option value="KZT">KZT</option>
                                <option value="RUB">RUB</option>
                            </select><br>
                            <label for="donate-text" style="margin-bottom: 10px; margin-top: 10px;">Описание</label><br>
                            <script type="text/javascript">
                            $(function(){
                            $("#text4").each(function () {
                              this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
                            }).on("input", function () {
                              this.style.height = 0;
                              this.style.height = (this.scrollHeight) + "px";
                            });
                            });

                            $('#fees').on('change', function() {
                                  if (this.value == "curr") {
                                    $("#d-i-text").show();
                                  } if (this.value == "donate") {
$("#d-i-text").hide();
                                  }
                                });
                                                    </script>
                            <textarea name="donate-text" required id="text4"></textarea><br>
                            <label for="donate-cmd" style="margin-bottom: 10px;">Команда выдачи <b style="font-size:15px;">(Плейсхолдеры: %ИГРОК% - ник игрока<span id="d-i-text" style="display: none;">, %КОЛ% - кол-во товара (если выбран тип "Валюта")</span>)</b></label><br>
                            <input type="text" name="donate-cmd" required><br>
                            <label for="donate-img" style="margin-bottom: 10px; margin-top: 10px;">Изображение <b style="font-size:15px;">(Размер: 124х128)</b></label><br>
                            <input type="file" name="file12" id="file12" class="inputfile" required />
                        <label for="file12" style="  color: white;
  outline: none;
  padding: 10px;
  padding-left: 20px;
  padding-right: 20px;
  border-radius: 15px;
  background-color: rgba( 46, 46, 46, 0.8);
  border: 0px;
  margin-top: 5px;
  cursor: pointer;
  margin-bottom: 5px;"><i class="bi bi-card-image"></i> Выбрать изображение</label><br>
  <label for="dd" style="margin-bottom: 10px;">Включить/выключить доплату для этого товара</label><br>
                        <input type="checkbox" style="top:2px;" name="on" class="input"><br>
                         <label for="dd" style="margin-bottom: 10px;">Ограничить покупку товара (возможность купить только 1 раз)</label><br>
                        <input type="checkbox" style="top:2px;" name="on11" class="input"><br>
                        <label for="kategory1" style="margin-bottom: 10px;">Категория</label><br>
                        <select name="kategory1" required>
                            <option value="Без">Без категории</option>
                            <?php foreach ($kat1 as $bhgv): ?>
                            <option value="<?php echo $bhgv->name; ?>"><?php echo $bhgv->name; ?></option>
                            <?php endforeach; ?>
                        </select><br>
                        <button type="submit" name="donate" class="<?php echo $color->color; ?>">Создать</button>
                        </form>
                    </div>
                    <div class="block">
                         <div style="background: rgba( 50, 50, 50, 0.5 );
backdrop-filter: blur( 9px );
-webkit-backdrop-filter: blur( 9px );
padding: 2px 20px;
border-radius: 12px;
border: 1px solid rgba( 255, 255, 255, 0.18 ); display: inline-block;">🖨️ Порядок отображения</div>
<div style="margin-top: 20px;" id="productList">
    <form action="/admin/?page=gd" method="POST">
        <input type="hidden" name="order" id="orderInput" value="" required>
                        <?php foreach($donate as $chmo): ?>
                       

    <div data-product-id="<?php echo $chmo->id; ?>"  style="border-radius: 15px; border: 1px solid rgba( 255, 255, 255, 0.18 ); width: 100%; padding: 10px 20px; cursor: grab; transition: 0.25s; margin-bottom: 10px; backdrop-filter: blur( 7px );
-webkit-backdrop-filter: blur( 7px );" class="dse product-item"><img src="../img/<?php echo $chmo->img; ?>" style="height: 40px; margin-right: 10px;" class="list"> <h6 class="list" style="margin-top: 8px; font-family: 'Montserrat', sans-serif;"><?php echo $chmo->name; ?></h6></div>

<?php endforeach; ?>
<button type="submit" class="<?php echo $color->color; ?>" name="sort">Применить</button>
</form>
<script type="text/javascript">
$(document).ready(function() {
            $("#productList").sortable({
                items: ".product-item",
                cursor: "grabbing",
                helper: function(event, ui) {
                    return ui.clone().css("width", ui.width()); // Устанавливаем ширину клонированного элемента
                },
                update: function() {
                    updateOrderField();
                }
            });

            function updateOrderField() {
                var order = [];
                $("#productList .product-item").each(function() {
                    order.push($(this).data("product-id"));
                });
                order.reverse();
                $("#orderInput").val(order.join(","));
            }
        });
</script>
</div>
                    </div>
                </div>
                <div class="col">
                    <?php foreach ($donate as $value): ?>
<div class="block">
                        <form method="POST" action="/admin/?page=gd" enctype="multipart/form-data">
                            <script type="text/javascript">
                                $('#fees<?php echo $value->id; ?>').on('change', function() {
                                  if (this.value == "curr") {
                                    $("#d-i-text").show();
                                  } if (this.value == "donate") {
                                    $("#d-i-text").hide();
                                  }
                                });
                            </script>
                            <select name="donate-type1" required id="fees<?php echo $value->id; ?>">
                                <option value="donate" <?php if ($value->type == "donate") echo "selected"; ?>>Привилегия</option>
                                <option value="curr" <?php if ($value->type == "curr") echo "selected"; ?>>Валюта (выбор кол-ва товара)</option>
                            </select><br><br>
                            <input type="text" name="donate-name" value="<?php echo $value->name; ?>"><br>
                            <input type="number" name="donate-price" value="<?php echo $value->price; ?>"><br>
                            
                            <br><select name="donate-cur" >
                                <option value="USD" <?php echo ($value->curr == "USD") ? "selected" : ""; ?>>USD</option>
                                <option value="EUR" <?php echo ($value->curr == "EUR") ? "selected" : ""; ?>>EUR</option>
                                <option value="UAH" <?php echo ($value->curr == "UAH") ? "selected" : ""; ?>>UAH</option>
                                <option value="KZT" <?php echo ($value->curr == "KZT") ? "selected" : ""; ?>>KZT</option>
                                <option value="RUB" <?php echo ($value->curr == "RUB") ? "selected" : ""; ?>>RUB</option>
                            </select><br><br>
                            <script type="text/javascript">
                            $(function(){
                            $("#text5").each(function () {
                              this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
                            }).on("input", function () {
                              this.style.height = 0;
                              this.style.height = (this.scrollHeight) + "px";
                            });
                            });
                                                    </script>
                                                    <input type="hidden" name="id" value="<?php echo $value->id; ?>" style="background-color: rgba(0, 0, 0, 0);
                                                    color:  rgba( 46, 46, 46, 0.3); border: 0px; outline: none; height: 1px; margin: 0px;"  >
                            <textarea name="donate-opis-text"  id="text5"><?php echo $value->text; ?></textarea><br>
                            <input type="text" name="donate-cmd" value="<?php echo $value->cmd; ?>"><br>
                            <br>
                            <div class="row">
                                <?php if($value->img != NULL): ?>
                                    <div class="col">
                                      <div align="center">
                                          <img src="../img/<?php echo $value->img; ?>" style="height: 100px; margin: auto;"> 
                                      </div> 
                                    </div>
                                <?php endif; ?>
                                    <div class="col-md-8">
                                        <input type="file" name="file13<?php echo $value->id; ?>" id="file13<?php echo $value->id; ?>" class="inputfile" />
                                                                <label for="file13<?php echo $value->id; ?>" style="  color: white;
                                          outline: none;
                                          padding: 10px;
                                          padding-left: 20px;
                                          padding-right: 20px;
                                          border-radius: 15px;
                                          background-color: rgba( 46, 46, 46, 0.8);
                                          border: 0px;
                                          <?php if( $value->img != NULL): ?>
                                            margin-top: 30px;
                                        <?php else: ?>
                                            margin-top: 5px;
                                        <?php endif; ?>
                                          cursor: pointer;
                                          margin-bottom: 5px;"><i class="bi bi-card-image"></i> Изменить изображение</label>
                                    </div>
                            </div>
                            
                            <label for="on">Доплата</label> &nbsp;
                        <input type="checkbox" style="top:10px;" name="on" class="input" <?php echo ($value->on == "on") ? "checked" : ""; ?>><br>
                        <label for="on">Ограничение</label> &nbsp;
                        <input type="checkbox" style="top:10px;" name="on1" class="input" <?php echo ($value->on1 == "on") ? "checked" : ""; ?>><br>
                        <br>
                            <select name="kategory2">
                                <option value="Без" <?php if ($value->kategory == "Без") echo "selected"; ?>>Без категории</option>
                                <?php foreach ($kat1 as $mngv): ?>
                                    <option value="<?php echo $mngv->name; ?>" <?php if ($value->kategory == $mngv->name) echo "selected"; ?>><?php echo $mngv->name; ?></option>
                                <?php endforeach; ?>
                            </select>


                            <?php if ($code->on == "on"): ?>
                                                        <br><label for="kod" style="margin-bottom: 10px;">Введите слово "Код", чтобы удалить этот блок.</label><br>
                                                    <script type="text/javascript">
                                                        $(function() {
                                                            document.getElementById("wew<?php echo $value->id; ?>").disabled = true;

                                                            $(".ada<?php echo $value->id; ?>").keyup(function(e){
                                                                if (e.target.value == "Код") {
                                                                    document.getElementById("wew<?php echo $value->id; ?>").disabled = false;
                                                                }
                                                            });
                                                        });
                                                    </script>
                            <input type="text" name="kod" class="ada<?php echo $value->id; ?>" placeholder="Код"><br>
                        <?php endif; ?>
                        
                        <button type="submit" name="donate_prim" class="<?php echo $color->color; ?>">Применить</button>
                        <button type="submit" name="donate_del" id="wew<?php echo $value->id; ?>" class="del-btn">Удалить</button>
                        </form>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
            </div>
           <?php endif; ?>




        
       <?php if($_GET['page'] == "ads"): ?>
         <div class="obj">
            <div class="container">
                <h3 class="logo" style="margin-top: 20px; margin-left: 70px; margin-bottom: 30px;"><i class="bi bi-card-text <?php echo $color->color; ?>" style="padding: 10px; padding-left: 15px; padding-right: 15px; border-radius: 15px;"></i>&nbsp;  Объявление</h3>
        <hr style="color: #FFF;">
        <div class="row">
                <div class="col">
                    <div class="block">
                        <form action="/admin/?page=ads" method="POST" >
                            
                            <label for="obj-text" style="margin-bottom: 10px;">Текст</label><br>
                            <input type="text" name="obj-text"><br>

                            
                        <button type="submit" name="add-obj" class="<?php echo $color->color; ?>">Написать</button>
                        </form>
                    </div>
                </div>
                <div class="col">
                    <?php foreach ($obj as $thd): ?>
                        <div class="block">
                            <p><?php echo $thd->text; ?></p>

<form action="/admin/" method="POST">
    <?php if ($code->on == "on"): ?>
                                                        <br><label for="kod" style="margin-bottom: 10px;">Введите слово "Код", чтобы удалить этот блок.</label><br>
                                                    <script type="text/javascript">
                                                        $(function() {
                                                            document.getElementById("dnh<?php echo $thd->id; ?>").disabled = true;

                                                            $(".ada<?php echo $thd->id; ?>").keyup(function(e){
                                                                if (e.target.value == "Код") {
                                                                    document.getElementById("dnh<?php echo $thd->id; ?>").disabled = false;
                                                                }
                                                            });
                                                        });
                                                    </script>
                            <input type="text" name="kod" class="ada<?php echo $thd->id; ?>" placeholder="Код"><br>
                        <?php endif; ?>

                            <button type="submit" name="obj_del" id="dnh<?php echo $thd->id; ?>" class="del-btn">Удалить</button>
</form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
            </div>
       <?php endif; ?>


        


       <?php if($_GET['page'] == "docs"):?>
        <div class="m_doc">
            <div class="container">
                <h3 class="logo" style="margin-top: 20px; margin-left: 70px; margin-bottom: 30px;"><i class="bi bi-envelope-paper <?php echo $color->color; ?>" style="padding: 10px; padding-left: 15px; padding-right: 15px; border-radius: 15px;"></i>&nbsp;  Документы</h3>
        <hr style="color: #FFF;">
                <div class="row">
                    <div class="col">
                        <div class="block">
                             <form method="POST" action="/admin/?page=docs">
                                 <label for="text" style="margin-bottom: 10px;">Оферта</label><br>
                        <script type="text/javascript">
                            $(function(){
                            $("#fds").each(function () {
                              this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
                            }).on("input", function () {
                              this.style.height = 0;
                              this.style.height = (this.scrollHeight) + "px";
                            });
                            });
                                                    </script>
                        <textarea name="text" required id="fds"><?php  
                        echo $oferta->text;
                    ?></textarea>
                    <button type="submit" name="oferta_prim" class="<?php echo $color->color; ?>">Применить</button>
                             </form>
                        </div>
                    </div>
                    <div class="col">
                        <div class="block">
                             <form method="POST" action="/admin/?page=docs">
                                 <label for="text" style="margin-bottom: 10px;">Политика в отношении обработки персональных данных</label><br>
                        <script type="text/javascript">
                            $(function(){
                            $("#fds1").each(function () {
                              this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
                            }).on("input", function () {
                              this.style.height = 0;
                              this.style.height = (this.scrollHeight) + "px";
                            });
                            });
                                                    </script>
                        <textarea name="text" required id="fds1"><?php  
                        echo $privacy->text;
                    ?></textarea>
                    <button type="submit" name="privacy_prim" class="<?php echo $color->color; ?>">Применить</button>
                             </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <?php endif; ?>


        



       <?php if($_GET['page'] == "rcon"): ?>
        <div class="rcon">
    <div class="container">
        <h3 class="logo" style="margin-top: 20px; margin-left: 70px; margin-bottom: 30px;"><i class="bi bi-terminal <?php echo $color->color; ?>" style="padding: 10px; padding-left: 15px; padding-right: 15px; border-radius: 15px;"></i>&nbsp;  Ркон</h3>
        <hr style="color: #FFF;">
        <div class="row">
             <div class="col">
                 <div class="block"> 
                     <form action="/admin/?page=rcon" method="POST">
                         <label for="host" style="margin-bottom: 10px;">Айпи</label><br>
                        <input type="text" name="host" required><br>
                        <label for="port" style="margin-bottom: 10px;">Ркон порт</label><br>
                        <input type="number" name="port" required><br>
                        <label for="password" style="margin-bottom: 10px;">Пароль</label><br>
                        <input type="password" name="password" required><br>
                        <button type="submit" name="add-rcon" class="<?php echo $color->color; ?>">Добавить сервер</button>
                     </form>
                 </div>
             </div>
             <div class="col">
                 <?php if($rcon): ?>
                    <iframe src="/admin/rcon" style="
    border-radius: 20px;
    margin-top: 10px;
    margin-right: auto;
    margin-left: auto;
    width: 80%;" height="420px"></iframe>
                 <?php endif; ?><br>
                 <button align="center" style="width: 500px; margin-bottom: 20px;   transition: 0.35s;
  border-radius: 15px;
  border: 0px;
  color: white;
  padding: 10px;
  padding-left: 20px;
  padding-right: 20px;
  margin-top: 20px;
"  class="<?php echo $color->color; ?>"><a href="/admin/rcon"  style="text-decoration: none; color: white;" target="_blank">Открыть в отдельной вкладке</a></div>
             </div>
        </div>
    </div>
</div>
       <?php endif; ?>




<?php if($_GET['page'] == "promo"): ?>
<div class="promo" style="margin-left: ;">
    <div class="">
        <h3 class="logo" style="margin-top: 20px; margin-left: 70px; margin-bottom: 30px;"><i class="bi bi-tags <?php echo $color->color; ?>" style="padding: 10px; padding-left: 15px; padding-right: 15px; border-radius: 15px;"></i>&nbsp;  Промокоды</h3>
        <hr style="color: #FFF;">
        <div class="row">
            <div class="col">
                 <div class="block">
                     <form action="/admin/?page=promo" method="POST">
                          <label for="promo" style="margin-bottom: 10px;">Промокод</label><br>
                        <input type="text" name="promo" required><br>
                         <label for="sale" style="margin-bottom: 10px;">Скидка (в %)</label><br>
                        <input type="number" name="sale" required><br>
                        <label for="date" style="margin-bottom: 10px;">Действует до</label><br>
                        <input type="date" name="date" required><br>
                        <label for="isp" style="margin-bottom: 5px; margin-top: 5px;">Ограниченное количество использований</label><br>
                        <input type="checkbox" name="isp" class="input isp"><br>
                        <input type="number" name="kol" class="dsf" placeholder="Кол-во" style="margin-top: 20px;">
                        <script type="text/javascript">
                            $(function() {
                                $(".dsf").hide();
                                      $(".isp").click(function(){
                                         
                                          
                                          if($(".isp").prop('checked')) $(".dsf").show();
                                          else $(".dsf").hide();
                                      });
                                    
                            });
                        </script>
                        <button type="submit" name="add_promo" class="<?php echo $color->color; ?>">Добавить промокод</button>
                     </form>
                 </div>
            </div>
            <div class="col">
                 <?php foreach($promo as $rbg): ?>

                    <div class="block">
                         <h3 class="logo"><?php echo $rbg->promo; ?> <?php 
                         $da = 0;
                         if ($rbg->isp != null) {
                             if ($rbg->isp <= 0) {
                                $da = 1;
                             }
                         }
                        
                         if ($rbg->date < date("Y-m-d") or $da == 1) echo "(Не работает)"; ?></h3>
                         Скидка <?php echo $rbg->sale; ?>%<br>
                         Действует до <?php echo $rbg->date; ?>
                         <?php if ($rbg->ogr == "on"): ?>
                            <br>Кол-во использований: <?php echo $rbg->isp; ?> / <?php echo $rbg->kol; ?>
                         <?php endif; ?>
                         <form action="/admin/" method="POST">
                             <?php if ($code->on == "on"): ?>
                                                        <br><label for="kod" style="margin-bottom: 10px;">Введите слово "Код", чтобы удалить этот блок.</label><br>
                                                    <script type="text/javascript">
                                                        $(function() {
                                                            document.getElementById("dnh53<?php echo $rbg->id; ?>").disabled = true;

                                                            $(".ada53<?php echo $rbg->id; ?>").keyup(function(e){
                                                                if (e.target.value == "Код") {
                                                                    document.getElementById("dnh53<?php echo $rbg->id; ?>").disabled = false;
                                                                }
                                                            });
                                                        });
                                                    </script>
                            <input type="text" name="kod" class="ada53<?php echo $thd->id; ?>" placeholder="Код"><br>
                        <?php endif; ?>
                            <input type="hidden" name="id" value="<?php echo $rbg->id; ?>">
                            <button type="submit" name="promo_del" id="dnh53<?php echo $rbg->id; ?>" class="del-btn">Удалить</button>
                         </form>
                    </div>
                 <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>





<?php if($_GET['page']=="links"): ?>
    <div class="links" style="margin-left: 0px;">
    <div class="" >
        <h3 class="logo" style="margin-top: 20px; margin-left: 70px; margin-bottom: 30px;"><i class="bi bi-box-arrow-up-right <?php echo $color->color; ?>" style="padding: 10px; padding-left: 15px; padding-right: 15px; border-radius: 15px;"></i>&nbsp;  Ссылки</h3>
        <hr style="color: #FFF;">
        <div class="row">
            <div class="col">
                <div class="block">
                    <form action="/admin/?page=links" method="POST">
                        <label for="title" style="margin-bottom: 10px;">Текст</label><br>
                        <input type="text" name="title" required><br>
                        <label for="link" style="margin-bottom: 10px;">Адресс </label><br>
                        <input type="text" name="link" required><br>
                        <label for="color" style="margin-bottom: 10px;">Цвет </label><br>
                        <input type="color" name="color" required style="height: 50px;"><br>
                        <button type="submit" name="add-link" class="<?php echo $color->color; ?>">Добавить ссылку</button>
                    </form>
                </div>
            </div>
            <div class="col">
                <?php foreach($links as $libk): ?>
                    <div class="block">
                        <form action="/admin/?page=links" method="POST">
                            <input type="text" name="title" value="<?php echo $libk->title; ?>" required><br>
                            <input type="text" name="link" value="<?php echo $libk->link; ?>" required><br>
                            <input type="color" name="color" value="<?php echo $libk->color; ?>" required style="height: 50px;"><br>
                            <input type="hidden" name="id" value="<?php echo $libk->id; ?>">

                            <?php if ($code->on == "on"): ?>
                                                        <br><label for="kod" style="margin-bottom: 10px;">Введите слово "Код", чтобы удалить этот блок.</label><br>
                                                    <script type="text/javascript">
                                                        $(function() {
                                                            document.getElementById("wewnn<?php echo $libk->id; ?>").disabled = true;

                                                            $(".adann<?php echo $libk->id; ?>").keyup(function(e){
                                                                if (e.target.value == "Код") {
                                                                    document.getElementById("wewnn<?php echo $libk->id; ?>").disabled = false;
                                                                }
                                                            });
                                                        });
                                                    </script>
                            <input type="text" name="kod" class="adann<?php echo $libk->id; ?>" placeholder="Код"><br>
                        <?php endif; ?>



                            <button type="submit" name="set-link" class="<?php echo $color->color; ?>">Применить</button>
                            <button type="submit" name="del-link" id="wewnn<?php echo $libk->id; ?>" class="del-btn">Удалить</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endif;?>





<?php if($_GET['page']=="payment"): ?>
    <div class="paymants" style="margin-left: 0px;">
    <div class="container">
        <h3 class="logo" style="margin-top: 20px; margin-left: 70px; margin-bottom: 30px;"><i class="bi bi-credit-card <?php echo $color->color; ?>" style="padding: 10px; padding-left: 15px; padding-right: 15px; border-radius: 15px;"></i>&nbsp;  Платежные системы</h3>
        <hr style="color: #FFF;">
        
        <div class="row">
            <div class="col">
                <div align="center"><img src="img/free.jpg" style="border-top-left-radius: 20px; border-top-right-radius: 20px; margin-bottom: 0px; width: 500px; height: 150px; margin-left: auto; margin-right: auto;"></div>
                <div class="block" style="border-top-left-radius: 0px; border-top-right-radius: 0px; margin-top:0px; margin-bottom:20px;">
                    <form action="/admin/?page=payment" method="POST">
                        <label for="shop_id" style="margin-bottom: 10px;">Айди магазина</label><br>
                        <input type="number" name="shop_id" required placeholder="12345"><br>
                        <label for="word" style="margin-bottom: 10px;">Секретное слово 1</label><br>
                        <input type="password" name="word1" required placeholder="***********"><br>
                        <label for="word2" style="margin-bottom: 10px;">Секретное слово 2</label><br>
                        <input type="password" name="word2" required placeholder="***********"><br>
                        <button type="submit" name="set-freekassa" class="<?php echo $color->color; ?>">Применить</button>
                    </form>
                </div>



                <div align="center"><img src="img/unit.jpg" style="border-top-left-radius: 20px; border-top-right-radius: 20px; margin-bottom: 0px; width: 500px; height: 150px; margin-left: auto; margin-right: auto;"></div>
                <div class="block" style="border-top-left-radius: 0px; border-top-right-radius: 0px; margin-top:0px; margin-bottom:20px;">
                    <form action="/admin/?page=payment" method="POST">
                        <label for="shop_id" style="margin-bottom: 10px;">Айди магазина</label><br>
                        <input type="number" name="shop_id" required placeholder="12345"><br>
                        <label for="publicKey" style="margin-bottom: 10px;">Публичный ключ</label><br>
                        <input type="password" name="publicKey" required placeholder="***********"><br>
                        <label for="secretKey" style="margin-bottom: 10px;">Секретный ключ</label><br>
                        <input type="password" name="secretKey" required placeholder="***********"><br>
                        <button type="submit" name="set-unitpay" class="<?php echo $color->color; ?>">Применить</button>
                    </form>
                </div>



                <div align="center"><img src="img/enot.jpg" style="border-top-left-radius: 20px; border-top-right-radius: 20px; margin-bottom: 0px; width: 500px; height: 150px; margin-left: auto; margin-right: auto;"></div>
                <div class="block" style="border-top-left-radius: 0px; border-top-right-radius: 0px; margin-top:0px; margin-bottom:20px;">
                    <form action="/admin/?page=payment" method="POST">
                        <label for="shop_id" style="margin-bottom: 10px;">Айди магазина</label><br>
                        <input type="text" name="shop_id" required placeholder="12345"><br>
                        <label for="secretKey" style="margin-bottom: 10px;">Секретное слово</label><br>
                        <input type="password" name="secretKey" required placeholder="***********"><br>
                        <label for="secretKey2" style="margin-bottom: 10px;">Секретное слово 2</label><br>
                        <input type="password" name="secretKey2" required placeholder="***********"><br>
                        <button type="submit" name="set-enot" class="<?php echo $color->color; ?>">Применить</button>
                    </form>
                </div>

                <div align="center"><img src="img/any.jpg" style="border-top-left-radius: 20px; border-top-right-radius: 20px; margin-bottom: 0px; width: 500px; height: 150px; margin-left: auto; margin-right: auto;"></div>
                <div class="block" style="border-top-left-radius: 0px; border-top-right-radius: 0px; margin-top:0px; margin-bottom:20px;">
                    <form action="/admin/?page=payment" method="POST">
                        <label for="shop_id" style="margin-bottom: 10px;">Айди магазина</label><br>
                        <input type="number" name="shop_id" required placeholder="12345"><br>
                        <label for="secretKey" style="margin-bottom: 10px;">Секретный ключ</label><br>
                        <input type="password" name="secretKey" required placeholder="***********"><br>
                        <button type="submit" name="set-anypay" class="<?php echo $color->color; ?>">Применить</button>
                    </form>
                </div>

                <div align="center"><img src="img/payok.jpg" style="border-top-left-radius: 20px; border-top-right-radius: 20px; margin-bottom: 0px; width: 500px; height: 150px; margin-left: auto; margin-right: auto;"></div>
                <div class="block" style="border-top-left-radius: 0px; border-top-right-radius: 0px; margin-top:0px; margin-bottom:20px;">
                    <form action="/admin/?page=payment" method="POST">
                        <label for="shop_id" style="margin-bottom: 10px;">Айди магазина</label><br>
                        <input type="number" name="shop_id" required placeholder="12345"><br>
                        <label for="secret_key" style="margin-bottom: 10px;">Секретный ключ</label><br>
                        <input type="password" name="secretKey" required placeholder="***********"><br>
                        <button type="submit" name="set-payok" class="<?php echo $color->color; ?>">Применить</button>
                    </form>
                </div>

                <div align="center"><img src="img/aaio.jpg" style="border-top-left-radius: 20px; border-top-right-radius: 20px; margin-bottom: 0px; width: 500px; height: 150px; margin-left: auto; margin-right: auto;"></div>
                <div class="block" style="border-top-left-radius: 0px; border-top-right-radius: 0px; margin-top:0px; margin-bottom:20px;">
                    <form action="/admin/?page=payment" method="POST">
                        <label for="shop_id" style="margin-bottom: 10px;">Айди магазина</label><br>
                        <input type="text" name="shop_id" required placeholder="12345"><br>
                        <label for="secretKey" style="margin-bottom: 10px;">Секретное слово</label><br>
                        <input type="password" name="secret_key" required placeholder="***********"><br>
                        <label for="secretKey2" style="margin-bottom: 10px;">Секретное слово 2</label><br>
                        <input type="password" name="secret_key2" required placeholder="***********"><br>
                        <button type="submit" name="set-aaio" class="<?php echo $color->color; ?>">Применить</button>
                    </form>
                </div>





            </div>
            <div class="col">
                <?php if (isset($freekassa)): ?>
                    <div class="block">
                        <h3 class="logo" style="color: #b30048;">FREEKASSA</h3><br>
                        <form action="/admin/?page=payment" method="POST">
                            <input type="number" name="shop_id" value="<?php echo $freekassa->shop_id; ?>"><br>
                        <input type="password" name="word" value="<?php echo $freekassa->word1; ?>"><br>
                        <input type="password" name="word2" value="<?php echo $freekassa->word2; ?>"><br>

                                                        <br><label for="kod" style="margin-bottom: 10px;">Введите слово "FreeKassa", чтобы удалить этот способ оплаты.</label><br>
                                                    <script type="text/javascript">
                                                        $(function() {
                                                            document.getElementById("dfbbre").disabled = true;

                                                            $(".dzdnht6r").keyup(function(e){
                                                                if (e.target.value == "FreeKassa") {
                                                                    document.getElementById("dfbbre").disabled = false;
                                                                }
                                                            });
                                                        });
                                                    </script>
                            <input type="text" name="kod" class="dzdnht6r" placeholder="FreeKassa"><br>

                        <button type="submit" name="set-new-freekassa" class="<?php echo $color->color; ?>">Применить</button>
                        <button type="submit" name="del-freekassa" id="dfbbre" class="del-btn">Удалить</button>
                        </form>
                    </div>
                <?php endif; ?>


<?php if (isset($unitpay)): ?>
                    <div class="block">
                        <h3 class="logo" style="color: #389e0d;">UNITPAY</h3><br>
                        <form action="/admin/?page=payment" method="POST">
                            <input type="number" name="shop_id" value="<?php echo $unitpay->shop_id; ?>"><br>
                            <input type="password" name="publicKey" value="<?php echo $unitpay->public_key; ?>"><br>
                        <input type="password" name="secretKey" value="<?php echo $unitpay->secret_key; ?>"><br>

                                                        <br><label for="kod" style="margin-bottom: 10px;">Введите слово "UnitPay", чтобы удалить этот способ оплаты.</label><br>
                                                    <script type="text/javascript">
                                                        $(function() {
                                                            document.getElementById("dfbbreggf").disabled = true;

                                                            $(".dzdnht6rggf").keyup(function(e){
                                                                if (e.target.value == "UnitPay") {
                                                                    document.getElementById("dfbbreggf").disabled = false;
                                                                }
                                                            });
                                                        });
                                                    </script>
                            <input type="text" name="kod" class="dzdnht6rggf" placeholder="UnitPay"><br>

                        <button type="submit" name="set-new-unitpay" class="<?php echo $color->color; ?>">Применить</button>
                        <button type="submit" name="del-unitpay" id="dfbbreggf" class="del-btn">Удалить</button>
                        </form>
                    </div>
                <?php endif; ?>



<?php if (isset($enot)): ?>
                    <div class="block">
                        <h3 class="logo" style="color: yellow;">ENOT.IO</h3><br>
                        <form action="/admin/?page=payment" method="POST">
                            <input type="number" name="shop_id" value="<?php echo $enot->shop_id; ?>"><br>
                        <input type="password" name="secretKey" value="<?php echo $enot->secret_key; ?>"><br>
                        <input type="password" name="secretKey2" value="<?php echo $enot->secret_key2; ?>"><br>

                                                        <br><label for="kod" style="margin-bottom: 10px;">Введите слово "Enot.io", чтобы удалить этот способ оплаты.</label><br>
                                                    <script type="text/javascript">
                                                        $(function() {
                                                            document.getElementById("dfbbreggfff").disabled = true;

                                                            $(".dzdnht6rggfff").keyup(function(e){
                                                                if (e.target.value == "Enot.io") {
                                                                    document.getElementById("dfbbreggfff").disabled = false;
                                                                }
                                                            });
                                                        });
                                                    </script>
                            <input type="text" name="kod" class="dzdnht6rggfff" placeholder="Enot.io"><br>

                        <button type="submit" name="set-new-enot" class="<?php echo $color->color; ?>">Применить</button>
                        <button type="submit" name="del-enot" id="dfbbreggfff" class="del-btn">Удалить</button>
                        </form>
                    </div>
                <?php endif; ?>


<?php if (isset($anypay)): ?>
                    <div class="block">
                        <h3 class="logo" style="color: yellow;">ANYPAY</h3><br>
                        <form action="/admin/?page=payment" method="POST">
                            <input type="number" name="shop_id" value="<?php echo $anypay->shop_id; ?>"><br>
                        <input type="password" name="secretKey" value="<?php echo $anypay->secret_key; ?>"><br>

                                                        <br><label for="kod" style="margin-bottom: 10px;">Введите слово "AnyPay", чтобы удалить этот способ оплаты.</label><br>
                                                    <script type="text/javascript">
                                                        $(function() {
                                                            document.getElementById("dfbbrefds").disabled = true;

                                                            $(".dzdnht6rfds").keyup(function(e){
                                                                if (e.target.value == "AnyPay") {
                                                                    document.getElementById("dfbbrefds").disabled = false;
                                                                }
                                                            });
                                                        });
                                                    </script>
                            <input type="text" name="kod" class="dzdnht6rfds" placeholder="AnyPay"><br>

                        <button type="submit" name="set-new-anypay" class="<?php echo $color->color; ?>">Применить</button>
                        <button type="submit" name="del-anypay" id="dfbbrefds" class="del-btn">Удалить</button>
                        </form>
                    </div>
                <?php endif; ?>



                <?php if (isset($payok)): ?>
                    <div class="block">
                        <h3 class="logo" style="color: yellow;">PAYOK</h3><br>
                        <form action="/admin/?page=payment" method="POST">
                            <input type="number" name="shop_id" value="<?php echo $payok->shop_id; ?>"><br>
                        <input type="password" name="secretKey" value="<?php echo $payok->secret_key; ?>"><br>

                                                        <br><label for="kod" style="margin-bottom: 10px;">Введите слово "PayOk", чтобы удалить этот способ оплаты.</label><br>
                                                    <script type="text/javascript">
                                                        $(function() {
                                                            document.getElementById("dfbbrefdrqaecfs").disabled = true;

                                                            $(".dzdnht6rfdsedfzsce").keyup(function(e){
                                                                if (e.target.value == "PayOk") {
                                                                    document.getElementById("dfbbrefdrqaecfs").disabled = false;
                                                                }
                                                            });
                                                        });
                                                    </script>
                            <input type="text" name="kod" class="dzdnht6rfdsedfzsce" placeholder="PayOk"><br>

                        <button type="submit" name="set-new-payok" class="<?php echo $color->color; ?>">Применить</button>
                        <button type="submit" name="del-payok" id="dfbbrefdrqaecfs" class="del-btn">Удалить</button>
                        </form>
                    </div>
                <?php endif; ?>

                <?php if (isset($aaio)): ?>
                    <div class="block">
                        <h3 class="logo" style="color: #7c5bff;">AAIO</h3><br>
                        <form action="/admin/?page=payment" method="POST">
                            <input type="text" name="shop_id" value="<?php echo $aaio->shop_id; ?>"><br>
                        <input type="password" name="secret_key" value="<?php echo $aaio->secret_key; ?>"><br>
                        <input type="password" name="secret_key2" value="<?php echo $aaio->secret_key2; ?>"><br>

                                                        <br><label for="kod" style="margin-bottom: 10px;">Введите слово "AAIO", чтобы удалить этот способ оплаты.</label><br>
                                                    <script type="text/javascript">
                                                        $(function() {
                                                            document.getElementById("dfbbrefdrqaecfs11111111").disabled = true;

                                                            $(".dzdnht6rfdsedfzsce11111111").keyup(function(e){
                                                                if (e.target.value == "AAIO") {
                                                                    document.getElementById("dfbbrefdrqaecfs11111111").disabled = false;
                                                                }
                                                            });
                                                        });
                                                    </script>
                            <input type="text" name="kod" class="dzdnht6rfdsedfzsce11111111" placeholder="AAIO"><br>

                        <button type="submit" name="set-new-aaio" class="<?php echo $color->color; ?>">Применить</button>
                        <button type="submit" name="del-aaio" id="dfbbrefdrqaecfs11111111" class="del-btn">Удалить</button>
                        </form>
                    </div>
                <?php endif; ?>




            </div>
        </div>
            
    </div>
</div>
<?php endif;?>




<?php if($_GET['page'] =="static"):?>
    <div class="statitic" style="margin-left: 0px;">
    <div class="container">
        <h3 class="logo" style="margin-top: 20px; margin-left: 70px; margin-bottom: 30px;"><i class="bi bi-display <?php echo $color->color; ?>" style="padding: 10px; padding-left: 15px; padding-right: 15px; border-radius: 15px;"></i>&nbsp;  Статические станицы</h3>
        <hr style="color: #FFF;">
        <div class="row">
            <div class="col">
                <div class="block">
                    <form action="/admin/?page=static" method="POST">
                        <label for="name" style="margin-bottom: 10px;">Ссылка на страницу (без /)</label><br>
                        <input type="text" name="name" required><br>
                        <label for="title" style="margin-bottom: 10px;">Название страницы (в меню)</label><br>
                        <input type="text" name="title" required><br>
                        <label for="page" style="margin-bottom: 10px;">Файл</label><br>
                        <select name="page" required>
                            <option value="1" <?php $page1 = R::findOne('static', 'page = ?', ['1']); $count = R::count('static');
                             if (isset($page1)) {
                                echo "disabled";
                            } ?>>static1.php</option>
                            <option value="2" <?php $page1 = R::findOne('static', 'page = ?', ['2']);
                             if (isset($page1)) {
                                echo "disabled";
                            } ?>>static2.php</option>
                            <option value="3" <?php $page1 = R::findOne('static', 'page = ?', ['3']);
                             if (isset($page1)) {
                                echo "disabled";
                            } ?>>static3.php</option>
                            <option value="4" <?php $page1 = R::findOne('static', 'page = ?', ['4']);
                             if (isset($page1)) {
                                echo "disabled";
                            } ?>>static4.php</option>
                            <option value="5" <?php $page1 = R::findOne('static', 'page = ?', ['5']);
                             if (isset($page1)) {
                                echo "disabled";
                            } ?>>static5.php</option>
                        </select>
                        <?php if ($count == 5): ?>
                        <br><br>
                        Все страницы уже созданы.
                    <?php else: ?>
                        
                        <button type="submit" name="add-page" class="<?php echo $color->color; ?>">Добавить страницу</button>
                    <?php endif; ?>
                    </form>
                </div>
                <div class="block">
                    <h5>Создано страниц: <span><?php echo $count; ?></span>/5</h5>
                </div>
            </div>
            <div class="col">
                <?php foreach($pages as $ofdn): ?>
                    <div class="block">
                        Путь: /<?php echo $ofdn->name; ?> (<a style="color:white; text-decoration: underline;" href="/<?php echo $ofdn->name; ?>" target="_blank">Перейти</a>)<br>
                        Файл: static<?php echo $ofdn->page; ?>.php
                        <form action="/admin/?page=static" method="POST">
                            <input type="hidden" name="id" value="<?php echo $ofdn->id; ?>">
                            <button type="submit" name="del-page" id="dfbbre" class="del-btn">Удалить</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endif;?>




<?php if($_GET['page']== "cat"): ?>
    <div class="kategory" style="margin-left: 0px;">
    <div class="">
        <h3 class="logo" style="margin-top: 20px; margin-left: 70px; margin-bottom: 30px;"><i class="bi bi-ui-checks-grid <?php echo $color->color; ?>" style="padding: 10px; padding-left: 15px; padding-right: 15px; border-radius: 15px;"></i>&nbsp;  Категории</h3>
        <hr style="color: #FFF;">
        <div class="row">
            <div class="col">
                <div class="block">
                    <form action="/admin/?page=cat" method="POST">
                        <label for="name" style="margin-bottom: 10px;">Название категории</label><br>
                        <input type="text" name="name" required><br>
        
                        
                        <button type="submit" name="add-kat" class="<?php echo $color->color; ?>">Добавить категорию</button>
                    </form>
                </div>
            </div>
            <div class="col">
                <?php foreach($kat as $dgfdgd): ?>
                    <div class="block">
                        <?php $count11 = R::count('donate', 'kategory = ?', [$dgfdgd->name]); ?>
                        <h3 class="logo"><?php echo $dgfdgd->name; ?></h3>
                        Товаров в категории: <?php echo $count11; ?>

                        <?php if ($code->on == "on"): ?>
                                                        <br><label for="kod" style="margin-bottom: 10px;">Введите слово "Код", чтобы удалить этот блок.</label><br>
                                                    <script type="text/javascript">
                                                        $(function() {
                                                            document.getElementById("isdelfwfwe<?php echo $dgfdgd->id; ?>").disabled = true;

                                                            $(".adafwfwwfq<?php echo $dgfdgd->id; ?>").keyup(function(e){
                                                                if (e.target.value == "Код") {
                                                                    document.getElementById("isdelfwfwe<?php echo $dgfdgd->id; ?>").disabled = false;
                                                                }
                                                            });
                                                        });
                                                    </script>
                            <input type="text" name="kod" class="adafwfwwfq<?php echo $dgfdgd->id; ?>" placeholder="Код"><br>
                        <?php endif; ?>
                        <form action="/admin/?page=cat" method="POST">
                            <input type="hidden" name="id" value="<?php echo $dgfdgd->id; ?>">
                            <button type="submit" name="del-cat" id="isdelfwfwe<?php echo $dgfdgd->id; ?>" class="del-btn">Удалить</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endif;?>


<?php if($_GET['page']== "users"): ?>
    <div class="kategory" style="margin-left: 0px;">
    <div class="">
        <h3 class="logo" style="margin-top: 20px; margin-left: 70px; margin-bottom: 30px;"><i class="bi bi-people <?php echo $color->color; ?>" style="padding: 10px; padding-left: 15px; padding-right: 15px; border-radius: 15px;"></i>&nbsp;  Пользователи</h3>
        <hr style="color: #FFF;">
        <div class="row">
            <div class="col">
                <div class="block">
                    <div style="background: rgba( 50, 50, 50, 0.5 );
backdrop-filter: blur( 9px );
-webkit-backdrop-filter: blur( 9px );
padding: 2px 20px;
border-radius: 12px;
border: 1px solid rgba( 255, 255, 255, 0.18 ); display: inline-block;">✅ Добавить пользователя</div>
<br><br>
<?php if (isset($_GET['err']) and $_GET['err'] == "1"): ?>
    <script type="text/javascript">
        alert("Неправильный пароль администратора");
    </script>
<?php endif; ?>

<?php if (isset($_GET['err']) and $_GET['err'] == "2"): ?>
    <script type="text/javascript">
        alert("Логины не должны совпадать");
    </script>
<?php endif; ?>
<form action="/admin/" method="POST">
    <label for="login">Введите логин</label>
    <input type="text" name="login" placeholder="admin2" required><br>
    <label for="password" style="margin-top: 10px;">Введите пароль</label>
    <input type="password" name="password" placeholder="********" required>

    <details style="margin-top: 20px; margin-bottom: 10px; display: inline-block;">
  <summary>Права</summary>
  <div style="background: rgba( 50, 50, 50, 0.5 );
backdrop-filter: blur( 9px );
-webkit-backdrop-filter: blur( 9px );
padding: 2px 20px;
border-radius: 12px;
border: 1px solid rgba( 255, 255, 255, 0.18 ); display: inline-block; cursor: pointer; margin-top: 30px; margin-right: 5px;" id="onall" class="list">Включить все</div>
<div style="background: rgba( 50, 50, 50, 0.5 );
backdrop-filter: blur( 9px );
-webkit-backdrop-filter: blur( 9px );
padding: 2px 20px;
border-radius: 12px;
border: 1px solid rgba( 255, 255, 255, 0.18 ); display: inline-block; cursor: pointer; margin-top: 30px;" id="offall" class="list">Выключить все</div>
<script type="text/javascript">
    $(function(){
        $("#onall").click(function(){
            $('.root').prop('checked', true);

        });

        $("#offall").click(function(){
            $('.root').prop('checked', false);
            
        });
    });
</script>
  <div style="padding: 15px;">
                        <label for="roots12" style="transform: translateY(-5px); margin-right: 10px;">Настройки магазина</label>
                        <input type="checkbox" name="roots2" class="input root" /><br>
                         <label for="roots2" style="transform: translateY(-5px); margin-right: 10px;">Главная страница</label>
                        <input type="checkbox" name="roots2" class="input root" /><br>
                        <label for="roots3" style="transform: translateY(-5px); margin-right: 10px;">Ссылки</label>
                        <input type="checkbox" name="roots3" class="input root" /><br>
                        <label for="roots4" style="transform: translateY(-5px); margin-right: 10px;">Правила</label>
                        <input type="checkbox" name="roots4" class="input root" /><br>
                        <label for="roots5" style="transform: translateY(-5px); margin-right: 10px;">Товары</label>
                        <input type="checkbox" name="roots5" class="input root" /><br>
                        <label for="roots6" style="transform: translateY(-5px); margin-right: 10px;">Категории</label>
                        <input type="checkbox" name="roots6" class="input root" /><br>
                        <label for="roots7" style="transform: translateY(-5px); margin-right: 10px;">Объявление</label>
                        <input type="checkbox" name="roots7" class="input root" /><br>
                        <label for="roots8" style="transform: translateY(-5px); margin-right: 10px;">Документы</label>
                        <input type="checkbox" name="roots8" class="input root" /><br>
                        <label for="roots9" style="transform: translateY(-5px); margin-right: 10px;">Ркон/Плагин</label>
                        <input type="checkbox" name="roots9" class="input root" /><br>
                        <label for="roots11" style="transform: translateY(-5px); margin-right: 10px;">Промокоды</label>
                        <input type="checkbox" name="roots10" class="input root" /><br>
                        <label for="roots1" style="transform: translateY(-5px); margin-right: 10px;">Статические страницы</label>
                        <input type="checkbox" name="roots1" class="input root" /><br>
                        <label for="roots13" style="transform: translateY(-5px); margin-right: 10px;">Акции</label>
                        <input type="checkbox" name="roots13" class="input root" />
</details>

<br>
    <label for="passwordo" style="margin-top: 10px;">Введите пароль администратора</label>
    <input type="password" name="passwordo" placeholder="********" required>
    <button type="submit" class="<?php echo $color->color; ?>" name="add-user">Применить</button>
</form>
                </div>
            </div>
            <div class="col">
                <?php $users = R::findAll("login"); ?>
               <?php foreach($users as $lk): ?>
                <div class="block">
                    <h3 class="logo" style="margin-bottom: 0px;"><?php echo $lk->login ?></h3>
                    <?php if ($lk->id == 1): ?>
                        <p>Администратор</p>
                    <?php endif; ?>
                    <hr>
                    <h6>Последний вход: <?php if ($lk->lastlogin == null or $lk == "0") {
                        echo "Данные не найдены";
                    } else {
                        echo $lk->lastlogin;
                    } ?></h6>

                    <?php if ($lk->id != 1): ?>
                        <hr>
                        <form method="POST" action="/admin/">
                            <label for="passwordo">Введите пароль администратора, чтобы удалить пользователя</label>
                            <input type="password" name="passwordo" placeholder="********" required>
                            <input type="hidden" name="id" value="<?php echo $lk->id; ?>">
                            <button class="del-btn" type="submit" name="del-user">Удалить</button>
                        </form>
                    <?php endif; ?>
                </div>
               <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>
<?php endif;?>



<?php if($_GET['page']== "sales"): ?>
    <div class="kategory" style="margin-left: 0px;">
    <div class="">
        <h3 class="logo" style="margin-top: 20px; margin-left: 70px; margin-bottom: 30px;"><i class="bi bi-cart4 <?php echo $color->color; ?>" style="padding: 10px; padding-left: 15px; padding-right: 15px; border-radius: 15px;"></i>&nbsp;  Акции</h3>
        <hr style="color: #FFF;">
        <div class="row">
            <div class="col">
                <div class="block">
                    <div style="background: rgba( 50, 50, 50, 0.5 );
backdrop-filter: blur( 9px );
-webkit-backdrop-filter: blur( 9px );
padding: 2px 20px;
border-radius: 12px;
border: 1px solid rgba( 255, 255, 255, 0.18 ); display: inline-block;">💸 Создать массовую акцию</div><br><br>
<form method="POST" action="/admin/?page=sales">
    <label for="name">Название</label>
    <input type="text" name="name" placeholder="Акция" required>
    <label for="sale">Скидка (в %)</label>
    <input type="number" name="sale" placeholder="100" required max="100">
    <label for="daten">Дата начала</label>
    <input type="date" name="daten"  required >
    <label for="datek">Дата окончания</label>
    <input type="date" name="datek" required >
    <style type="text/css">
        .df {
            border: 1px solid rgba( 255, 255, 255, 0.18 );
            transition: 0.25s;
        }
        .dsd-sel {
            border: 1px solid rgba( 255, 255, 255, 0.7 );
            transition: 0.25s;
        }
    </style>
    <script type="text/javascript">
        $(function(){
            $(".df").click(function(){
                if ($(this).attr('data-sel') == "false") {
                    $(this).addClass("dsd-sel");
                    $(this).attr('data-sel', 'true');
                }
                else  {
                    $(this).removeClass("dsd-sel");
                    $(this).attr('data-sel', 'false');
                    
                }
                const itemId = $(this).data('id');

        // Получаем текущее значение скрытого поля формы (ваш JSON)
        let currentJson = $('#jsonInput').val();

        // Преобразуем текущий JSON (если он существует) в массив
        let jsonArray = currentJson ? JSON.parse(currentJson) : [];

        // Ищем индекс элемента в массиве
        const index = jsonArray.indexOf(itemId);

        if (index === -1) {
            // Если значение не найдено, добавляем его в массив
            jsonArray.push(itemId);
        } else {
            // Если значение найдено, удаляем его из массива
            jsonArray.splice(index, 1);
        }

        // Преобразуем массив обратно в JSON
        let newJson = JSON.stringify(jsonArray);

        // Устанавливаем новое значение скрытого поля формы
        $('#jsonInput').val(newJson);
            });
        });
    </script>
    <label>Выберите товары</label><br>
    <input type="hidden" name="donatelisr" value="" id="jsonInput">
    <?php foreach($donate as $rd): ?>
        <div style="border-radius: 12px;
 display: inline-block; padding: 2px 15px; cursor: pointer; margin-top: 10px;" data-sel="false" data-id="<?php echo $rd->id; ?>" class="df"><?php echo $rd->name; ?></div>
    <?php endforeach; ?>
    <button type="submit" class="<?php echo $color->color; ?>" name="createsale">Создать</button>
</form>
                </div>
            </div>
            <div class="col">
                <?php function datef($date1) {
                            $date = DateTime::createFromFormat('Y-m-d', $date1);

// Форматируем дату в новый формат
$newFormat = $date->format('d.m.Y');
return $newFormat;

                        } ?>
                <?php foreach($sales as $cds): ?>
                    <div class="block">
                        <h3 class="logo"><?php echo $cds->name; ?> <?php if ($cds->datek < date("Y-m-d")) {
                            echo "(завершилась)";
                        } ?></h3>
                        <hr>
                        
                        Скидка: <?php echo $cds->sale; ?>%<br>
                        Дата начала: <?php echo datef($cds->daten); ?><br>
                        Дата окончания: <?php echo datef($cds->datek); ?><br>
                        <form action="/admin/?page=sales" method="POST">
                            <input type="hidden" name="id" value="<?php echo $cds->id; ?>">
                            <button type="submit" name="delsales" class="del-btn">Удалить</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endif;?>








</div>
    </div>
   </div>





</body>
</html>