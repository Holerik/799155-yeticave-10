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
