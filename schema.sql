CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE categories (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL
);
CREATE UNIQUE INDEX categories_udx ON categories(name);

CREATE TABLE lots (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  start_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  product VARCHAR(255) NOT NULL,
  description TEXT,
  image VARCHAR(255),
  opening_price INT(11) NOT NULL,
  closing_time DATETIME NOT NULL,
  price_increment INT(11) NOT NULL,
  seller_id INT(11) NOT NULL,
  winner_id INT(11) NULL,
  category_id INT(11) NOT NULL
);
CREATE INDEX seller_id_idx ON lots(seller_id);
CREATE INDEX winner_id_idx ON lots(winner_id);
CREATE INDEX product_idx ON lots(product);
CREATE INDEX closing_time_idx ON lots(closing_time);

CREATE TABLE bids (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  create_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  amount INT(11) NOT NULL,
  buyer_id INT(11) NOT NULL,
  lot_id INT(11) NOT NULL
);
CREATE INDEX create_time_idx ON bids(create_time);
CREATE INDEX amount_idx ON bids(amount);

CREATE TABLE users (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  reg_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  email VARCHAR(320) NOT NULL,
  username VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  avatar VARCHAR(255),
  contact VARCHAR(255)
);
CREATE INDEX reg_time_idx ON users(reg_time);
CREATE UNIQUE INDEX email_udx ON users(email);
CREATE UNIQUE INDEX username_udx ON users(username);
