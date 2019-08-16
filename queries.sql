USE YetiCave10;

INSERT INTO categories
SET name = 'Доски и лыжи', code = 'boards';
INSERT INTO categories
SET name = 'Крепления', code = 'attachment';
INSERT INTO categories
SET name = 'Ботинки', code = 'boots';
INSERT INTO categories
SET name = 'Одежда', code = 'clothing';
INSERT INTO categories
SET name = 'Инструменты', code = 'tools';
INSERT INTO categories
SET name = 'Разное', code = 'other';

INSERT INTO users
SET email = 'i_ivanov@gmail.com', name = 'ivanov24', password = 'zanbosc', info = 'https://vk.com/page-87938575_51386471';
INSERT INTO users
SET email = 'p_petrov@rambler.ru', name = 'petr_iv', password = 'alexb4', info = 'https://ok.ru/petr_petrov';
INSERT INTO users
SET email ='irina_vlad@mail.ru', name = 'flower11', password = 'bosc1234', info = 'https://ok.ru/irina_flower11';
INSERT INTO users
SET email ='pavel1278@mail.ru', name = 'pavel1278@mail', password = 'bosc87654', info = 'https://ok.ru/pave157';


INSERT INTO lots 
SET name = '2014 Rossignol District Snowboard', descr = 'Многоцелевые доски Rossignol категории Фристайл очень прочные для амплитудных приземлений и имеют более широкую стойку с новейшей джиббинговой технологией и изогнутыми кантами Magne-Traction. ',
 img_url = 'img/lot-1.jpg', price = 10999, rate_step = '500', cat_id = '1', autor_id = '1', dt_fin = '2019-10-01';
INSERT INTO lots 
SET name = 'DC Ply Mens 2016/2017 Snowboard', descr = 'Популярный сноуборд Ply по ощущениям немного напоминает скейтборд.',
 img_url = 'img/lot-2.jpg', price = 159999, rate_step = '1000', cat_id = '1', autor_id = '1', dt_fin = '2019-10-01';
INSERT INTO lots 
SET name = 'Крепления Union Contact Pro 2015 года размер L/XL', descr = 'Эти крепления ежегодно проверяет на прочность один из самых титулованных бэккантри-райдеров - австриец Gigi Rüf.',
 img_url = 'img/lot-3.jpg', price = 8000, rate_step = '200', cat_id = '2', autor_id = '1', dt_fin = '2019-10-01';
INSERT INTO lots 
SET name = 'Ботинки для сноуборда DC Mutiny Charocal', descr = 'Прогрессивный дизайн в классическом силуэте - ботинки DC Mutiny созданы для комфортного катания и высокой производительности.',
 img_url = 'img/lot-4.jpg', price = 10999, rate_step = '500', cat_id = '3', autor_id = '2', dt_fin = '2019-10-01';
INSERT INTO lots 
SET name = 'Куртка для сноуборда DC Mutiny Charocal', descr = 'Куртка подходит для сноубординга (сноуборда) и активного отдыха. Куртка утепленная.',
 img_url = 'img/lot-5.jpg', price = 7500, rate_step = '100', cat_id = '4', autor_id = '2', dt_fin = '2019-10-01';
INSERT INTO lots 
SET name = 'Маска Oakley Canopy', descr = 'Сноубордическая маска. Технология вентиляции O-Flow Arch и прослойка из микрофлиса.',
 img_url = 'img/lot-6.jpg', price = 5400, rate_step = '100', cat_id = '6', autor_id = '3', dt_fin = '2019-10-01';
 

INSERT INTO rates
SET price = '6000', user_id = '3', lot_id = '1';
INSERT INTO rates
SET price = '1000', user_id = '4', lot_id = '3';

SELECT * FROM categories;

SELECT l.name, l.price, img_url, r.price, c.name FROM lots l
JOIN rates r ON r.lot_id = l.id 
JOIN categories c ON l.cat_id = c.id
WHERE l.dt_add < '2019-08-20';

SELECT l.name, c.name FROM lots l
JOIN categories c ON l.cat_id = c.id 
WHERE l.id = 1;

UPDATE lots SET name = 'Крепления Union Contact Pro Black 2017 года' WHERE id = 3;
UPDATE rates SET dt_add = CURRENT_TIMESTAMP WHERE id = 2;

SELECT r.price FROM rates r
JOIN lots l ON r.lot_id = l.id
ORDER BY r.dt_add ASC;

