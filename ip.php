<?php

echo json_encode(
	array(
		'ip' => $_SERVER['REMOTE_ADDR'],
		'host' => gethostbyaddr($_SERVER['REMOTE_ADDR'])
	)
) . PHP_EOL;

?>
