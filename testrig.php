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
				width				: 100vw;
				height				: 100vh;
				background			: #000000;
				display				: flex;
				justify-content		: center;
				align-items			: center;
			}

			body {
				width		: 70vw;
				min-height	: 1vh;
				height		: 80vh;
				background	: #FFFFFF;
			}
		</style>

		<?php
		?>
	</head>

	<body>
		<div id='make-post' onclick=openForm()>[ <a href="#">Make a Post</a> ]</div>
		<?php include("$doc_root$struct_loc/post_form.phtml"); ?>
	</body>
</html>
