<?php
/**
 * Форматирует цену в рублях,
 * отделяет точкой тысячи и добавляет в
 * конец строки символ рубля
 * 
 * @param integer $price Цена в рублях
 *
 * @return string Отформатированная строка с ценой
 */
function Format_price($price) 
{
    $result =   "";
    $price = ceil($price);
    if ($price > 1000) {
        $result = number_format($price, 0, ".", " ");
    } else {
        $result = $price;
    }
    $result .= " ₽";
    return $result;
}

/**
 * Определяет время, оставшееся
 * до наступления заданной даты
 * 
 * @param date $dt_fin Дата в будущем
 *
 * @return integer array[0] Количество оставшихся дней 
 *         integer array[1] Количество оставшихся минут
 */
function Remained_time($dt_fin) 
{
    $hour = 0;
    $days = 0;
    $min = 0;
    $now = time();
    $fin = strtotime($dt_fin);
    $retVal = [0, 0];
    if ($fin > $now) { 
        $diff = $fin - $now;
        $weeks = $diff / 604800 % 52;
        $days = $diff / 86400 % 7;
        $hours = $diff / 3600 % 24;
        $mins = $diff / 60 % 60;
        $retVal = [$hours + 24 * $days + 7 * 24 * $weeks, $mins];
    } 
    return $retVal;
}

/**
 * Определяет минимально возможную ставку
 * для участия в торгах
 * 
 * @param MySqliBase $db     Открытая БД 
 * @param integer    $lot_id Ключ торгуемого лота
 * @param bool       $flag   Если true - цена лота с учетом шага ставки
 *                           Если false - текущая цена лота
 * 
 * @return integer Размер минимальной ставки
 */
function Get_min_rate($db, $lot_id, $flag = true) {
    if (!$db->ok()) {
        return 0;
    }
    $min_rate = 0;
    $step = 0;
    $sql = "SELECT rate_step, price FROM lots WHERE id = $lot_id";
    $result = $db->query($sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $step = $row['rate_step'];
        $min_rate = $row['price'];
    }
    $sql = "SELECT price FROM rates r WHERE r.lot_id = $lot_id" . 
    "  ORDER BY price DESC LIMIT 1";
    $result = $db->query($sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        if ($min_rate < $rows[0]['price']) {
            $min_rate = $rows[0]['price'];
        }
    } else {
        $step = 0;
    }
    if ($flag) {
        return $min_rate + $step;
    }
    return $min_rate;
}

/**
 * Проверяет актуальность ставки
 * 
 * @param MySqliBase $db     Ресурс открытой БД
 * @param integer    $lot_id Ключ торгуемого лота
 * @param integer    $bet    тестируемая ставка
 *
 * @return bool true, если ставка наибольшая
 */
function Check_rate($db, $lot_id, $bet)
{
    if (!$db->ok()) {
        return false;
    }
    $rate = Get_min_rate($db, $lot_id, false);
    $result = $bet >= $rate;
    return $result;
}

/**
 * Возвращает название категории товаров
 * по индексу категории
 * 
 * @param array   $catsInfo Массив элементов категорий
 * @param integer $cat_id   Индекс категории в БД
 *
 * @return string Название категории
 */
function Category_name($catsInfo, $cat_id)
{
    $result = "";
    foreach ($catsInfo as $cat) {
        if ($cat['id'] == $cat_id) {
            $result = $cat['name'];
            break;
        }
    }
    return $result;
}

/**
 * Тестирует строку на предмет
 * содержания в ней некоторой строки
 * 
 * @param string $str  Исходная строка
 * @param string $test Искомая строка
 *
 * @return bool true, если строка $str
 * содержит строку $test
 */
function strtest($str, $test)
{
    return !(strpos($str, $test) === false);
}


/**
 *  Комментирует период времени прохождения торгов
 * 
 * @param date $dt_add Время добавления лота в торги
 * @param date $dt_fin Время окончания торгов по лоту
 *
 * @return string Комментарий хода торгров
 */
function Lot_time_info($dt_add, $dt_fin)
{
    $time_info = [ 'info' => "",
        'status' => 1
    ];
    $now = time();
    $add = strtotime($dt_add);
    $fin = strtotime($dt_fin);
    if ($now > $fin) {
        $time_info['info'] = "Торги окончены";
        $time_info['status'] = 0;
        return $time_info;
    }
    $now_arr = date_parse(date("Y-m-d H:i", time()));
    $add_arr = date_parse($dt_add);

    $month = $now_arr['month'] - $add_arr['month'];
    $days = $now_arr['day'] - $add_arr['day'];
    $hour = $now_arr['hour'] - $add_arr['hour'];
    $min = $now_arr['minute'] - $add_arr['minute'];

    if ($month > 0 || $days > 1) {
        $time_info['info'] = date("d.m.Y в H:i", $add);	
    } elseif ($days == 1) {
        $time_info['info'] = date("вчера, в H:i", $add);
    } elseif ($hour > 1) {
        $time_info['info'] = date("в H:i", $add);
    } elseif ($hour == 1) {
        $time_info['info'] = date("час назад");
    } else {
        $time_info['info'] = $min;
        $m = $min % 10;
        if ($min > 5 && $min < 21) {
            $time_info['info'] .= " минут назад";
        } elseif ($m == 0) {
            $time_info['info'] .= " минут назад";
        } elseif ($m < 2) {
            $time_info['info'] .= " минуту назад";
        } elseif ($m < 5) {
            $time_info['info'] .= " минуты назад";
        } else {
            $time_info['info'] .= " минут назад";
        }
    }
    return $time_info;
}

/**
 * Подбирает синоним для содержимого строки
 * 
 * @param string $name Некоторое содержимое
 *
 * @return string Синоним для содержимого
 */
function Lot_alt_descr($name)
{
    $result = "Разное";
    if (strtest($name, "oots") || strtest($name, "отинки")) {
        $result = "Ботинки";
    } elseif (strtest($name, "nowboard") || strtest($name, "ноуборд")) {
        $result = "Сноуборд";
    } elseif (strtest($name, "уртка")) {
        $result = "Куртка";
    } elseif (strtest($name, "ыжи")) {
        $result = "Лыжи";
    } elseif (strtest($name, "аска")) {
        $result = "Маска";
    } elseif (strtest($name, "чки")) {
        $result = "Очки";
    }
    return $result;
}


/**
 * Проверяет наличие ошибки в массиве ошибок
 * и возвращает модифицирующую строку при наличии ошибки
 * 
 * @param string array $err    Ассоциативный массив 
 * @param string       $field  Индекс ошибки
 * @param string       $modify Модифицирующая строка
 *
 * @return string Модифицирующая строка
 */
function Modify_When_error($err, $field, $modify) {
    $res = "";
    if (!empty($field)) {
        if (isset($err[$field])) {
            $res = " " . $modify;
        }
    } else {
        if (count($err) > 0) {
            $res = " " . $modify;
        }
    }
    return $res;
}

/**
 * Возвращает слово СТАВКА в правильном падеже
 * 
 * @param integer $count Количество ставок
 * 
 * @return string Слово СТАВКА в правильном падеже
 */
function wordform($count) 
{
    $rem = $count % 10;
    if ($rem == 1) {
        return "ставка";
    }
    if ($rem > 1 && $rem < 5) {
        return "ставки";
    }
    return "ставок";
}

/**
 * Создает строку для инициализации cookie
 * 
 * @param array $cats Список категорий товаров
 *
 * @return string Строка для инициализации
 */
function initcookie($cats)
{
    $result = "0:0";
    foreach ($cats as $cat) {
        $result .= "-";
        $result .= $cat['id'] . ":0";
    }
    return $result;
}

/**
 * Модифицирует строку cookie для заданной категории
 * 
 * @param string  $cookie Исходная строка 
 * @param integer $cat    Индекс категории в БД
 *
 * @return string Модифицированная строка
 */
function updatecookie($cookie, $cat)
{
    $result = "";
    $tok = ":-";
    $num = 0;
    $snum = strtok($cookie, $tok);
    while ($snum !== false) {
        $result .= $snum . ":";
        if ($snum == $cat) {
            $snum = strtok($tok);
            $num = $snum + 1;
        } else {
            $snum = strtok($tok);
            $num = $snum;
        }
        $result .= $num;
        $snum = strtok($tok);
        if ($snum !== false) {
            $result .= "-";
        }
    }
    return $result;
}

/**
 * Возвращает количество посещений сайта/категории товара
 * 
 * @param string  $cookie Исходная строка 
 * @param integer $cat    Индекс категории в БД
 * 
 * @return integer Количестов посещений
 */
function infocookie($cookie, $cat) 
{
    $tok = ":-";
    $num = 0;
    $snum = strtok($cookie, $tok);
    while ($snum !== false) {
        if ($snum == $cat) {
            $snum = strtok($tok);
            $num = $snum;
            break;
        } else {
            $snum = strtok($tok);
            $num = $snum;
        }
    }
    return $num;
}

/**
 * Меняет размеры исходного изображения и сохраняет его с новым именем
 * 
 * @param int    $cx              Размер нового изображения
 * @param int    $cy              Размер нового изображения
 * @param string $orig_img_path   Путь к исходному изображению
 * @param string $resize_img_path Путь для сохранения измененного изображения
 * 
 * @return bool  true            В случае успеха
 *               false           В случае неуспеха
 */
function Resize_img($cx, $cy, $orig_img_path, $resize_img_path) {
    if (!file_exists($orig_img_path)) {
        return false;
    }
    $imagine = new Imagine\Gd\Imagine();
    $img = $imagine->open($orig_img_path);
    if (!$img) {
        return false;
    }
    if (file_exists($resize_img_path)) {
        unlink($resize_img_path);
    }
    if ($cx > 0 && $cy > 0) {
        $new_box = new Imagine\Image\Box($cx, $cy);
        $img->resize($new_box);
        $img->save($resize_img_path);
        return true;
    }
    $old_box = $img->getSize();
    $old_cx = $old_box->getWidth();
    $old_cy = $old_box->getHeight();
    if ($cx > 0) {
        $cy = $old_cy * $cx / $old_cx;
    } else {
        $cx = $old_cx * $cy / $old_cy;
    }
    $new_box = new Imagine\Image\Box($cx, $cy);
    $img->resize($new_box);
    $img->save($resize_img_path);
    return true;
}

/**
 * Обрезает размеры исходного изображения и сохраняет его с новым именем
 * 
 * @param int    $cx            Размер нового изображения
 * @param int    $cy            Размер нового изображения
 * @param string $orig_img_path Путь к исходному изображению
 * @param string $crop_img_path Путь для сохранения измененного изображения
 * 
 * @return bool  true            В случае успеха
 *               false           В случае неуспеха
 */
function Crop_img($cx, $cy, $orig_img_path, $crop_img_path) 
{
    if (!resize_img($cx, $cy, $orig_img_path, $crop_img_path)) {
        return false;
    }
    if ($cy == 0) {
        $cy = $cx;
    } elseif ($cx == 0) {
        $cx = $cy;
    }
    if ($cx == 0) {
        return false;
    }
    $imagine = new Imagine\Gd\Imagine();
    $img = $imagine->open($crop_img_path);
    if (!$img) {
        return false;
    }
    unlink($crop_img_path);
    $old_box = $img->getSize();
    $old_cx = $old_box->getWidth();
    $old_cy = $old_box->getHeight(); 
    if ($cx > $old_cx) {
        $cx = $old_cx;
    }   
    if ($cy > $old_cy) {
        $cy = $old_cy;
    }   
    $box = new Imagine\Image\Box($cx, $cy);
    $point = new Imagine\Image\Point(0, 0);
    $img->crop($point, $box);
    $img->save($crop_img_path);
    return true;
}