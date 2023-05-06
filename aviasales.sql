-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 07 2023 г., 01:50
-- Версия сервера: 5.7.39
-- Версия PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `aviasales`
--

-- --------------------------------------------------------

--
-- Структура таблицы `aircrafts`
--

CREATE TABLE `aircrafts` (
  `aircraft_id` int(11) NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_range` int(11) NOT NULL,
  `seats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `aircrafts`
--

INSERT INTO `aircrafts` (`aircraft_id`, `model`, `max_range`, `seats`) VALUES
(1, 'Туполев Ту-134', 3000, 90),
(2, 'Туполев Ту-154', 5000, 80),
(3, 'Ильюшин ИЛ-62 ', 10000, 86),
(4, 'Ильюшин ИЛ-86 ', 4350, 7),
(5, 'Аэробус Airbus A310', 6000, 88);

-- --------------------------------------------------------

--
-- Структура таблицы `airports`
--

CREATE TABLE `airports` (
  `airport_id` int(11) NOT NULL,
  `airport_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` int(11) NOT NULL,
  `airport_code` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `airports`
--

INSERT INTO `airports` (`airport_id`, `airport_name`, `city_id`, `airport_code`) VALUES
(1, 'Шереметьево', 1, 'SVO'),
(2, 'Казань', 2, 'KZN'),
(3, 'Курумоч', 3, 'KUF'),
(4, 'Пулково', 4, 'LED'),
(5, 'Кольцово', 5, 'SVX');

-- --------------------------------------------------------

--
-- Структура таблицы `appeals`
--

CREATE TABLE `appeals` (
  `appeal_id` int(11) NOT NULL,
  `appeal_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `appeal_date` datetime NOT NULL,
  `appeal_reply` text COLLATE utf8mb4_unicode_ci,
  `appeal_reply_date` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `appeals`
--

INSERT INTO `appeals` (`appeal_id`, `appeal_text`, `appeal_date`, `appeal_reply`, `appeal_reply_date`, `user_id`) VALUES
(1, 'у меня проблема...', '2023-05-07 01:14:18', 'мы решим все', '2023-05-07 01:28:34', 2),
(2, 'fasdfasdgfasfgdfs', '2023-05-07 01:20:42', 'мы вам поможем', '2023-05-07 01:43:57', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `bookings`
--

CREATE TABLE `bookings` (
  `book_id` int(11) NOT NULL,
  `flight_id` int(11) NOT NULL,
  `surname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patronymic` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender_id` int(11) NOT NULL,
  `birth_date` date NOT NULL,
  `document` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `class_id` int(11) NOT NULL,
  `contact_email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `seat_id` int(11) DEFAULT NULL,
  `total_amount` int(111) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `bookings`
--

INSERT INTO `bookings` (`book_id`, `flight_id`, `surname`, `name`, `patronymic`, `gender_id`, `birth_date`, `document`, `booking_date`, `class_id`, `contact_email`, `contact_phone`, `user_id`, `seat_id`, `total_amount`) VALUES
(20, 3, 'Гараев', 'Ильнар', 'Линарович', 1, '2003-01-01', '123123123', '2023-02-07 15:33:35', 3, 'ilnar@mail.ru', '+79176549847', 2, NULL, 44000),
(25, 5, 'Гараев', 'Ильнар', 'Линарович', 1, '2003-01-01', '123123123', '2022-12-29 08:15:00', 2, 'ilnar@mail.ru', '+79176549847', 2, NULL, 12000),
(26, 6, 'Гараев', 'Ильнар', 'Линарович', 1, '2003-01-01', '123123123', '2022-12-29 08:15:00', 2, 'ilnar@mail.ru', '+79176549847', 2, NULL, 7000),
(27, 7, 'Гараев', 'Ильнар', 'Линарович', 1, '2003-01-01', '123123123', '2022-12-29 08:15:00', 2, 'ilnar@mail.ru', '+79176549847', 2, NULL, 16000),
(29, 12, 'Гараев', 'Ильнар', 'Линарович', 1, '2003-04-06', '12 43 234123', '2023-05-06 13:38:54', 3, 'ilnar@mail.ru', '+7 (917) 654-98-47', 2, 9, 18600);

-- --------------------------------------------------------

--
-- Структура таблицы `cities`
--

CREATE TABLE `cities` (
  `city_id` int(11) NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cities`
--

INSERT INTO `cities` (`city_id`, `city`) VALUES
(1, 'Москва'),
(2, 'Казань'),
(3, 'Самара'),
(4, 'Санкт-Петербург'),
(5, 'Екатеринбург');

-- --------------------------------------------------------

--
-- Структура таблицы `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `class` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `classes`
--

INSERT INTO `classes` (`class_id`, `class`, `class_code`) VALUES
(1, 'Первый класс', 'F'),
(2, 'Бизнес-класс', 'C'),
(3, 'Эконом-класс', 'S');

-- --------------------------------------------------------

--
-- Структура таблицы `flights`
--

CREATE TABLE `flights` (
  `flight_id` int(11) NOT NULL,
  `scheduled_departure` datetime NOT NULL,
  `scheduled_arrival` datetime NOT NULL,
  `departure_airport` int(11) NOT NULL,
  `arrival_airport` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `aircraft_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `actual_departure` datetime DEFAULT NULL,
  `actual_arrival` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `flights`
--

INSERT INTO `flights` (`flight_id`, `scheduled_departure`, `scheduled_arrival`, `departure_airport`, `arrival_airport`, `status_id`, `aircraft_id`, `price`, `actual_departure`, `actual_arrival`) VALUES
(1, '2023-04-01 16:40:00', '2023-04-01 23:00:00', 1, 2, 1, 1, 10000, NULL, NULL),
(2, '2023-04-04 17:00:00', '2023-04-04 23:30:00', 2, 1, 1, 4, 11000, NULL, NULL),
(3, '2023-04-04 08:00:00', '2023-04-04 18:30:00', 2, 1, 2, 5, 12000, NULL, NULL),
(4, '2023-04-04 12:30:00', '2023-04-04 22:00:00', 2, 1, 3, 1, 7000, NULL, NULL),
(5, '2023-01-03 14:30:00', '2023-01-03 19:30:00', 5, 3, 3, 3, 12000, '2023-01-03 14:46:00', '2023-01-03 19:38:00'),
(6, '2023-01-01 07:40:00', '2023-01-01 12:40:00', 4, 5, 2, 4, 7000, NULL, NULL),
(7, '2023-01-05 14:10:00', '2023-02-05 21:20:00', 3, 2, 3, 5, 16000, '2023-01-05 14:12:00', '2023-01-05 21:36:00'),
(8, '2023-02-13 17:30:00', '2023-02-13 23:20:00', 2, 3, 2, 2, 8600, NULL, NULL),
(9, '2023-03-01 07:20:00', '2023-03-01 15:30:00', 1, 2, 1, 2, 9000, NULL, NULL),
(10, '2023-02-15 16:40:00', '2023-02-16 04:40:00', 3, 2, 1, 1, 12000, NULL, NULL),
(11, '2023-04-01 22:32:00', '2023-04-01 23:34:00', 1, 2, 1, 1, 12000, NULL, NULL),
(12, '2023-07-01 16:30:00', '2023-07-02 00:20:00', 2, 1, 1, 3, 12000, NULL, NULL),
(13, '2023-07-01 15:42:00', '2023-07-01 21:04:00', 2, 1, 1, 5, 8000, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `genders`
--

CREATE TABLE `genders` (
  `gender_id` int(11) NOT NULL,
  `gender` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `genders`
--

INSERT INTO `genders` (`gender_id`, `gender`) VALUES
(1, 'Мужчина'),
(2, 'Женщина');

-- --------------------------------------------------------

--
-- Структура таблицы `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `notification_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notification_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `notification_date` datetime NOT NULL,
  `flight_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `notifications`
--

INSERT INTO `notifications` (`notification_id`, `notification_title`, `notification_desc`, `notification_date`, `flight_id`) VALUES
(5, 'Произошли изменения в рейсе № 12', 'В рейсе № 12 произошли изменения, просим Вас ознакомиться с изменениями в профиле.', '2023-05-02 12:55:41', 12),
(6, 'Произошли изменения в рейсе № 12', 'В рейсе № 12 произошли изменения, просим Вас ознакомиться с изменениями в профиле.', '2023-05-02 12:56:09', 12),
(7, 'Произошли изменения в рейсе № 12', 'В рейсе № 12 произошли изменения, просим Вас ознакомиться с изменениями в профиле.', '2023-05-06 13:05:06', 12),
(8, 'Произошли изменения в рейсе № 12', 'В рейсе № 12 произошли изменения, просим Вас ознакомиться с изменениями в профиле.', '2023-05-06 13:06:44', 12);

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `review_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `review_date` datetime NOT NULL,
  `review_rate` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`review_id`, `review_text`, `review_date`, `review_rate`, `user_id`) VALUES
(1, 'Отличный сервис', '2023-05-05 01:00:00', 4, 1),
(2, 'Все круто', '2023-05-02 00:00:00', 5, 1),
(3, 'Все круто1', '2023-05-01 00:00:00', 5, 1),
(4, 'Все круто2', '2023-04-17 00:00:00', 5, 1),
(5, 'Все круто3', '2023-04-16 00:00:00', 5, 2),
(6, 'Все круто4', '2023-04-15 00:00:00', 5, 2),
(7, 'Все круто5', '2023-04-14 00:00:00', 5, 2),
(8, 'Все круто6', '2023-04-13 00:00:00', 5, 2),
(9, 'Все круто7', '2023-04-11 00:00:00', 5, 2),
(10, 'Все круто8', '2023-04-08 00:00:00', 5, 2),
(11, 'Все просто супер', '2023-05-06 00:00:00', 5, 2),
(12, 'крутой сервис', '2023-05-06 00:00:00', 5, 2),
(13, 'dsafasdfasdf', '2023-05-06 15:18:45', 5, 2),
(14, 'cxzvzxcvxzcv', '2023-05-06 15:18:48', 5, 2),
(15, 'weqrqwerqwer', '2023-05-06 16:13:42', 4, 2),
(16, 'qwerqwerqwer', '2023-05-06 16:13:48', 4, 2),
(17, 'czxvxcvzxcv', '2023-05-06 16:13:52', 5, 2),
(18, 'qwerqwerqwerqw', '2023-05-06 16:24:34', 4, 2),
(19, 'cxzvzznbvmvbn,bnm.nm,./nm,.nm.,', '2023-05-06 16:24:40', 2, 2),
(20, 'bnvcvbncvbncvbn', '2023-05-06 16:24:44', 1, 2),
(21, 'asdasdasd', '2023-05-06 16:29:31', 5, 2),
(22, 'werqwerqwerwqer', '2023-05-06 16:34:51', 3, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`role_id`, `role`) VALUES
(1, 'USER'),
(2, 'STAFF'),
(3, 'ADMIN');

-- --------------------------------------------------------

--
-- Структура таблицы `seats`
--

CREATE TABLE `seats` (
  `seat_id` int(11) NOT NULL,
  `aircraft_id` int(11) NOT NULL,
  `seat_no` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `seats`
--

INSERT INTO `seats` (`seat_id`, `aircraft_id`, `seat_no`, `class_id`) VALUES
(1, 1, 'A1', 1),
(2, 1, 'B1', 2),
(3, 1, 'C1', 3),
(4, 2, 'A1', 1),
(5, 2, 'B1', 2),
(6, 2, 'C1', 3),
(7, 3, 'A1', 1),
(8, 3, 'B1', 2),
(9, 3, 'C1', 3),
(10, 4, 'A1', 1),
(11, 4, 'B1', 2),
(12, 4, 'C1', 3),
(13, 5, 'A1', 1),
(14, 5, 'B1', 2),
(15, 5, 'C1', 3),
(16, 3, 'C2', 3),
(17, 3, 'C3', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `statuses`
--

CREATE TABLE `statuses` (
  `status_id` int(11) NOT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `statuses`
--

INSERT INTO `statuses` (`status_id`, `status`) VALUES
(1, 'Check-in'),
(2, 'Cancelled'),
(3, 'Landed');

-- --------------------------------------------------------

--
-- Структура таблицы `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `seat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `book_id`, `seat_id`) VALUES
(1, 25, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `surname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patronymic` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_birth` date DEFAULT NULL,
  `login` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `surname`, `name`, `patronymic`, `email`, `phone`, `date_birth`, `login`, `password`, `role_id`) VALUES
(1, 'Кононов', 'Денис', 'Леонидович', 'denis@vk.com', '+7 (394) 823-43-59', '2003-01-01', 'admin', '$2y$10$NbSS7dDQRszOcfHOt44ZMuZ/kbbTWvZ0PjGS8pgCuDY9hYffZ17Fi', 1),
(2, 'Гараев', 'Ильнар', 'Линарович', 'ilnar@mail.ru', '+7 (917) 654-98-47', '2003-04-06', 'ilnar', '$2y$10$lGKUTfGVXz37nZS5Jy.CDuRTXmrWDjlyawg2IUxmKVkU8M0ENsGZW', 3);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `aircrafts`
--
ALTER TABLE `aircrafts`
  ADD PRIMARY KEY (`aircraft_id`);

--
-- Индексы таблицы `airports`
--
ALTER TABLE `airports`
  ADD PRIMARY KEY (`airport_id`),
  ADD KEY `city` (`city_id`);

--
-- Индексы таблицы `appeals`
--
ALTER TABLE `appeals`
  ADD PRIMARY KEY (`appeal_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `flight_id` (`flight_id`),
  ADD KEY `gender` (`gender_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `seat` (`seat_id`);

--
-- Индексы таблицы `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`city_id`);

--
-- Индексы таблицы `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Индексы таблицы `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`flight_id`),
  ADD KEY `departure_airport` (`departure_airport`),
  ADD KEY `arrival_airport` (`arrival_airport`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `aircraft_id` (`aircraft_id`);

--
-- Индексы таблицы `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`gender_id`);

--
-- Индексы таблицы `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `flight_id` (`flight_id`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Индексы таблицы `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`seat_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `aircraft_id` (`aircraft_id`);

--
-- Индексы таблицы `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`status_id`);

--
-- Индексы таблицы `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `seat_id` (`seat_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `aircrafts`
--
ALTER TABLE `aircrafts`
  MODIFY `aircraft_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `airports`
--
ALTER TABLE `airports`
  MODIFY `airport_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `appeals`
--
ALTER TABLE `appeals`
  MODIFY `appeal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `bookings`
--
ALTER TABLE `bookings`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `flights`
--
ALTER TABLE `flights`
  MODIFY `flight_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `genders`
--
ALTER TABLE `genders`
  MODIFY `gender_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `seats`
--
ALTER TABLE `seats`
  MODIFY `seat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `statuses`
--
ALTER TABLE `statuses`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `airports`
--
ALTER TABLE `airports`
  ADD CONSTRAINT `airports_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`);

--
-- Ограничения внешнего ключа таблицы `appeals`
--
ALTER TABLE `appeals`
  ADD CONSTRAINT `appeals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Ограничения внешнего ключа таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`flight_id`) REFERENCES `flights` (`flight_id`),
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`gender_id`) REFERENCES `genders` (`gender_id`),
  ADD CONSTRAINT `bookings_ibfk_4` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`),
  ADD CONSTRAINT `bookings_ibfk_5` FOREIGN KEY (`seat_id`) REFERENCES `seats` (`seat_id`);

--
-- Ограничения внешнего ключа таблицы `flights`
--
ALTER TABLE `flights`
  ADD CONSTRAINT `flights_ibfk_1` FOREIGN KEY (`departure_airport`) REFERENCES `airports` (`airport_id`),
  ADD CONSTRAINT `flights_ibfk_2` FOREIGN KEY (`arrival_airport`) REFERENCES `airports` (`airport_id`),
  ADD CONSTRAINT `flights_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`status_id`),
  ADD CONSTRAINT `flights_ibfk_4` FOREIGN KEY (`aircraft_id`) REFERENCES `aircrafts` (`aircraft_id`);

--
-- Ограничения внешнего ключа таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Ограничения внешнего ключа таблицы `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`),
  ADD CONSTRAINT `seats_ibfk_2` FOREIGN KEY (`aircraft_id`) REFERENCES `aircrafts` (`aircraft_id`);

--
-- Ограничения внешнего ключа таблицы `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `bookings` (`book_id`),
  ADD CONSTRAINT `tickets_ibfk_3` FOREIGN KEY (`seat_id`) REFERENCES `seats` (`seat_id`);

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
