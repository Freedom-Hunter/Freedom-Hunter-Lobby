<?php

// Freedom Hunter lobby.
// This script adds a server to the lobby.

include "FHLobby.php";

$lobby = new FHLobby();

if (isset($_GET['cmd'])) {
	$cmd = $_GET['cmd'];
	if ($cmd == 'register_server') {
		if (! (isset($_GET['hostname']) && isset($_GET['port']) && isset($_GET['max_players']))) {
			echo "You must specify hostname, port and max_players\n";
			set_response_code(400);
		} else {
			$result = $lobby->register_server($_GET['hostname'], $_GET['port'], $_GET['max_players']);
			if (! $result)
				set_response_code(400);
			else
				echo json_encode($result);
		}
	} elseif ($cmd == 'unregister_server') {
		if (!isset($_GET['id'])) {
			echo "You must specify a server ID\n";
			set_response_code(400);
		} else {
			echo json_encode($lobby->unregister_server($_GET['id']));
		}
	} elseif ($cmd == 'list_servers') {
		echo json_encode($lobby->list_servers());
	} elseif ($cmd == 'register_player') {
		if (! (isset($_GET['name']) && isset($_GET['server']) && isset($_GET['status']))) {
			echo "You must specify name, server and status\n";
			set_response_code(400);
		} else {
			$result = $lobby->register_player($_GET['name'], $_GET['server'], $_GET['status']);
			if (! $result)
				set_response_code(400);
			else
				echo json_encode($result);
		}
	} elseif ($cmd == 'unregister_player') {
		if (!isset($_GET['id'])) {
			echo "You must specify a player ID\n";
			set_response_code(400);
		} else {
			echo json_encode($lobby->unregister_player($_GET['id'])) . PHP_EOL;
		}
	} elseif ($cmd == 'list_players') {
		echo json_encode($lobby->list_players()) . PHP_EOL;
	} else {
		echo "Unknown command!\n";
		http_response_code(400);
	}
} else {
	echo "You must specify a command.\n";
	http_response_code(400);
}
?>
