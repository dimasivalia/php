-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Час створення: Чрв 18 2024 р., 17:13
-- Версія сервера: 10.4.24-MariaDB
-- Версія PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `todo`
--

-- --------------------------------------------------------

--
-- Структура таблиці `todo`
--

CREATE TABLE `todo` (
  `id` int(11) NOT NULL,
  `sprawa` varchar(60) NOT NULL,
  `czasdodawania` date NOT NULL DEFAULT current_timestamp(),
  `termin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп даних таблиці `todo`
--

INSERT INTO `todo` (`id`, `sprawa`, `czasdodawania`, `termin`) VALUES
(1, 'NULL', '2024-06-16', '2024-06-30'),
(2, 'Urlop', '2024-06-16', '2024-07-04');

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `todo`
--
ALTER TABLE `todo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `todo`
--
ALTER TABLE `todo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
