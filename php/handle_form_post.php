<?php
	require("{$_SERVER['DOCUMENT_ROOT']}/php/globals.php");
	include("$doc_root/php/handle_posted_media.php");

	$conn = mysqli_connect(SERVER, USER, PSWD, DATABASE);

	$datetime		= date('Y/m/d(D)H:i:s');
	$board			= $_POST['board'];
	echo $board;

	if ($_POST['make'] == "THREAD") {
		// Make a new thread
		$post_title		= $_POST['title'];
		$post_name		= $_POST['name'];

		$post_message	=	$_POST['message'];

		$new_post_id	= mysqli_query($conn, "SELECT PostID FROM Post ORDER BY PostID DESC LIMIT 1")->fetch_all()[0][0] + 1;
		$thread_query	= "INSERT INTO Thread (ThreadNo, Board, LastUpdate, PruneOrDeleted)
			VALUES ($new_post_id, $board, $datetime, FALSE)";

		if ($_FILES['uploaded_file']) {
			list($media_name, $media_type, $media_size, $media_dim) = collectMetaData($_FILES['uploaded_file'], $images, $audio, $videos);
			$media_query	= "INSERT INTO Media (MediaName, Type, Size, Dim)
				VALUES ($media_name, $media_type, $media_size, $media_dim);";
			$media_id = mysqli_insert_id($conn);
		}
		
		$post_query		= "INSERT INTO Post (Type, ThreadID, Title, Name, PostTime, Media, Message)
			VALUES (TRUE, $new_post_id, $post_title, $post_name, $datetime, $media_id, $post_message)";

		move_uploaded_file($_FILES['uploaded_file']['tmp_name'], "$doc_root/board/$board/thread/$new_post_id/media/$media_id.$media_type");
	} else if ($_POST['make'] == "POST") {
		// Make a new post
		$post_name		= $_POST['name'];
		$post_message	= $_POST['message'];

		if ($_FILES['uploaded_file']) {
			list($media_name, $media_type, $media_size, $media_dim) = collectMetaData($_FILES['uploaded_file'], $images, $audio, $videos);
			$media_query	= "INSERT INTO Media (MediaName, Type, Size, Dim)
				VALUES ($media_name, $media_type, $media_size, $media_dim);";
			$media_id = mysqli_insert_id($conn);
		}

		$post_query		= "";
	} else {
		echo "Something unexpected happened. You wouldn't happen to have tried to mess with my system, would you?";
	}
?>
