<?php
$error = "";
$host = 'localhost';

require_once('helpers.php');

//Соединяемся с БД
$yetiCave = new MySqliBase($host, 'root', '', 'yeticave10');

//Массив категорий
$catsArray = [];
//массив товаров
$catsInfoArray = [];

//Заполнение массива категорий из БД
if ($yetiCave->ok()) {
    $sql = "SELECT id, name, code FROM categories ORDER BY id";
    $result = $yetiCave->query($sql);
    if ($result) {
        $catsArray = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

if (!empty($yetiCave->error())) {
	$error = $yetiCave->error();
    header("Location:_404php?hdr=SQL error&msg=" . $yetiCave->error());
}

if (empty($error)) {
    //$sql = "SELECT COUNT(*) FROM lots l WHERE l.cat_id = $cat_id AND l.dt_fin > NOW()";
    $sql = "SELECT COUNT(*) FROM lots l";
    $result = $yetiCave->query($sql);
    if ($result) {
        $rows = mysqli_fetch_row($result);
        $lots_count = $rows[0];
		/*
        $offset_page = ($lot_page - 1) * $max_lots_per_page;
        $max_page = floor($lots_count / $max_lots_per_page);
        if ($lots_count % $max_lots_per_page > 0) {
            $max_page++;
        }   
		*/
    } else {
        $error = $yetiCave->error();
        header("Location:_404.php?hdr=SQL error&msg=" . $error);
    }
}

if ($lots_count > 0) {
	/*
    $sql = "SELECT l.name, c.name as cat_name, cat_id, l.price, img_url, l.id, l.dt_fin FROM lots l" .
    " JOIN categories c ON l.cat_id = c.id  WHERE l.cat_id = $cat_id AND l.dt_fin > NOW()" .
    " ORDER BY l.dt_add DESC" .
    " LIMIT $max_lots_per_page OFFSET $offset_page";
	*/
    $sql = "SELECT l.name, c.name as cat_name, cat_id, l.price, img_url, l.id, l.dt_fin FROM lots l" .
    " JOIN categories c ON l.cat_id = c.id" .
    " ORDER BY l.dt_add DESC";
    $result = $yetiCave->query($sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($rows as $row) {
            $catsInfoArray[] = [
                'lot_name' => $row['name'],
                'cat_name' => $row['cat_name'],
                'lot_price' => $row['price'],
                'lot_img' => $row['img_url'],
                'lot_id' => $row['id'],
                'cat_id' => $row['cat_id'],
                'dt_fin' => $row['dt_fin']
            ];
        }
    } else {
        $error = $yetiCave->error();
    }
}