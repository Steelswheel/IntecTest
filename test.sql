-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июл 02 2020 г., 19:00
-- Версия сервера: 10.4.11-MariaDB
-- Версия PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `name_trans` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `small_text` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `big_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `name`, `name_trans`, `price`, `small_text`, `big_text`, `user_id`) VALUES
(1, 'Пиво', 'Beer', 10.2, 'Cool beer. Cool beer. Cool bee', 'Cool beer. Cool beer. Cool beer. Cool beer. Cool beer. Cool beer. Cool beer. Cool beer. Cool beer. Cool beer.', 1),
(2, 'Хлеб', 'Bread', 12.1, 'Crispy bread. Crispy bread. Cr', 'Crispy bread. Crispy bread. Crispy bread. Crispy bread. Crispy bread. Crispy bread. Crispy bread. Crispy bread. ', 1),
(3, 'Сыр', 'Cheese', 17.21, 'Cheesee cheese.', 'Обычный сыр.', 1),
(4, 'Колбаса', 'Sausage', 16.99, 'Вареная колбаса.', '<div>Вареная колбаса.', 1),
(1, 'Пиво', 'Beer', 10, 'Cool beer.', 'Cool beer.', 3),
(2, 'Хлеб', 'Bread', 12, 'Какой-то текст.', 'Какой-то текст.', 3),
(3, 'Молоко', 'Milk', 13, 'Пейте дети молоко - будете здо', 'Пейте дети молоко - будете здоровы!', 3),
(4, 'Колбаса', 'Sausage', 16, 'Копченая колбаса.', '<p>Копченая колбаса.', 3),
(1, 'Творог', 'Curd', 10, 'Творожок.', 'Творожок.', 2),
(2, 'Сметана', 'Sour cream', 12, 'Какой-то текст.', 'Какой-то текст.', 2),
(3, 'Кефир', 'Kefir', 13, 'Кефир.', 'Кефир.', 2),
(4, 'Мясо', 'Meat', 16, 'Свежее мясо.', '<p>Свежее мясо.', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `pass` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `pass`) VALUES
(1, 1),
(2, 2),
(3, 3);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
