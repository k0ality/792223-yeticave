CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR (128) NOT NULL UNIQUE
);

CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  create_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  name VARCHAR(255),
  description TEXT(1000),
  image VARCHAR(128),
  opening_price INT,
  closing_time DATETIME,
  price_increment INT,
  seller_id INT,
  winner_id INT,
  category_id INT
);

CREATE TABLE bids (
  id INT AUTO_INCREMENT PRIMARY KEY,
  create_time DATETIME,
  amount INT,
  buyer_id INT,
  lot_id INT
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  reg_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  email VARCHAR(64) NOT NULL UNIQUE,
  username VARCHAR(128) NOT NULL UNIQUE,
  password VARCHAR(64) NOT NULL,
  avatar VARCHAR(128),
  contact VARCHAR(128)
);

CREATE INDEX seller ON lots(seller_id);
CREATE INDEX winner ON lots(winner_id);
CREATE UNIQUE INDEX reg_email ON users(email);
