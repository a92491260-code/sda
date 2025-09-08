$(document).ready(function(){

  $("#txtCommand").bind("enterKey",function(e){
    sendCommand($("#txtCommand").val());
  });

  $("#txtCommand").keyup(function(e){
    if(e.keyCode == 13){
      $(this).trigger("enterKey");
      $(this).val("");
    }
  });

  $("#btnSend").click(function(){
    if($("#txtCommand").val() != ""){
      $("#btnSend").prop("disabled", true);
    }
    sendCommand($("#txtCommand").val());
  });

  $("#btnClearLog").click(function() {
    $("#groupConsole").empty();
    alertInfo("Консоль была очищена");
  });
  
  var autocompleteCommands = [
      "achievement give *",
      "achievement give * <игрок>",
      "achievement give <имя>",
      "achievement give <имя> <игрок>",
      "achievement take *",
      "achievement take * <игрок>",
      "achievement take <имя>",
      "achievement take <имя> <игрок>",
      "ban <имя>",
      "ban <имя> <причина>",
      "ban-ip <айпи>",
      "ban-ip <имя>",
      "ban-ip <айпи> <причина>",
      "ban-ip <имя> <причина>",
      "banlist",
      "clear",
      "clear <игрок>",
      "debug start",
      "debug stop",
      "defaultgamemode survival",
      "defaultgamemode creative",
      "defaultgamemode adventure",
      "defaultgamemode spectator",
      "deop <игрок>",
      "difficulty peaceful",
      "difficulty easy",
      "difficulty normal",
      "difficulty hard",
      "effect <игрок> clear",
      "execute <сущность> <x> <y> <z> <команда>",
      "gamemode survival",
      "gamemode survival <игрок>",
      "gamemode creative",
      "gamemode creative <игрок>",
      "gamemode adventure",
      "gamemode adventure <игрок>",
      "gamemode spectator",
      "gamemode spectator <игрок>",
      "gamerule <правило> <значение>",
      "give <игрок> <предмет>",
      "give <игрок> <предмет> <кол-во>",
      "help",
      "help <команда>",
      "help <страница>",
      "kick <игрок>",
      "kick <игрок> <причина>",
      "kill",
      "kill <игрок>",
      "list",
      "list <uuids>",
      "locate EndCity",
      "locate Fortress",
      "locate Mansion",
      "locate Mineshaft",
      "locate Monument",
      "locate Stronghold",
      "locate Temple",
      "locate Village",
      "me <действие>",
      "op <игрок>",
      "pardon <игрок>",
      "pardon-ip <айпи>",
      "publish",
      "save-all",
      "save-off",
      "save-on",
      "say <сообщение>",
      "seed",
      "setidletimeout <minutes>",
      "setworldspawn",
      "setworldspawn <x> <y> <z>",
      "spawnpoint",
      "spawnpoint <игрок>",
      "spawnpoint <игрок> <x> <y> <z>",
      "stop",
      "summon <сущность>",
      "summon <сущность> <x> <y> <z>",
      "teleport <сущность> <x> <y> <z>",
      "tell <игрок> <сообщение>",
      "tellraw <игрок> <json-сообщение>",
      "testfor <игрок>",
      "time <add> <значение>",
      "time <query> <значение>",
      "time <set> <значение>",
      "title <игрок> clear",
      "title <игрок> reset",
      "toggledownfall",
      "tp <игрок>",
      "tp <игрок> <nигрок>",
      "tp <игрок> <x> <y> <z>",
      "weather <clear>",
      "weather <clear> <продолжительность>",
      "weather <rain>",
      "weather <rain> <продолжительность>",
      "weather <thunder>",
      "weather <thunder> <продолжительность>",
      "whitelist add <игрок>",
      "whitelist list",
      "whitelist off",
      "whitelist on",
      "whitelist reload",
      "whitelist remove <игрок>",
      "worldborder add <дистанция>",
      "worldborder add <дистанция> <время>",
      "xp <кол-во>",
      "xp <кол-во> <игрок>",
      "xp <кол-во>L",
      "xp <кол-во>L <игрок>"
    ].sort();;
  $("#txtCommand").autocomplete({
    source: autocompleteCommands,
    appendTo: "#txtCommandResults",
    open: function() {
      var position = $("#txtCommandResults").position(),
          left = position.left, 
          top = position.top,
          width = $("#txtCommand").width(),
          height = $("#txtCommandResults > ul").height();
      $("#txtCommandResults > ul")
        .css({
          left: left + "px",
          top: top - height - 4 + "px",
          width: 43 + width + "px"
        });
    }
  });
});

function logMsg(msg, sep, cls){
  var date = new Date(), 
      datetime = 
        ("0" + date.getDate()).slice(-2) + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + date.getFullYear() + " @ " +
        ("0" + date.getHours()).slice(-2) + ":" + ("0" + date.getMinutes()).slice(-2) + ":" + ("0" + date.getSeconds()).slice(-2);
  $("#groupConsole")
    .append("<li class=\"list-group-item list-group-item-" + cls + "\"><span class=\"pull-right label label-" + cls + "\">" + datetime + "</span><strong>" + sep + "</strong> " + msg + "<div class=\"clearfix\"></div></li>");
  $("#btnSend").prop("disabled", false);
  // Clear old logs
  var logItemSize = $("#groupConsole li").size();
  if(logItemSize > 50){
    $("#groupConsole li:first").remove();
  }
  // Scroll down
  if($("#chkAutoScroll").is(":checked")){
    $("#consoleContent .panel-body").scrollTop($("#groupConsole").get(0).scrollHeight);
  }
}
function logSuccess(log){
  logMsg(log, "<", "success");
}
function logInfo(log){
  logMsg(log, "<", "info");
}
function logWarning(log){
  logMsg(log, "<", "warning");
}
function logDanger(log){
  logMsg(log, "<", "danger");
}

function alertMsg(msg, cls){
  $("#alertMessage").fadeOut("slow", function(){
    $("#alertMessage").attr("class", "alert alert-"+cls);
    $("#alertMessage").html(msg);
    $("#alertMessage").fadeIn("slow", function(){});
  });
}
function alertSuccess(msg){
  alertMsg(msg, "success");
}
function alertInfo(msg){
  alertMsg(msg, "info");
}
function alertWarning(msg){
  alertMsg(msg, "warning");
}
function alertDanger(msg){
  alertMsg(msg, "danger");
}

function sendCommand(command){
  if (command == "") {
    alertDanger("Введите команду");
    return;
  }
  logMsg(command, ">", "success");
  $.post("rcon/index.php", { cmd: command })
    .done(function(json){
      if(json.status){
        if(json.status == 'success' && json.response && json.command){
          if(json.response.indexOf("Unknown command") != -1){
            alertDanger("Unknown command : " + json.command); 
            logDanger(json.response);
          }
          else if(json.response.indexOf("Usage") != -1){
            alertWarning(json.response); 
            logWarning(json.response);
          }
          else{
            alertSuccess("Успешно");
            logInfo(json.response);
          }
        }
        else if(json.status == 'error' && json.error){
          alertDanger(json.error); 
          logDanger(json.error);
        }
        else{
          alertDanger("Неверный ответ RCON API"); 
          logDanger("Неверный ответ RCON API");
        }
      }
      else{
        alertDanger("Ошибка RCON API (статус не возвращается)"); 
        logDanger("Ошибка RCON API (статус не возвращается)");
      }
    })
    .fail(function() {
      alertDanger("Ошибка RCON");
      logDanger("Ошибка RCON");
    });
}
