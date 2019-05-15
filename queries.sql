# Запрос для добавления информации в БД:
# Существующий список категорий

INSERT INTO
  categories
    (name,
     alias)
VALUES
  ('Доски и лыжи', 'boards'),
  ('Крепления', 'attachment'),
  ('Ботинки', 'boots'),
  ('Одежда', 'clothing'),
  ('Инструменты', 'tools'),
  ('Разное', 'other');

# Запрос для добавления информации в БД:
# Придумайте пару пользователей

INSERT INTO
  users (
    reg_time,
    email,
    username,
    password,
    avatar,
    contact
  )
VALUES
  (
    '2018-11-20 12:00:00',
    'adam@foobar.me',
    'Adam',
    '1111',
    'avatar.jpg',
    'МСК, Ленинградское ш., 14 км, аутлет Fashion House'
  ),
  (
    '2018-11-25 18:03:12',
    'eve@foobar.me',
    'Eve',
    '2222',
    NULL,
    'Сочи, с. Эсто-Садок, ул. Горная карусель, д.3'
  ),
  (
    '2018-11-29 02:46:26',
    'leo@foobar.me',
    'Лёня',
    '3333',
    NULL,
    'vk'
  ),
  (
    '2018-12-01 12:43:36',
    'nick@foobar.me',
    'Коля',
    '4444',
    NULL,
    'Somwhere over the rainbow'
  ),
  (
    '2018-12-03 19:25:41',
    'kath@foobar.me',
    'Kath',
    '5555',
    NULL,
    'Петрозаводск'
  ),
  (
    '2018-12-05 22:53:24',
    'seva@foobar.me',
    'Seva',
    '6666',
    NULL,
    'Москва, ВДНХ'
  ),
  (
    '2018-12-20 13:59:10',
    'eighth@foobar.me',
    'Eighth',
    '8888',
    '5c1b840e0c0a7.jpeg',
    'TARDIS'
  );

# Запрос для добавления информации в БД:
# Существующий список объявлений

INSERT INTO
  lots
SET
  start_time = '2018-11-21 15:34:59',
  product = '2014 Rossignol District Snowboard',
  description = 'Размер 159 см. Эта доска отлично подойдёт как для обычного склона, так и для парка, а также для обучения. За устойчивость и стабильность отвечает стандартный прогиб, он гарантирует жесткую хватку кантов. Высокие рокеры Amptek Auto-Turn обеспечивают легкость управления доской и четкое вхождение в повороты.',
  image = 'uploads/lot-1.jpg',
  opening_price = 10999,
  closing_time = '2019-03-25 19:00:00',
  price_increment = 50,
  seller_id = 1,
  category_id = 1;

INSERT INTO
  lots
SET
  start_time = '2018-11-21 15:50:23',
  product = 'DC Ply Mens 2016/2017 Snowboard',
  description = '147 см. Отличный щелчок, скошенный кант, хороший контроль.',
  image = 'uploads/lot-2.jpg',
  opening_price = 159999,
  closing_time = '2019-03-25 19:00:00',
  price_increment = 99,
  seller_id = 1,
  category_id = 1;

INSERT INTO
  lots
SET
  start_time = '2018-11-30 21:46:25',
  product = 'Крепления Union Contact Pro 2015 года размер L/XL',
  description = 'Универсальные крепления весом всего 720 грамм. Отлетела краска на местах где металл',
  image = 'uploads/lot-3.jpg',
  opening_price = 8000,
  closing_time = '2019-03-21 23:50:00',
  price_increment = 30,
  seller_id = 2,
  category_id = 2;

INSERT INTO
  lots
SET
  start_time = '2018-12-01 10:29:33',
  product = 'Ботинки для сноуборда DC Mutiny Charocal',
  description = 'Размер 9US. Традиционная шнуровка. Уровень катания: продвинутый. Жесткость: 8. Созданы для фристайла',
  image = 'uploads/lot-4.jpg',
  opening_price = 10999,
  closing_time = '2019-03-28 10:00:00',
  price_increment = 5,
  seller_id = 1,
  category_id = 3;

INSERT INTO 
  lots
SET
  start_time = '2018-12-03 23:24:07',
  product = 'Куртка для сноуборда DC Mutiny Charocal',
  description = 'С бирками. Материал- синтетический оксфорд, cтандартный крой',
  image = 'uploads/lot-5.jpg',
  opening_price = 7500,
  closing_time = '2019-04-10 12:30:00',
  price_increment = 10,
  seller_id = 2,
  category_id = 4;

INSERT INTO
  lots
SET
  start_time = '2018-12-01 14:43:45',
  product = 'Маска Oakley Canopy',
  description = 'Узкая оправа, и большая линза сферической формы, что позволяет иметь широчайший периферический обзор и отличную видимость. А благодаря наилучшей оптике, Вы будете иметь высокую четкость и хорошую видимость. Маска никогда не запотевает, для этого предусмотрена специальная система вентиляции.',
  image = 'uploads/lot-6.jpg',
  opening_price = 5400,
  closing_time = '2019-03-30 15:00:00',
  price_increment = 50,
  seller_id = 4,
  category_id = 6;

INSERT INTO
  lots
SET
  start_time = '2018-12-18 21:32:03',
  product = 'Горные лыжи Nordica Soul Rider 87',
  description = 'Парковые лыжи с игровой геометрией и хорошим отскоком. Конструкция Energy Frame включает в себя деревянный сердечник и слои карбона. 87 талия имеет большую стабильность, чем 84. Лыжи отлично контролируются на больших скоростях и на больших пролетах.',
  image = 'uploads/5c1948cd5974e.png',
  opening_price = 25000,
  closing_time = '2019-03-01 00:00:00',
  price_increment = 300,
  seller_id = 1,
  category_id = 1;

INSERT INTO
  lots
SET
  start_time = '2018-12-18 23:52:37',
  product = 'Детский зимний шлем Alpina',
  description = 'Горнолыжный шлем Alpina Carat обязательно понравится детям. При этом он отвечает всем стандартам безопасности.',
  image = 'uploads/5c196c25949bb.png',
  opening_price = 3000,
  closing_time = '2019-03-20 19:00:00',
  price_increment = 50,
  seller_id = 3,
  category_id = 6;

INSERT INTO
  lots
SET
  start_time = '2018-12-18 23:53:19',
  product = 'Ремнабор для нейлоновых тканей',
  description = 'Применяется для починки дыр и разрывов силиконо-нейлоновых палаток, рюкзаков и верхней одежды, герметизации швов, восстановления защитного покрытия ткани. Единственное средство, которое приклеивается к силиконо-нейлоновой поверхности.',
  image = 'uploads/5c196c4f0bcb8.jpg',
  opening_price = 100,
  closing_time = '2019-03-20 19:00:00',
  price_increment = 15,
  seller_id = 1,
  category_id = 5;

INSERT INTO
  lots
SET
  start_time = '2018-12-21 21:00:16',
  product = 'Шапка Airblaster',
  description = 'one size',
  image = 'uploads/5c1d38408b75f.jpeg',
  opening_price = 700,
  closing_time = '2019-03-20 18:00:00',
  price_increment = 100,
  seller_id = 6,
  category_id = 4;

INSERT INTO
  lots
SET
  start_time = '2018-12-21 21:05:02',
  product = 'Сноуборд WINTERLAND 2019',
  description = 'Размер 154\r\nЖенский\r\nБренд Rome SDS',
  image = 'uploads/5c1d395eae696.jpeg',
  opening_price = 35000,
  closing_time = '2019-04-20 19:00:00',
  price_increment = 1000,
  seller_id = 5,
  category_id = 1;


# Запрос для добавления информации в БД:
# Добавьте пару ставок для любого объявления
INSERT INTO
  bids(`create_time`, `amount`, `buyer_id`, `lot_id`)
VALUES
  ('2018-11-29 02:51:34', 11049, 3, 1),
  ('2018-11-30 13:23:06', 11099, 2, 1),
  ('2018-12-01 01:23:33', 8030, 1, 3),
  ('2018-12-01 13:02:18', 1104, 4, 4),
  ('2018-12-06 15:04:58', 7510, 6, 5);

# Запрос для получения всех категорий;
SELECT name FROM categories;

# Запрос на получение самых новых, открытых лотов.
# Каждый лот должен включать название, стартовую цену, ссылку на изображение, цену, название категории;
SELECT
  lots.product,
  lots.opening_price,
  lots.image,
  categories.name
FROM
  lots
  INNER JOIN categories ON categories.id = lots.category_id
WHERE
  lots.closing_time > CURRENT_TIMESTAMP()
ORDER BY
  lots.start_time DESC;

# Запрос показа лота по его id. Плюс название категории, к которой принадлежит лот
SELECT
  lots.product,
  categories.name
FROM
  lots
  INNER JOIN categories ON lots.category_id = categories.id
WHERE
  lots.id = 1;

# Запрос для обновления названия лота по его идентификатору;
UPDATE
  lots
SET
  product = 'Новая куртка DC Mutiny Charocal'
WHERE
  id = 5;

# Запрос на получение списка самых свежих ставок для лота по его идентификатору;
SELECT
  *
FROM
  bids
WHERE
  lot_id = 1
ORDER BY
  create_time DESC;

# Запрос на добавление новой колонки в существующую таблицу;

ALTER TABLE categories
ADD COLUMN alias VARCHAR(255) NOT NULL AFTER name;

# Запрос на добавление данных в новую колонку существующей таблицы;

UPDATE categories
SET alias = 'boards'
WHERE name = 'Доски и лыжи';

UPDATE categories
SET alias = 'attachment'
WHERE name = 'Крепления';

UPDATE categories
SET alias = 'boots'
WHERE name = 'Ботинки';

UPDATE categories
SET alias = 'clothing'
WHERE name = 'Одежда';

UPDATE categories
SET alias = 'tools'
WHERE name = 'Инструменты';

UPDATE categories
SET alias = 'other'
WHERE name = 'Разное';
