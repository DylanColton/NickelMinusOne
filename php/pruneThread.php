<?php
	$conn			= mysqli_connect(SERVER, USER, PSWD, DATABASE);

	$boards = mysqli_query($conn, "SELECT * FROM Boards");
	while ($board = mysqli_fetch_assoc($boards)) {
		$threads	= mysqli_query($conn, "SELECT * FROM Thread WHERE Board=$board ORDER BY LastUpdate DESC")->fetch_all();

		$ripe = 0;

		while($thread = mysqli_fetch_assoc($threads)) {
			$ripe++;

			$date = DateTime::createFromFormat('d/m/Y(D)H:i:s', $thread['LastUpdate']);
			$now  = time();
			$elapsed = $now - $date->getTimestamp();
			
			if ($elapsed > $board['PruneLimit'] || $ripe >= 100) {
				mysqli_query($conn, "UPDATE Thread WHERE SET PruneOrDeleted=1 ThreadNo={$thread['ThreadNo']}");
				exec("rm -rf ".escapeshellarg("$doc_root/board/$board/thread/{$thread['ThreadNo']}"), $output, $result);

				if ($result !== 0) {
					error_log("Failed to remove directory");
				}
			}
		}
	}

	mysqli_close($conn);
?>
