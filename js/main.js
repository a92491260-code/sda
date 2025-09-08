
// копи айпи
function copyText(id, c) {
	var text = document.getElementById(id).innerText;
	var elem = document.createElement("textarea");
	document.body.appendChild(elem);
	elem.value = text;
	elem.select();
	document.execCommand("copy");
	document.body.removeChild(elem);
	$(".ico").text("OK");
	setTimeout(function() {
	$(".ico").html('<i class="fa-solid fa-copy "></i>');
	}, 1500);
}

$(function() {
	var ip = $("#ip").text();
	$(".je").html(ip);

	//  MinecraftAPI.getServerStatus(ip, {
    //     // port: 25565 
    // }, function (err, status, online) {
    //     if (err) {
    //         return document.querySelector('.status').innerHTML = 'Оффлайн';
    //     }
    //     document.querySelector('.status').innerHTML = status.online ? 'Онлайн '+status.players.now+' из '+status.players.max : 'Оффлайн';
    //     document.querySelector('.version').innerHTML = status.online ? 'Версия '+status.server.name : '';
    //     document.querySelector('.circle-online').innerHTML = status.online ? status.players.now : '-';
    // });

    var iframe = $('#iframe', parent.document.body);
    iframe.height($(document.body).height());
});
