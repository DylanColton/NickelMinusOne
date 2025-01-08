<?php
// CONSTANTS
DEFINE("ONE_MINUTE",	60);
DEFINE("ONE_HOUR",		60	* ONE_MINUTE);
DEFINE("ONE_DAY",		24	* ONE_HOUR);
DEFINE("ONE_WEEK",		7	* ONE_DAY);
DEFINE("ONE_MONTH",		4	* ONE_WEEK);
DEFINE("ONE_YEAR",		12	* ONE_MONTH);

// Cookie
$cookie_options = array(
	'expires'	=> time() + ONE_YEAR,
	'path'		=> "/",
	'secure'	=> false,
	'samesite'	=> 'Lax'
);

// Locations
$struct_loc		= "/assets/phtml/struct";
$static_loc		= "/assets/phtml/static";
$web_ban_loc	= "/assets/banners/web/";
$board_ban_loc	= "/assets/banners/board/";
$ad_ban_loc		= "/assets/banners/ad/";
$style_loc		= "/css/";
$favicon_loc	= "/assets/favicons/";

$doc_root		= $_SERVER['DOCUMENT_ROOT'];
$uri			= explode("/", $_SERVER['REQUEST_URI']);
$ignore			= ['.', '..', '.htaccess', 'test', 'testrig.php'];
$images			= [
	'jpg',
	'jpeg',
	'gif',
	'png'
];
$videos			= [
	'webm',
	'mp4'
];
$title			= sizeof($uri)>2 ? ($uri[2] == "" ? "{$uri[1]}" : "/{$uri[2]}/") : "Nickel Minus One";
$favicon		= "favicon.png";
$lang			= "en";
$num_change_log	= 3;
$num_promo		= 10;
$struct			= "structure.css";
$default_style	= "001-template.css";
$charset		= "UTF-8";
$authour		= "\"Dylan Colton\"";
$desc			= "\"\"";

$styles			= array_slice(scandir("$doc_root/css"), 2);
for ($i = 0; $i < sizeof($styles); $i++) {
	if (strpos($styles[$i], '.') == 0 || in_array($styles[$i], $ignore))
		unset($styles[$i]);
}
$styles			= array_values($styles);
if (!isset($_COOKIE['style'])) {
	setcookie('style', $default_style, $cookie_option);
	$_COOKIE['style'] = $default_style;
}

$conn;
include("$doc_root/sql/db_init.php");
?>