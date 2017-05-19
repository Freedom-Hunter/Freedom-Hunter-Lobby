<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="description" content="Freedom Hunter Multiplayer Lobby">
<title>Freedom Hunter Multiplayer Lobby</title>
<link href="/assets/css/normalize.css" rel="stylesheet" type="text/css">
<link href="/assets/css/skeleton.css" rel="stylesheet" type="text/css">
<link href="/assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://code.cdn.mozilla.net/fonts/fira.css">
<link href="/assets/css/custom.css" rel="stylesheet" type="text/css">
<link rel="canonical" href="https://elinvention.ovh/fh/">
<link rel="icon" href="/assets/favicon.ico" sizes="16x16">
</head>
<body>

<div class="container">

<?php
include "FHLobby.php";

$lobby = new FHLobby();
?>

<h1><span class="fa fa-sitemap"></span> Freedom Hunter Multiplayer Lobby</h1>
<h2>Servers</h2>
<table>
<thead><tr><td>&nbsp;</td><td>ID</td><td>Hostname</td><td>Port</td><td>Max players</td><td>Added</td></tr></thead>
<tbody>
<?php
$servers = $lobby->list_servers();
$fields = array('id', 'hostname', 'port', 'max_players', 'added');

foreach ($servers as $server) {
	echo '<tr><td><span class="fa fa-server" aria-hidden="true"></span></td>';
	foreach ($fields as $field) {
		echo "<td>${server[$field]}</td>";
	}
	echo '</tr>';
}

if (count($servers) == 0) {
	echo '<tr><td>&nbsp;</td>';
	foreach ($fields as $field) {
		echo '<td>-</td>';
	}
	echo '</tr>';
}

?>
</tbody>
</table>

<h2>Players</h2>
<table>
<thead><tr><td>&nbsp;</td><td>ID</td><td>Name</td><td>Server</td><td>Status</td></tr></thead>
<tbody>
<?php

$players = $lobby->list_players();
$fields = array('id', 'name', 'server', 'added');

foreach ($players as $player) {
	echo '<tr><td><span class="fa fa-server" aria-hidden="true"></span></td>';
	foreach ($fields as $field) {
		echo "<td>${player[$field]}</td>";
	}
	echo '</tr>';
}

if (count($players) == 0) {
	echo '<tr><td>&nbsp;</td>';
	foreach ($fields as $field) {
		echo '<td>-</td>';
	}
	echo '</tr>';
}

?>
</tbody>
</table>

<hr></hr>
<p>Copyright © 2016 <a href="https://elinvention.ovh/">Elia Argentieri</a></p>
<p>
  <a href="https://www.debian.org/"><img src="/assets/img/powered_debian.png" alt="Powered by Debian" target="_blank"></a>
  <a href="http://nginx.org/"><img src="/assets/img/powered_nginx.png" alt="Powered by NGINX" target="_blank"></a>
  <a href="http://mediagoblin.org/"><img src="/assets/img/powered_mediagoblin.png" alt="Powered by GNU Mediagoblin" target="_blank"></a>
</p>


</div>

</body>
</html>
