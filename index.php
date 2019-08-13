<?php
require_once('helpers.php');

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



//массив категорий
$catsArray = [
    'Доски и лыжи',
    'Крепления',
    'Ботинки',
    'Одежда',
    'Инструменты',
    'Разное'
];

//массив товаров
$catsInfoArray = [
    [
        'lot_name' => '2014 Rossignol District Snowboard',
        'cat_name' => 'Доски и лыжи',
        'lot_price' => 10999,
        'lot_img' => 'img/lot-1.jpg'
    ],
    [
        'lot_name' => 'DC Ply Mens 2016/2017 Snowboard',
        'cat_name' => 'Доски и лыжи',
        'lot_price' => 159999,
        'lot_img' => 'img/lot-2.jpg'
    ],
    [
        'lot_name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'cat_name' => 'Крепления',
        'lot_price' => 8000,
        'lot_img' => 'img/lot-3.jpg'
    ],
    [
        'lot_name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'cat_name' => 'Ботинки',
        'lot_price' => 10999,
        'lot_img' => 'img/lot-4.jpg'
    ],
    [
        'lot_name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'cat_name' => 'Одежда',
        'lot_price' => 7500,
        'lot_img' => 'img/lot-5.jpg'
    ],
    [
        'lot_name' => 'Маска Oakley Canopy',
        'cat_name' => 'Разное',
        'lot_price' => 5400,
        'lot_img' => 'img/lot-6.jpg'
    ]
];

$pageName = 'YetuCave';

$main_content =  include_template('main.php', [
    'catsArray' => $catsArray,
    'catsInfoArray' => $catsInfoArray
]);

$layout_content = include_template('layout.php', [
    'title' => $pageName,
    'main_content' => $main_content,
    'catsArray' => $catsArray
]);

print($layout_content);


