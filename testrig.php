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

		<?php include("$doc_root/php/resize.php"); ?>
		<?php
		?>
	</head>

	<body>
		<?php
			$thread_id		= 1;
			$num_replies	= 1;
			$num_media		= 1;
			$thr_title		= "The Title";
			$op_message		= "This is a message I am posting";
		?>
		<div id=catalog>
			<?php include("$doc_root$struct_loc/catalog_item.phtml"); ?>
			<?php include("$doc_root$struct_loc/catalog_item.phtml"); ?>
			<?php include("$doc_root$struct_loc/catalog_item.phtml"); ?>
			<?php include("$doc_root$struct_loc/catalog_item.phtml"); ?>
			<?php include("$doc_root$struct_loc/catalog_item.phtml"); ?>
			<?php include("$doc_root$struct_loc/catalog_item.phtml"); ?>
			<?php include("$doc_root$struct_loc/catalog_item.phtml"); ?>
		</div>
	</body>
</html>
