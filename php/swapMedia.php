<?php
	require("{$_SERVER['DOCUMENT_ROOT']}/php/globals.php");

	$reloc	= $_POST['reloc'];
	$media	= $_POST['media'];
	$thumb	= $_POST['thumb'] == "true" ? true : false;
	$conn	= mysqli_connect(SERVER, USER, PSWD, DATABASE);
	$type	= mysqli_query($conn, "SELECT Type FROM Media WHERE MediaID=".intval(preg_replace("/(_thumb.+|\..+)/", "", $media)))->fetch_all()[0][0];

	if ($thumb)
		$replaceMedia = preg_replace("/_thumb\..+/", ".$type", $media);
	else
		$replaceMedia = preg_replace("/\..+/", "_thumb.".(in_array($type, $images) ? $type : 'jpg'), $media);

	if (in_array($type, $images) || !$thumb)
		echo "<img onclick=swapMedia(event) src=\"$reloc$replaceMedia\" />";
	elseif (in_array($type, $audio))
		echo "<button class=close-media onclick=swapMedia(event) href=''> Close </button><audio src=\"$reloc$replaceMedia\" controls autoplay />";
	elseif (in_array($type, $videos))
		echo "<button class=close-media onclick=swapMedia(event) href=''> Close </button><video src=\"$reloc$replaceMedia\" controls autoplay />";
?>
