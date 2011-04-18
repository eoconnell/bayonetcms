<?php

$server_ip = "123.123.123.123";
$server_port = "12345";
$feed = fopen("http://module.game-monitor.com/$server_ip:$server_port/data/server.php","r");
$tmp = fgets($feed);
$server = unserialize($tmp);

OpenBlock("Game Server");
echo "<div style=\"margin:5px;\">\n
<a href=\"{$server->link}\">{$server->name}</a><br/>\n
IP: {$server->ip}:{$server->port}<br/>\n
Players: {$server->player}/{$server->maxplayer}<br/>\n
</td></tr>\n
</div>\n";
CloseBlock();

?>
