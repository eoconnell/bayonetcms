<?php

$feed = fopen("http://module.game-monitor.com/216.245.211.59:28910/data/server.php","r");
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