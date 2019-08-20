<?php
$user_name = 'Александр'; // укажите здесь ваше имя
$is_auth = rand(0, 1);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?=$title;?></title>
    <link href="../css/normalize.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<div class="page-wrapper">

<?=$header_content;?>
<?=$main_content;?>
<?=$footer_content;?>

<script src="flatpickr.js"></script>
<script src="script.js"></script>
</body>
</html>
