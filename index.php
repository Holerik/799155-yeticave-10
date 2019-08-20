<?php
require_once('dbinit.php');
require_once('functions.php');


$pageName = 'YetiCave';
$user_name = 'Александр'; // укажите здесь ваше имя
$is_auth = rand(0, 1);


$header_content = include_template('header.php', [
	'title' => $pageName,
	'user_name' => $user_name,
	'is_auth' => $is_auth
]);

$main_content =  include_template('main.php', [
    'catsArray' => $catsArray,
    'catsInfoArray' => $catsInfoArray
]);

$footer_content = include_template('footer.php', [
	'catsArray' => $catsArray
]);

$layout_content = include_template('layout.php', [
	'title' => $pageName,
    'header_content' => $header_content,
    'main_content' => $main_content,
    'footer_content' => $footer_content
]);

print($layout_content);


