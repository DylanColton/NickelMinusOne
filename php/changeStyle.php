<?php
require("{$_SERVER['DOCUMENT_ROOT']}/php/globals.php");

$sty	= $_GET['style'];
$return	= $_GET['return'];

setcookie("style", $sty, time() + ONE_YEAR, "/", WEBSITE, true, true);
?>
