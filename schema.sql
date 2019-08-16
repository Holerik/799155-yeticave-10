CREATE DATABASE YetiCave10
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE YetiCave10;

CREATE TABLE categories (
	id	    INT AUTO_INCREMENT PRIMARY KEY,
	name	CHAR(128) NOT NULL UNIQUE,
	code	CHAR(16) NOT NULL UNIQUE
);

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

CREATE TABLE lots (
	id		    INT AUTO_INCREMENT PRIMARY KEY,
	dt_add		TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	name 		CHAR(255) NOT NULL UNIQUE,
	descr 		TEXT(65535) NOT NULL,
	img_url		CHAR(255),
	price		INT NOT NULL,
	dt_fin		TIMESTAMP NOT NULL,
	rate_step	INT NOT NULL,
	cat_id		INT,
	autor_id	INT,
	winner_id	INT
);

CREATE TABLE rates (
	id	    INT AUTO_INCREMENT PRIMARY KEY,
	dt_add 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	price	INT NOT NULL,
	user_id	INT,
	lot_id	INT
);

CREATE TABLE users (
	id		    INT AUTO_INCREMENT PRIMARY KEY,
	dt_add 		TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	email 		CHAR(128) NOT NULL UNIQUE,
	name		CHAR(64) NOT NULL,
	password	CHAR(255) NOT NULL UNIQUE,
	avatar_path	CHAR(255),
	info		TEXT(65535) NOT NULL
);

CREATE INDEX rate_search ON rates(user_id);
CREATE INDEX lot_search ON lots(cat_id, autor_id);
