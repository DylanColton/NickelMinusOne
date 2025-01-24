<?php
	require("{$_SERVER['DOCUMENT_ROOT']}/php/globals.php");

	$conn = mysqli_connect(SERVER, USER, PSWD, DATABASE);

	var_dump($_POST);

	$boardname		= $_POST['BoardName'];
	$description	= $_POST['Description'];
	$pruneLimit		= min($_POST['PruneLimit'], 2_419_200);
	$fileSizeLimit	= min($_POST['FileSizeLimit'], 5_000_000);

	mysqli_query($conn, "INSERT INTO Board (BoardName, BoardDesc, PruneLimit, FileSizeLimit) VALUES ('$boardname', '$description', $pruneLimit, $fileSizeLimit);");
	echo "Made a new board\n";

	exec("mkdir $doc_root/board/$boardname");
	echo "New folder for board\n";
	exec("mkdir $doc_root/board/$boardname/catalog");
	echo "Catalog for board\n";
	exec("mkdir $doc_root/board/$boardname/thread");
	echo "Thread location for board\n";
	exec("cp $doc_root$struct_loc/index.php $doc_root/board/$boardname/index.php");
	echo "index for board\n";
	exec("cp $doc_root$struct_loc/index.php $doc_root/board/$boardname/catalog/index.php");
	echo "index for the catalog for board\n";

	mysqli_close($conn);
?>
