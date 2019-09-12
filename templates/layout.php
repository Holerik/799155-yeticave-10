<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?=$title;?></title>
    <link href="../css/normalize.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
	<style type="text/css">
       .avatar__img {
            width: 50px;
            height: 50px;
            margin-right: 8px;  
        }
	</style>
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
