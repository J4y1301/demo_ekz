-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 24 2024 г., 14:45
-- Версия сервера: 8.0.30
-- Версия PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `lysenko`
--

-- --------------------------------------------------------

--
-- Структура таблицы `problems`
--

CREATE TABLE `problems` (
  `problems_id` int NOT NULL,
  `problems_date_start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `problems_equipment` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `problems_problem` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `problems_describe` text COLLATE utf8mb4_general_ci NOT NULL,
  `problems_user_full_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `problems_date_end` timestamp NULL DEFAULT NULL,
  `problems_status` set('в ожидании','в работе','выполнено') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'в ожидании',
  `problems_users_id` int DEFAULT NULL,
  `problems_workers_id` int DEFAULT NULL,
  `problems_date_diff` time DEFAULT NULL,
  `problems_comment` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `problems`
--

INSERT INTO `problems` (`problems_id`, `problems_date_start`, `problems_equipment`, `problems_problem`, `problems_describe`, `problems_user_full_name`, `problems_date_end`, `problems_status`, `problems_users_id`, `problems_workers_id`, `problems_date_diff`, `problems_comment`) VALUES
(1, '2024-05-21 17:03:40', 'пк', 'не включается', 'сломался', 'Иванов И.И.', NULL, 'в ожидании', 2, NULL, NULL, NULL),
(2, '2024-05-21 17:14:22', 'пк', 'не включается', 'сломался', 'Иванов И.И.', NULL, 'в ожидании', 1, NULL, NULL, NULL),
(3, '2024-05-21 17:15:25', 'пк', 'не включается', 'сгорел', 'Иванов И.И.', NULL, 'в ожидании', 1, NULL, NULL, NULL),
(4, '2024-05-23 22:08:31', 'пк', 'не включается', 'сдох', 'Белоедова', NULL, 'в ожидании', 6, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `users_id` int NOT NULL,
  `users_login` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `users_password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `users_status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`users_id`, `users_login`, `users_password`, `users_status`) VALUES
(1, 'user1', '24c9e15e52afc47c225b757e7bee1f9d', 1),
(2, 'user2', '7e58d63b60197ceb55a1c487989a3720', 1),
(3, 'user3', '92877af70a45fd6a2ed7fe81e1236b78', 1),
(4, 'workers1', 'f4555d314dd3ddccd48b24384c3a6411', 2),
(5, 'workers2', '218e24f6b97ec26e8afe725573e2bdb7', 2),
(6, 'admin', '21232f297a57a5a743894a0e4a801fc3', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `workers`
--

CREATE TABLE `workers` (
  `workers_id` int NOT NULL,
  `workers_full_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `workers`
--

INSERT INTO `workers` (`workers_id`, `workers_full_name`) VALUES
(1, 'Иванов И.И.'),
(2, 'Степанов С.С.');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `problems`
--
ALTER TABLE `problems`
  ADD PRIMARY KEY (`problems_id`),
  ADD KEY `problems_users_id` (`problems_users_id`),
  ADD KEY `problems_workers_id` (`problems_workers_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`);

--
-- Индексы таблицы `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`workers_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `problems`
--
ALTER TABLE `problems`
  MODIFY `problems_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `workers`
--
ALTER TABLE `workers`
  MODIFY `workers_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `problems`
--
ALTER TABLE `problems`
  ADD CONSTRAINT `problems_ibfk_1` FOREIGN KEY (`problems_users_id`) REFERENCES `users` (`users_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `problems_ibfk_2` FOREIGN KEY (`problems_workers_id`) REFERENCES `workers` (`workers_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
