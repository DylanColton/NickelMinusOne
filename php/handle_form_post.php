<?php
	require("{$_SERVER['DOCUMENT_ROOT']}/php/globals.php");

	$conn = mysqli_connect(SERVER, USER, PSWD, DATABASE);

	$datetime		= date('Y/m/d(D)H:i:s');
	$board			= $_POST['board'];

	if ($_POST['make'] == "THREAD") {
		// Make a new thread
		$post_title		= $_POST['title'];
		$post_name		= $_POST['name'];

		$post_message	=	$_POST['message'];

		$new_post_id	= mysqli_query($conn, "SELECT PostID FROM Post ORDER BY PostID DESC LIMIT 1")->fetch_all()[0][0] + 1;

		$thread_query	= "INSERT INTO Thread (ThreadNo, Board, LastUpdate, PruneOrDeleted)
			VALUES ($new_post_id, '$board', '$datetime', 0)";
		
		mysqli_query($conn, $thread_query);

		list($media_name, $media_type, $media_size, $media_dim) = collectMetaData($_FILES['uploaded_file'], $images, $audio, $videos);
		$media_query	= "INSERT INTO Media (MediaName, Type, Size, Dim)
			VALUES ('$media_name', '$media_type', $media_size, '$media_dim');";

		mysqli_query($conn, $media_query);

		$media_id = mysqli_insert_id($conn);
		$post_query		= "INSERT INTO Post (Type, ThreadID, Title, Name, PostTime, Media, Message)
			VALUES (1, $new_post_id, '$post_title', '$post_name', '$datetime', $media_id, '$post_message')";

		mysqli_query($conn, $post_query);

		exec("mkdir ".escapeshellarg("$doc_root/board/$board/thread/$new_post_id")." ".escapeshellarg("$doc_root/board/$board/thread/$new_post_id/media"));
		exec("cp ".escapeshellarg("$doc_root/$struct_loc/index.php")." ".escapeshellarg("$doc_root/board/$board/thread/$new_post_id/index.php"));

		$new_file = "$doc_root/board/$board/thread/$new_post_id/media/$media_id.$media_type";
		move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $new_file);
		resizeImage($new_file, $videos, $audio);

		header("Location: /board/$board/thread/$new_post_id");
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

		header("Location: /board/$board/thread/$thread_no");
	} else {
		echo "Something unexpected happened. You wouldn't happen to have tried to mess with my system, would you?";
	}
?>
