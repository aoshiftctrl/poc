<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require './vendors/Mustache/src/Mustache/Autoloader.php';
Mustache_Autoloader::register();

$m = new Mustache_Engine;
$m = new Mustache_Engine(array(
	'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/templates')
));

$app = array(
		"appname" => "me~°"
);

// templates laden
$header = $m->loadTemplate('header');
$apptitle = $m->loadTemplate('appname');

require("controllers/sqlite__db.php");
require("controllers/share__link.php");

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<title><?= $apptitle->render($app); ?></title>

		<meta charset="utf-8">
		<meta name="robots" content="noindex,nofollow">

<!-- iOS Support -->
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
  <link rel="apple-touch-icon" href="./app/img/app.png" />
<!-- iOS Support /end -->

	<link rel="stylesheet" href="./app/css/ui.min.css" charset="utf-8">
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" charset="utf-8">

	</head>

	<body>

	<?= $header->render($app); ?>

	<section>
	  <form name="journl" method="post" action="<?= $_SERVER["REQUEST_URI"]; ?>">
	    <input type="text" name="journl" value="" placeholder="say something nice" id="journlpost" />
	  </form>
	</section>

	<section id="path">
	<?php

	  $_article = new CrudDb();
	  $_article->FetchDb();

	?>
	</section>

	<section class="loading">
		<div>lade einträge</div>
	</section>

	<script type="text/javascript" src="./app/js/app.min.js"></script>
	</body>
</html>
