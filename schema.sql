CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(128)
);

CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  creation_date DATETIME,
  name VARCHAR(128),
  description VARCHAR(128),
  image VARCHAR(128),
  opening_price INT,
  closing_date DATETIME,
  price_increment INT,
  owner_id INT,
  winner_id INT,
  category_id INT
);

CREATE TABLE bids (
  id INT AUTO_INCREMENT PRIMARY KEY,
  bid_date DATETIME,
  bid_amount INT,
  buyer_id INT,
  lot_id INT
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  reg_date DATETIME,
  email VARCHAR(64),
  name VARCHAR(128),
  password VARCHAR(64),
  avatar VARCHAR(128),
  contact VARCHAR(128),
  added_lots INT,
  bid_history INT
);