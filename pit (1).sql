-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 27 2022 г., 22:47
-- Версия сервера: 5.7.33
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `pit`
--

DELIMITER $$
--
-- Процедуры
--
CREATE PROCEDURE `last30order` (IN `idU` INT)  BEGIN

select sumorder, orderDate from shortsuminfo where idUser=idU  order by orderDate desc limit 10;
END$$

CREATE PROCEDURE `test_pr` (IN `dateD` DATE, IN `markN` VARCHAR(50), IN `amount` INT(8))  BEGIN
DECLARE  count_car INT;
DECLARE  id_car INT;
select count(*) into count_car from  `car_deliviry_info` 
where idCar not in (select idCar from `car_deliviry_info` where deliviryDate=dateD)
and mark=markN;

if count_car=0
THEN
select mark from  `car_deliviry_info` 
where idCar not in (select idCar from `car_deliviry_info` where deliviryDate=dateD) group by mark;
ELSE
select idCar into id_car  from  `car_deliviry_info` 
where idCar not in (select idCar from `car_deliviry_info` where deliviryDate=dateD)
and mark=markN and volume>=amount order by volume
LIMIT 1;
if id_car is null
then
select idCar into id_car from  `car_deliviry_info` 
where idCar not in (select idCar from `car_deliviry_info` where deliviryDate=dateD)
and mark=markN and volume<amount order by volume DESC
LIMIT 1;
end if;


end if;
SELECT id_car;
END$$

CREATE PROCEDURE `update_product_info` (IN `idOrd` INT(8), IN `idProd` INT(8), IN `amountProd` INT(8))  BEGIN
DECLARE  amount_after_order INT;
INSERT INTO `productorder` (idOrder, idProduct, amountProduct) VALUES (idOrd, idProd, amountProd);
UPDATE product
SET
amountStorage = amountStorage - amountProd 
WHERE id = idProd;
select amountStorage - amountProd into amount_after_order from product  WHERE id = idProd;
select amount_after_order;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `allinfo`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `allinfo` (
`price` int(6)
,`productName` varchar(30)
,`sumProduct` bigint(21)
,`idOrder` int(6)
,`categoryName` varchar(40)
,`amountProduct` int(5)
,`code` varchar(25)
,`orderDate` date
,`deliviryDate` date
,`codeCar` varchar(7)
,`mark` varchar(30)
,`idUser` int(8)
);

-- --------------------------------------------------------

--
-- Структура таблицы `car`
--

CREATE TABLE `car` (
  `id` int(6) NOT NULL,
  `idMark` int(6) NOT NULL,
  `volume` int(5) DEFAULT NULL,
  `code` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `car`
--

INSERT INTO `car` (`id`, `idMark`, `volume`, `code`) VALUES
(1, 1, 150, '9999'),
(2, 2, 40, '5555'),
(3, 3, 100, '1111'),
(4, 1, 120, '7777'),
(5, 1, 5, '8888');

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `car_deliviry_info`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `car_deliviry_info` (
`mark` varchar(30)
,`deliviryDate` date
,`volume` int(5)
,`idCar` int(6)
);

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int(6) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(3, 'Гравий'),
(1, 'Песок'),
(2, 'Щебень');

-- --------------------------------------------------------

--
-- Структура таблицы `mark`
--

CREATE TABLE `mark` (
  `id` int(6) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mark`
--

INSERT INTO `mark` (`id`, `name`) VALUES
(2, 'Mercedes'),
(1, 'КАМАЗ'),
(3, 'УРАЛ');

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

CREATE TABLE `order` (
  `id` int(6) NOT NULL,
  `code` varchar(25) NOT NULL,
  `orderDate` date NOT NULL,
  `deliviryDate` date DEFAULT NULL,
  `idCar` int(6) DEFAULT NULL,
  `idUser` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `order`
--

INSERT INTO `order` (`id`, `code`, `orderDate`, `deliviryDate`, `idCar`, `idUser`) VALUES
(1, 'asdasddas', '2022-10-12', NULL, NULL, 1),
(2, '1u1666035218', '2022-10-17', NULL, NULL, 1),
(3, '1u1666035315', '2022-10-17', NULL, NULL, 1),
(4, '1u1666035391', '2022-10-17', NULL, NULL, 1),
(5, '1u1666036115', '2022-10-17', NULL, NULL, 1),
(6, '1u1666036453', '2022-10-17', NULL, NULL, 1),
(7, '1u1666036608', '2022-10-17', NULL, NULL, 1),
(8, '1u1666430785', '2022-10-22', NULL, NULL, 1),
(9, '1u1666432999', '2022-10-22', '2022-12-22', NULL, 1),
(10, '1u1666433089', '2022-10-22', '2022-12-22', NULL, 1),
(11, '1u1666433258', '2022-10-22', '2023-12-22', 2, 1),
(12, '1u1666443046', '2022-10-22', '2023-12-19', 1, 1),
(13, '1u1666443299', '2022-10-22', '2023-12-19', 3, 1),
(14, '1u1666447712', '2022-10-22', '2022-11-11', 3, 1),
(15, '1u1666638772', '2022-10-24', '2022-10-24', 2, 1),
(16, '1u1666639975', '2022-10-24', '2022-10-24', 1, 1),
(17, '1u1666642828', '2022-10-24', '2022-10-24', 5, 1),
(18, '1u1666642950', '2022-10-24', '2022-10-24', 4, 1),
(19, '1u1666643126', '2022-10-24', '2022-10-25', 4, 1),
(20, '1u1666643608', '2022-10-24', '2022-11-01', 3, 1),
(21, '1u1666644735', '2022-10-24', '2022-11-23', 2, 1),
(22, '1u1666644972', '2022-10-24', '2022-12-12', 2, 1),
(23, '1u1666645029', '2022-10-24', '2022-12-03', 2, 1),
(24, '1u1666645140', '2022-10-24', '2022-12-11', 2, 1),
(25, '1u1666645162', '2022-10-24', '2022-11-29', 2, 1),
(26, '1u1666804124', '2022-10-26', '2022-12-09', 2, 1),
(27, '1u1666804648', '2022-10-26', '2022-11-17', 5, 1),
(28, '1u1666804724', '2022-10-26', '2022-12-03', 3, 1),
(29, '1u1666805921', '2022-10-26', '2022-11-20', 2, 1),
(30, '1u1666806071', '2022-10-26', '2022-11-12', 4, 1),
(31, '1u1666806090', '2022-10-26', '2022-11-28', 4, 1),
(32, '1u1666806440', '2022-10-26', '2022-11-04', 4, 1),
(33, '1u1666857510', '2022-10-27', '2022-11-18', 5, 1),
(34, '1u1666857802', '2022-10-27', '2022-11-27', 3, 1),
(35, '1u1666857950', '2022-10-27', '2022-12-01', 5, 1),
(36, '1u1666858042', '2022-10-27', '2022-11-25', 5, 1),
(37, '1u1666858172', '2022-10-27', '2022-12-01', 2, 1),
(38, '1u1666858307', '2022-10-27', '2022-11-23', 4, 1),
(39, '1u1666858576', '2022-10-27', '2022-11-18', 4, 1),
(40, '1u1666859167', '2022-10-27', '2022-11-25', 4, 1),
(41, '1u1666859208', '2022-10-27', '2022-11-25', 1, 1),
(42, '1u1666859488', '2022-10-27', '2022-11-25', 3, 1),
(43, '1u1666859579', '2022-10-27', '2022-11-17', 4, 1),
(44, '1u1666860436', '2022-10-27', '2023-01-01', 4, 1),
(45, '1u1666890166', '2022-10-27', '2022-11-17', 1, 1),
(46, '1u1666890346', '2022-10-27', '2022-12-01', 4, 1),
(47, '1u1666890460', '2022-10-27', '2022-12-02', 3, 1),
(48, '1u1666890489', '2022-10-27', '2022-12-03', 5, 1),
(49, '1u1666890638', '2022-10-27', '2022-11-01', 2, 1),
(50, '1u1666890701', '2022-10-27', '2022-11-18', 1, 1),
(51, '1u1666891157', '2022-10-27', '2022-11-23', 1, 1),
(52, '1u1666891326', '2022-10-27', '2022-11-24', 2, 1),
(53, '2u1666899947', '2022-10-27', '2022-11-11', 4, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `id` int(6) NOT NULL,
  `name` varchar(30) NOT NULL,
  `price` int(6) DEFAULT NULL,
  `amountStorage` int(5) DEFAULT NULL,
  `idCategory` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `amountStorage`, `idCategory`) VALUES
(1, 'Песок карьерный', 10, 244, 1),
(2, 'Песок мытый', 20, 297, 1),
(3, 'Отсев гранитный', 30, 3000, 2),
(4, 'Бутовый камень', 55, 383, 2),
(5, 'Гравий', 70, 224, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `productorder`
--

CREATE TABLE `productorder` (
  `id` int(6) NOT NULL,
  `idOrder` int(6) NOT NULL,
  `idProduct` int(6) NOT NULL,
  `amountProduct` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `productorder`
--

INSERT INTO `productorder` (`id`, `idOrder`, `idProduct`, `amountProduct`) VALUES
(1, 6, 1, 4),
(2, 6, 4, 3),
(3, 7, 1, 3),
(4, 7, 4, 4),
(5, 10, 2, 5),
(6, 11, 3, 3),
(7, 12, 2, 5),
(8, 13, 3, 3),
(9, 13, 2, 5),
(10, 14, 1, 2),
(11, 15, 1, 3),
(12, 16, 4, 7),
(13, 17, 4, 3),
(14, 18, 4, 3),
(15, 19, 3, 7),
(16, 20, 5, 200),
(17, 21, 5, 85),
(18, 22, 5, 85),
(19, 23, 5, 87),
(20, 24, 5, 87),
(21, 25, 5, 80),
(22, 26, 5, 5),
(23, 27, 5, 3),
(24, 28, 5, 3),
(25, 29, 5, 5),
(26, 30, 5, 10),
(27, 31, 5, 13),
(28, 32, 5, 10),
(29, 33, 5, 4),
(30, 34, 5, 4),
(31, 35, 5, 4),
(32, 36, 5, 4),
(33, 37, 5, 16),
(34, 38, 5, 9),
(35, 39, 5, 7),
(36, 40, 5, 5),
(37, 41, 5, 5),
(38, 42, 5, 5),
(39, 43, 5, 5),
(40, 44, 5, 11),
(41, 45, 5, 4),
(42, 46, 5, 3),
(43, 46, 1, 6),
(44, 46, 4, 9),
(45, 47, 5, 12),
(46, 48, 1, 4),
(47, 49, 1, 3),
(48, 50, 2, 3),
(49, 51, 1, 5),
(50, 51, 5, 5),
(51, 51, 4, 8),
(52, 52, 1, 5),
(53, 53, 1, 33);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `shortsuminfo`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `shortsuminfo` (
`idOrder` int(6)
,`sumorder` decimal(42,0)
,`code` varchar(25)
,`orderDate` date
,`deliviryDate` date
,`codeCar` varchar(7)
,`mark` varchar(30)
,`idUser` int(8)
);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `login` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`login`, `password`, `lastName`, `firstName`, `id`) VALUES
('admin', '123', 'admin', 'admin', 1),
('ivan', '1111', 'Иванов', 'Иван', 2);

-- --------------------------------------------------------

--
-- Структура для представления `allinfo`
--
DROP TABLE IF EXISTS `allinfo`;

CREATE  VIEW `allinfo`  AS SELECT `p`.`price` AS `price`, `p`.`name` AS `productName`, (`p`.`price` * `po`.`amountProduct`) AS `sumProduct`, `po`.`idOrder` AS `idOrder`, `c`.`name` AS `categoryName`, `po`.`amountProduct` AS `amountProduct`, `o`.`code` AS `code`, `o`.`orderDate` AS `orderDate`, `o`.`deliviryDate` AS `deliviryDate`, `ca`.`code` AS `codeCar`, `m`.`name` AS `mark`, `o`.`idUser` AS `idUser` FROM (((((`product` `p` join `productorder` `po` on((`p`.`id` = `po`.`idProduct`))) join `order` `o` on((`po`.`idOrder` = `o`.`id`))) join `category` `c` on((`c`.`id` = `p`.`idCategory`))) left join `car` `ca` on((`ca`.`id` = `o`.`idCar`))) left join `mark` `m` on((`m`.`id` = `ca`.`idMark`))) ;

-- --------------------------------------------------------

--
-- Структура для представления `car_deliviry_info`
--
DROP TABLE IF EXISTS `car_deliviry_info`;

CREATE VIEW `car_deliviry_info`  AS SELECT `mark`.`name` AS `mark`, `order`.`deliviryDate` AS `deliviryDate`, `car`.`volume` AS `volume`, `car`.`id` AS `idCar` FROM ((`car` left join `order` on((`car`.`id` = `order`.`idCar`))) join `mark` on((`car`.`idMark` = `mark`.`id`))) ;

-- --------------------------------------------------------

--
-- Структура для представления `shortsuminfo`
--
DROP TABLE IF EXISTS `shortsuminfo`;

CREATE VIEW `shortsuminfo`  AS SELECT `a`.`idOrder` AS `idOrder`, sum(`a`.`sumProduct`) AS `sumorder`, `a`.`code` AS `code`, `a`.`orderDate` AS `orderDate`, `a`.`deliviryDate` AS `deliviryDate`, `a`.`codeCar` AS `codeCar`, `a`.`mark` AS `mark`, `a`.`idUser` AS `idUser` FROM `allinfo` AS `a` GROUP BY `a`.`idOrder` ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idMark` (`idMark`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `mark`
--
ALTER TABLE `mark`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idCar` (`idCar`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCategory` (`idCategory`);

--
-- Индексы таблицы `productorder`
--
ALTER TABLE `productorder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idOrder` (`idOrder`),
  ADD KEY `idProduct` (`idProduct`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `car`
--
ALTER TABLE `car`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `mark`
--
ALTER TABLE `mark`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `order`
--
ALTER TABLE `order`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `productorder`
--
ALTER TABLE `productorder`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `car`
--
ALTER TABLE `car`
  ADD CONSTRAINT `car_ibfk_1` FOREIGN KEY (`idMark`) REFERENCES `mark` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`idCar`) REFERENCES `car` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`idCategory`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `productorder`
--
ALTER TABLE `productorder`
  ADD CONSTRAINT `productorder_ibfk_1` FOREIGN KEY (`idOrder`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productorder_ibfk_2` FOREIGN KEY (`idProduct`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
