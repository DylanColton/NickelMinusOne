<?php
	require("{$_SERVER['DOCUMENT_ROOT']}/php/globals.php");

	function escapeSQL($entry) {
		$escapeChars = [
			"'"		=> "\'",
			"\\"	=> "\\\\",
			"\0"	=> "\\0",
			"\r"	=> "\\r"
		];

		foreach ($escapeChars as $k => $v)
			$entry = preg_replace("/".preg_quote($k)."/", $v, $entry);

		return $entry;
	}

	$conn = mysqli_connect(SERVER, USER, PSWD, DATABASE);

	$datetime		= date('Y/m/d(D)H:i:s');
	$board			= $_POST['board'];

	// MOVE THE INSERTS TO AFTER THE FILE STRUCTURE IS MADE
	if ($_POST['make'] == "THREAD") {
		// Make a new thread
		$post_title		= $_POST['title'];
		$post_name		= $_POST['name'];

		$post_message	=	$_POST['message'];

		$res	= mysqli_query($conn, "SELECT PostID FROM Post ORDER BY PostID DESC LIMIT 1");
		if ($res && $res->num_rows > 0)
			$new_post_id = $res->fetch_assoc()['PostID'] + 1;
		else
			$new_post_id = 1;

		$thread_query	= "INSERT INTO Thread (ThreadNo, Board, LastUpdate, PruneOrDeleted)
			VALUES ($new_post_id, '$board', '$datetime', 0)";
		
		mysqli_query($conn, $thread_query);

		list($media_name, $media_type, $media_size, $media_dim) = collectMetaData($_FILES['uploaded_file'], $images, $audio, $videos);
		$media_name = escapeSQL($media_name);
		$media_query	= "INSERT INTO Media (MediaName, Type, Size, Dim)
			VALUES ('$media_name', '$media_type', $media_size, '$media_dim');";

		mysqli_query($conn, $media_query);

		$media_id = mysqli_insert_id($conn);

		// Clean all the weird text
		$post_title		= escapeSQL($post_title);
		$post_name		= escapeSQL($post_name);
		$post_message	= escapeSQL($post_message);
		$post_query		= "INSERT INTO Post (Type, ThreadID, Title, Name, PostTime, Media, Message)
			VALUES (1, $new_post_id, '$post_title', '$post_name', '$datetime', $media_id, '$post_message')";

		mysqli_query($conn, $post_query);

		exec("mkdir ".escapeshellarg("$doc_root/board/$board/thread/$new_post_id")." ".escapeshellarg("$doc_root/board/$board/thread/$new_post_id/media"));
		exec("cp ".escapeshellarg("$doc_root/$struct_loc/index.php")." ".escapeshellarg("$doc_root/board/$board/thread/$new_post_id/index.php"));

		$new_file = "$doc_root/board/$board/thread/$new_post_id/media/$media_id.$media_type";
		move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $new_file);
		resizeImage($new_file, $videos, $audio);

		$thread_no = $new_post_id;
	} else if ($_POST['make'] == "POST") {
		// Make a new post
		$post_name		= $_POST['name'];
		$post_message	= $_POST['message'];
		$thread_no		= $_POST['thread_no'];
		$media_id		= 0;

		if ($_FILES['uploaded_file']['error'] == 0) {
			list($media_name, $media_type, $media_size, $media_dim) = collectMetaData($_FILES['uploaded_file'], $images, $audio, $videos);
			$media_query	= "INSERT INTO Media (MediaName, Type, Size, Dim)
				VALUES ('$media_name', '$media_type', $media_size, '$media_dim');";
			
			mysqli_query($conn, $media_query);
			$media_id = mysqli_insert_id($conn);

			$new_file = "$doc_root/board/$board/thread/$thread_no/media/$media_id.$media_type";
			move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $new_file);
			resizeImage($new_file, $videos, $audio);
		}

		$post_query		= "INSERT INTO Post (Type, ThreadID, Name, PostTime, Media, Message)
			VALUES (0, $thread_no, '$post_name', '$datetime', $media_id, '$post_message')";

		mysqli_query($conn, $post_query);
	} else {
		echo "Something unexpected happened. You wouldn't happen to have tried to mess with my system, would you?";
	}

	header("Location: /board/$board/thread/$thread_no");
?>
