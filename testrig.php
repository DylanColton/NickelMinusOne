<?php
	require("{$_SERVER['DOCUMENT_ROOT']}/php/globals.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<?php include("$doc_root$static_loc/head.phtml"); ?>

		<title>Test Rig</title>

		<style>
			html {
				width		: 100vw;
				height		: 100vh;
				background	: #000000;
				display: flex;
				justify-content: center;
				align-items: center;
			}

			body {
				width		: 70vw;
				min-height	: 1vh;
				height		: 80vh;
				background	: #FFFFFF;
			}
		</style>

		<?php
			function formatSize($size, $div) {
				$formatted_size = $size / $div;
				if ($formatted_size >= 100)
					$formatted_size = number_format($size, 0, '.', '');
				elseif ($formatted_size >= 10)
					$formatted_size = number_format($size, 1, '.', '');
				else
					$formatted_size = number_format($size, 2, '.', '');
				return $formatted_size;
			}
		?>
		<?php include("$doc_root/php/resize.php"); ?>
	</head>

	<body>
		<?php
			echo "<div class=thread>";

			$op				= true;
			$datetime		= '13/01/2025(Mon)13:00:00';
			$title			= "A Thread";
			$name			= "";
			$num			= 1;
			$replies		= [4];
			$file			= 1;
			$fileName		= "kms.jpg";
			$fileNum		= "1_thumb";
			$fileType		= ".jpg";
			$fileDim		= "680x561";
			$fileSize		= 43167;
			$formattedSize	= 0;
			if ($fileSize >= 1000000) {
				$formattedSize /= 1000000;
				number_format($formattedSize, 2, '.', '');
				$formattedSize = $formattedSize."MB";
			} else if ($fileSize >= 1000) {
				$formattedSize = formatSize($fileSize, 1000);
				$formattedSize = $formattedSize."kB";
			} else {
				$fileSize = $fileSize."B";
			}
			$message	= "I think I'm at the end of my life";
			include("$doc_root$struct_loc/post.phtml");

			$op				= false;
			$datetime		= '13/01/2025(Mon)13:15:07';
			$title			= "";
			$name			= "";
			$num			= 2;
			$replies		= [];
			$file			= 2;
			$fileName		= "gotoreddit.jpg";
			$fileNum		= "2_thumb";
			$fileType		= ".png";
			$fileDim		= "285x208";
			$fileSize		= 62531;
			$formattedSize	= 0;
			if ($fileSize >= 1000000) {
				$formattedSize /= 1000000;
				number_format($formattedSize, 2, '.', '');
				$formattedSize = $formattedSize."MB";
			} else if ($fileSize >= 1000) {
				$formattedSize = formatSize($fileSize, 1000);
				$formattedSize = $formattedSize."kB";
			} else {
				$fileSize = $fileSize."B";
			}
			$message	= ">Talks about suicide.\n(go to reddit)[reddit.com]";
			include("$doc_root$struct_loc/post.phtml");
			

			$op				= false;
			$datetime		= '13/01/2025(Mon)13:15:43';
			$title			= "";
			$name			= "Chad Thaddius";
			$num			= 3;
			$replies		= [];
			$file			= 3;
			$fileName		= "you rn.mp4";
			$fileNum		= "3_thumb";
			$fileType		= ".jpg";
			$fileDim		= "480x480";
			$fileSize		= 240865;
			$formattedSize	= 0;
			if ($fileSize >= 1000000) {
				$formattedSize /= 1000000;
				number_format($formattedSize, 2, '.', '');
				$formattedSize = $formattedSize."MB";
			} else if ($fileSize >= 1000) {
				$formattedSize = formatSize($fileSize, 1000);
				$formattedSize = $formattedSize."kB";
			} else {
				$fileSize = $fileSize."B";
			}
			$message	= "This is you";
			include("$doc_root$struct_loc/post.phtml");


			$op				= false;
			$datetime		= '13/01/2025(Mon)13:16:02';
			$title			= "";
			$name			= "";
			$num			= 4;
			$replies		= [];
			$file			= 0;
			$fileName		= "";
			$fileNum		= "";
			$fileType		= "";
			$fileDim		= "";
			$fileSize		= 0;
			$formattedSize	= 0;
			if ($fileSize >= 1000000) {
				$formattedSize /= 1000000;
				number_format($formattedSize, 2, '.', '');
				$formattedSize = $formattedSize."MB";
			} else if ($fileSize >= 1000) {
				$formattedSize = formatSize($fileSize, 1000);
				$formattedSize = $formattedSize."kB";
			} else {
				$fileSize = $fileSize."B";
			}
			$message	= "Don't kill yourself. At least see what's good, and try not to veer into the dark";
			include("$doc_root$struct_loc/post.phtml");

			echo "</div>";
		?>
	</body>
</html>
