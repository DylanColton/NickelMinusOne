<?php
	require("{$_SERVER['DOCUMENT_ROOT']}/php/globals.php");

	$reloc	= $_POST['reloc'];
	$media	= $_POST['media'];
	$thumb	= $_POST['thumb'] == "true" ? true : false;
	$conn	= mysqli_connect(SERVER, USER, PSWD, DATABASE);
	$type	= mysqli_query($conn, "SELECT Type FROM Media WHERE MediaID=".intval(preg_replace("/(_thumb.+|\..+)/", "", $media)))->fetch_all()[0][0];

	if ($thumb)
		$replaceMedia = preg_replace("/_thumb/", "", $media);
	else
		$replaceMedia = preg_replace("/\./", "_thumb.", $media);

	if (in_array($type, $images) || !$thumb)
		echo "<img onclick=swapMedia(event) src=\"$reloc$replaceMedia\" />";
	elseif (in_array($type, $audio))
		echo "audio";
	elseif (in_array($type, $videos))
		echo "video";
?>
