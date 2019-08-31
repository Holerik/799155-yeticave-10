<?php
require_once('dbinit.php');
require_once('functions.php');

ini_set('session.cookie_lifetime', 3600);
ini_set('session.gc_maxlifetime', 3600);  
session_start();

$pageName = 'YetiCave';
$user_name = ''; // укажите здесь ваше имя
$is_auth = 0;

if (isset($_SESSION['sess_id'])) {
    $user_id = $_SESSION['sess_id'];
}

if (isset($_SESSION['sess_name'])) {
    $user_name = $_SESSION['sess_name'];
    $is_auth = 1;
}

$avatar = "";
if (isset($_SESSION['avatar'])) {
    $avatar = $_SESSION['avatar'];
}

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


