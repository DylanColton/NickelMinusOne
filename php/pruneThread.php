<?php
	require("{$_SERVER['DOCUMENT_ROOT']}/php/globals.php");
	ini_set('error_log', '/var/www/nickelminusone/php/pruning.log');

	$conn	= mysqli_connect(SERVER, USER, PSWD, DATABASE);

	$boards = mysqli_query($conn, "SELECT * FROM Board");
	while ($board = mysqli_fetch_assoc($boards)) {
		$threads	= mysqli_query($conn, "SELECT * FROM Thread WHERE Board='{$board['BoardName']}' ORDER BY LastUpdate DESC");

		$ripe = 0;

		while($thread = mysqli_fetch_assoc($threads)) {
			$ripe++;

			$date = DateTime::createFromFormat('d/m/Y(D)H:i:s', $thread['LastUpdate']);
			$now  = time();
			$elapsed = $now - $date->getTimestamp();
			
			if ($elapsed > $board['PruneLimit'] || $ripe >= 100) {
				mysqli_query($conn, "UPDATE Thread SET PruneOrDeleted=1 WHERE ThreadNo={$thread['ThreadNo']}");
				exec("rm -rf ".escapeshellarg("$doc_root/board/{$board['BoardName']}/thread/{$thread['ThreadNo']}"), $output, $result);

				if ($result !== 0) {
					error_log("Failed to remove directory");
				}
			}
		}
	}

	mysqli_close($conn);
?>
