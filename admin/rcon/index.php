<?php 

require "../../config.php";
$conn = mysqli_connect($host, $login, $pass, $db);
$f = explode(':', $_COOKIE['login'], 2);
$login_to_find = $f[0];
$sql = "SELECT * FROM login WHERE login = '$login_to_find'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Найден пользователь
    while ($row = $result->fetch_assoc()) {
        // Проверка значения id
        if ($row['id'] != 1) {
          // Достаем и декодируем значение root
            $root_value = json_decode($row['root'], true);

            // Проверяем, не равно ли root9 ""
            if ($root_value['root9'] == "") {
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


?>
<!DOCTYPE HTML>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>RCON консоль</title>
    <link rel="stylesheet" type="text/css" href="static/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="static/css/style.css">
    <script type="text/javascript" src="static/js/jquery-1.12.0.min.js"></script>
    <script type="text/javascript" src="static/js/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="static/js/jquery-ui-1.12.0.min.js"></script>
    <script type="text/javascript" src="static/js/bootstrap.min.js" ></script>
    <script type="text/javascript" src="static/js/script.js" ></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
</head>
<body>

  <style type="text/css">
    body {
      background-color: rgba( 38, 38, 38, 1);
      padding: 20px;
    }
    .alert-success {
      border: 1px solid rgba(7, 181, 53, 1);
      border-radius: 15px;
      color: white;
      background: rgba(2, 174, 2, 0.2);
    }
    .alert-info {
      border: 1px solid rgba(7, 13, 181, 1);
      background: rgba(0, 96, 255, 0.2);
      border-radius: 15px;
      color: white;
    }
    .alert-danger {
     border: 1px solid rgba(166, 0, 0, 1);
      border-radius: 15px;
      color: white;
      background: rgba(218, 28, 7, 0.1);
    }
    .alert-warning {
      border: 1px solid rgba(166, 0, 0, 1);
      border-radius: 15px;
      color: white;
      background: rgba(218, 28, 7, 0.1);
    }
    .list-group-item-success {
      border: 1px solid rgba(7, 181, 53, 1);
          
      color: white;
      background: rgba(2, 174, 2, 0.2);
    }
    .list-group-item-info {
      border: 1px solid rgba(7, 13, 181, 1);
      background: rgba(0, 96, 255, 0.2);
      
      color: white;
    }
    .list-group-item-danger {
border: 1px solid rgba(166, 0, 0, 1);
      
      color: white;
      background: rgba(218, 28, 7, 0.1);
    }
    .list-group-item-warning {
      border: 1px solid rgba(166, 0, 0, 1);
      
      color: white;
      background: rgba(218, 28, 7, 0.1);
    }
    ::-webkit-scrollbar {
  background: rgba( 34, 34, 34, 0.25 );
  width: 5px;
}


::-webkit-scrollbar-thumb {
background: rgb( 45, 45, 45);
width: 5px;
border-radius: 20px;
}
  </style>



  <div class="container-fluid" id="content">
    <div class="alert alert-info" id="alertMessage">
      Ркон консоль
    </div>
    <div id="consoleRow" style="border:0px; border-radius: 20px;">
      <div class="panel panel-default" id="consoleContent" style="border: 0px; border-top-left-radius: 20px; border-top-right-radius: 20px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; color: white;">
        <div class="panel-heading" style="border: 0px; border-top-left-radius: 15px; border-top-right-radius: 15px; background-color: rgba( 41, 41, 41, 1); color: white;">
          <h3 class="panel-title pull-left"><span class="glyphicon glyphicon-console"></span> Консоль</h3>
        </div>
        <div class="panel-body" style="border: 0px; border-bottom-left-radius: 15px; border-bottom-right-radius: 15px; background-color: rgba( 47, 47, 47, 1);">
          <ul class="list-group" id="groupConsole"></ul>
        </div>
      </div>
      <div class="input-group" id="consoleCommand">
        <span class="input-group-addon" style="background-color: rgba( 41, 41, 41, 1); color: white; border: 0; border-top-left-radius: 15px; border-bottom-left-radius: 15px;">
          <input id="chkAutoScroll" type="checkbox" checked="true" autocomplete="off" /><span class="glyphicon glyphicon-arrow-down"></span>
        </span>
        <div id="txtCommandResults" ></div>
        <input type="text" class="form-control" id="txtCommand" style="border: 0px; background-color: rgba( 46, 46, 46, 0.8); color: white;">
        <div class="input-group-btn">
          <button type="button" class="btn btn-primary" id="btnSend" style="border: 1px solid rgba(7, 13, 181, 1);
      background: rgba(0, 96, 255, 0.2);"><span class="glyphicon glyphicon-send"></span><span class="hidden-xs"> Отправить</span></button>
          <button type="button" class="btn btn-warning" id="btnClearLog" style="border: 1px solid rgba(166, 0, 0, 1);
      
      color: white;
      background: rgba(218, 28, 7, 0.1); border-top-right-radius: 15px; border-bottom-right-radius: 15px;"><span class="glyphicon glyphicon-erase"></span><span class="hidden-xs"> Очистить</span></button>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
