-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июл 02 2020 г., 18:16
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
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `name`, `name_trans`, `price`, `small_text`, `big_text`, `user_id`) VALUES
(1, 'Пиво', 'Beer', 11, 'Cool beer. Cool beer. Cool bee', 'Cool beer. Cool beer. Cool beer. Cool beer. Cool beer. Cool beer. Cool beer. Cool beer. Cool beer. Cool beer.', 1),
(2, 'Хлеб', 'Bread', 12, 'Crispy bread. Crispy bread. Cr', 'Crispy bread. Crispy bread. Crispy bread. Crispy bread. Crispy bread. Crispy bread. Crispy bread. Crispy bread. ', 1),
(3, 'Молоко', 'Milk', 13, 'Taste milk. Taste milk. Taste ', 'Taste milk. Taste milk. Taste milk. Taste milk. Taste milk. Taste milk. Taste milk. Taste milk. Taste milk. Taste milk. ', 1),
(4, 'Колбаса', 'Sausage', 15, 'Вареная колбаса.', '<div>Вареная колбаса.', 1),
(1, 'Пиво', 'Beer', 11, 'Cool beer. Cool beer. Cool bee', 'Cool beer. Cool beer. Cool beer. Cool beer. Cool beer. Cool beer. Cool beer. Cool beer. Cool beer. Cool beer.', 2),
(2, 'Хлеб', 'Bread', 12, 'Crispy bread. Crispy bread. Cr', 'Crispy bread. Crispy bread. Crispy bread. Crispy bread. Crispy bread. Crispy bread. Crispy bread. Crispy bread. ', 2),
(3, 'Молоко', 'Milk', 13, 'Taste milk. Taste milk. Taste ', 'Taste milk. Taste milk. Taste milk. Taste milk. Taste milk. Taste milk. Taste milk. Taste milk. Taste milk. Taste milk. ', 2),
(4, 'Колбаса', 'Sausage', 15, 'Вареная колбаса.', '<div>Вареная колбаса.', 2),
(5, 'Сыр', 'Cheese', 10, 'Cheesee cheese.', 'Обычный сыр.', 2);

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
-- Индексы таблицы `product`
--
ALTER TABLE `product` ADD FULLTEXT KEY `big_text` (`big_text`);

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
