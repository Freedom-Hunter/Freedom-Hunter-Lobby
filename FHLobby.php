<?php

// Freedom Hunter lobby.

error_reporting(E_ALL);

const FILENAME = 'fhlobby.db';

function GET($key, $default = null) {
	return isset($_GET[$key]) ? $_GET[$key] : $default;
}

class FHLobby {
	private $db;

	function __construct() {
		try {
			$this->db = new SQLite3(FILENAME, SQLITE3_OPEN_READWRITE);
		} catch (Throwable $t) {
			$this->create_database();
		}
	}

	function create_database() {
		$this->db = new SQLite3(FILENAME, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
		echo "Creating a new database..." . PHP_EOL;
		$this->db->exec("
			CREATE TABLE `servers` (
				`id` INTEGER PRIMARY KEY AUTOINCREMENT,
				`hostname` VARCHAR(50) NOT NULL,
				`port` INTEGER NOT NULL,
				`added` DATETIME DEFAULT (datetime('now','localtime')),
				`max_players` INTEGER NOT NULL,
				CHECK (`port` <= 65535)
			);
			CREATE TABLE players (
				`id` INTEGER PRIMARY KEY AUTOINCREMENT,
				`name` VARCHAR(30) NOT NULL,
				`server` INTEGER NOT NULL,
				`status` VARCHAR(50),
				`added` DATETIME DEFAULT (datetime('now','localtime')),
				FOREIGN KEY(`id`) REFERENCES servers(`id`) ON DELETE CASCADE
			);
		");
	}

	function get_autoincrement($table) {
		$stmt = $this->db->prepare("SELECT seq FROM sqlite_sequence WHERE name = '$table';");
		$result = $stmt->execute();
		return $result->fetchArray(SQLITE3_NUM)[0];
	}

	function register_server($hostname, $port, $max_players) {
		$sql = "
			INSERT INTO servers (hostname, port, max_players) VALUES (
				'$hostname',
				$port,
				$max_players
		);";
		$result = $this->db->exec($sql);
		if (! $result)
			return false;
		return $this->get_autoincrement('servers');
	}

	function unregister_server($id) {
		$sql = "DELETE FROM servers WHERE id = $id;";
		return $this->db->exec($sql);
	}

	function list_servers() {
		$stmt = $this->db->prepare('SELECT s.*, COUNT(p.server) AS connected_players FROM servers AS s LEFT JOIN players AS p ON s.id = p.server GROUP BY s.id;');
		$result = $stmt->execute();

		$rows = array();
		while ($row = $result->fetchArray(SQLITE3_ASSOC))
		{
			$rows[] = $row;
		}
		return $rows;
	}

	function register_player($name, $server, $status) {
		$sql = "
			INSERT INTO players (name, server, status) VALUES (
				'$name',
				$server,
				'$status'
			);
		";
		$result = $this->db->exec($sql);
		if (! $result)
			return false;
		return $this->get_autoincrement('players');
	}

	function unregister_player($id) {
		$sql = "DELETE FROM players WHERE id = $id;";
		return $this->db->exec($sql);
	}

	function list_players() {
		$stmt = $this->db->prepare('SELECT * FROM players;');
		$result = $stmt->execute();

		$rows = array();
		while ($row = $result->fetchArray(SQLITE3_ASSOC))
		{
			$rows[] = $row;
		}
		return $rows;
	}
}
?>
