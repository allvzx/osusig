<?php
// Thanks to Cygnix
// Created by Lemmmy

spl_autoload_register(function($class_name) {
	$directory = 'class/';

	if (file_exists($directory . $class_name . '.php')) {
		require_once ($directory . $class_name . '.php');
		return;
	}
});

$api = new OsuAPI(getenv("OSU_APIKEY", true));

$user = $api->getUserForMode($_GET['uname'], isset($_GET['mode']) ? $_GET['mode'] : 0);

if (!$user) {
	$errorImage = new ErrorImage();
	$errorImage->generate("User not found", "The user you tried to generate \na signature for was not found.");
}

$colour = isset($_GET['colour']) && !empty($_GET['colour']) ? $_GET['colour'] : 'pink';

$sig = new OsuSignature($user, 'TemplateNormal');
$sig->generate(PredefinedColours::getPredefinedColour($colour));