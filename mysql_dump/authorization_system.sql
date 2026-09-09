-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 24 2020 г., 10:26
-- Версия сервера: 5.7.31
-- Версия PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `authorization_system`
--

-- --------------------------------------------------------

--
-- Структура таблицы `authorizationsystem_login_sessions`
--

DROP TABLE IF EXISTS `authorizationsystem_login_sessions`;
CREATE TABLE IF NOT EXISTS `authorizationsystem_login_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token_hash` varchar(64) NOT NULL,
  `ip` varchar(64) NOT NULL,
  `time_of_create` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `authorizationsystem_login_sessions`
--

INSERT INTO `authorizationsystem_login_sessions` (`id`, `token_hash`, `ip`, `time_of_create`, `user_id`) VALUES
(1, 'c3c292590e808ac682bbf49f0411dba4b6ddc03b', '::1', '2020-08-24 10:25:58', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `authorizationsystem_users`
--

DROP TABLE IF EXISTS `authorizationsystem_users`;
CREATE TABLE IF NOT EXISTS `authorizationsystem_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(128) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_first_name` varchar(128) NOT NULL,
  `user_second_name` varchar(128) NOT NULL,
  `user_type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `authorizationsystem_users`
--

INSERT INTO `authorizationsystem_users` (`id`, `user_email`, `user_password`, `user_first_name`, `user_second_name`, `user_type`) VALUES
(1, 'admin@mail.ru', '$2y$10$pVKrSpnwiNgZSKdiWiCzKOoEEJG3kmTwBWkBy5wtEpWq9zbIJAezS', 'Администратор', 'Админовский', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
