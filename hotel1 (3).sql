-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 23 2023 г., 21:54
-- Версия сервера: 10.4.27-MariaDB
-- Версия PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `hotel1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `id_payment_method` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `number_of_nights` int(100) NOT NULL,
  `check_in_date` date NOT NULL,
  `booking_date` date NOT NULL,
  `id_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `booking`
--

INSERT INTO `booking` (`id`, `id_payment_method`, `id_user`, `number_of_nights`, `check_in_date`, `booking_date`, `id_status`) VALUES
(30, 1, 7, 2, '2022-12-31', '2022-12-20', 2),
(31, 1, 7, 5, '2023-01-01', '2023-01-01', 2),
(50, 1, 5, 1, '2023-04-01', '2023-03-30', 3),
(51, 1, 2, 4, '2023-04-19', '2023-03-30', 2),
(64, 1, 5, 4, '2023-04-05', '2023-04-05', 2),
(69, 1, 5, 10, '2023-04-19', '2023-04-11', 3),
(70, 1, 13, 4, '2023-04-12', '2023-04-12', 2),
(72, 1, 7, 4, '2023-04-19', '2023-04-15', 2),
(73, 1, 5, 6, '2023-04-24', '2023-04-15', 1),
(83, 1, 3, 4, '2023-05-01', '2023-04-23', 1),
(84, 1, 7, 1, '2023-04-30', '2023-04-23', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `booking_statuses`
--

CREATE TABLE `booking_statuses` (
  `id` int(11) NOT NULL,
  `status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `booking_statuses`
--

INSERT INTO `booking_statuses` (`id`, `status`) VALUES
(1, 'Будущие'),
(2, 'Завершенные'),
(3, 'Отмененные'),
(4, 'Активные');

-- --------------------------------------------------------

--
-- Структура таблицы `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `city ​_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `cities`
--

INSERT INTO `cities` (`id`, `city ​_name`) VALUES
(1, 'Москва'),
(2, 'Екатеринбург');

-- --------------------------------------------------------

--
-- Структура таблицы `configuration`
--

CREATE TABLE `configuration` (
  `id` int(11) NOT NULL,
  `title_configuration` varchar(200) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `configuration`
--

INSERT INTO `configuration` (`id`, `title_configuration`, `description`) VALUES
(1, 'Гипоаллергенные подушки и одеяла', ''),
(2, 'Косметические принадлежности, зубной набор, бритвенный набор', ''),
(3, 'Теплые махровые банные халаты и тапочки', ''),
(4, 'Фен', ''),
(5, 'ЖК телевизор', ''),
(6, 'Телефон', ''),
(7, 'Беспроводной интернет - wifi', ''),
(8, 'Бутилированная вода', ''),
(9, 'Мини-бар', ''),
(10, 'Мультимедийная система + караоке', ''),
(11, 'Джакузи у панорамных окон', ''),
(12, 'Душевая кабина', ''),
(13, 'Оборудованная кухня', ''),
(14, 'Стиральная машина', ''),
(15, 'Ванная', ''),
(16, 'Столовые принадлежности', '');

-- --------------------------------------------------------

--
-- Структура таблицы `hotel_information`
--

CREATE TABLE `hotel_information` (
  `id` int(11) NOT NULL,
  `information` text NOT NULL,
  `id_users` int(11) NOT NULL,
  `nameSite` varchar(1000) NOT NULL,
  `email` varchar(1000) NOT NULL,
  `phone` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `hotel_information`
--

INSERT INTO `hotel_information` (`id`, `information`, `id_users`, `nameSite`, `email`, `phone`) VALUES
(1, 'Night paradise – это теплый прием, безупречное обслуживание и атмосфера доброжелательности, радушия и заботы.', 1, 'NIGHT PARADISE', 'hotelNightParadise@gmail.com', '8(902)-234-34-23'),
(3, '', 1, '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `payment_method`
--

CREATE TABLE `payment_method` (
  `id` int(11) NOT NULL,
  `payment_method` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `payment_method`
--

INSERT INTO `payment_method` (`id`, `payment_method`) VALUES
(1, 'Наличными'),
(2, 'По карте');

-- --------------------------------------------------------

--
-- Структура таблицы `photos_of_the_rooms`
--

CREATE TABLE `photos_of_the_rooms` (
  `id` int(11) NOT NULL,
  `id_room` int(11) NOT NULL,
  `photo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `photos_of_the_rooms`
--

INSERT INTO `photos_of_the_rooms` (`id`, `id_room`, `photo`) VALUES
(1, 5, 'room1.jpg'),
(2, 6, 'room2.jpg'),
(3, 7, 'room3.jpg'),
(4, 8, 'room4.jpg'),
(9, 28, 'room5.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `photo_services`
--

CREATE TABLE `photo_services` (
  `id` int(11) NOT NULL,
  `id_services` int(11) NOT NULL,
  `photo` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `photo_services`
--

INSERT INTO `photo_services` (`id`, `id_services`, `photo`) VALUES
(1, 3, 'bicycle.png'),
(2, 2, 'children\'s center.jpg'),
(5, 1, 'wellness center.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `id_booking` int(11) NOT NULL,
  `review` text NOT NULL,
  `id_moderator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `rights`
--

CREATE TABLE `rights` (
  `id` int(11) NOT NULL,
  `right` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `rights`
--

INSERT INTO `rights` (`id`, `right`) VALUES
(1, 'пользователь'),
(2, 'Контент-менеджер'),
(3, 'Менеджер по работе с клиентами'),
(4, 'главный администратор');

-- --------------------------------------------------------

--
-- Структура таблицы `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room` varchar(100) NOT NULL,
  `id_comfort` int(11) NOT NULL,
  `number_of_guests` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `rooms`
--

INSERT INTO `rooms` (`id`, `room`, `id_comfort`, `number_of_guests`, `description`) VALUES
(5, 'Стандарт 1-местный', 2, 1, 'Уютный номер, площадью 25 кв. м, располагает всем необходимым для комфортного проживания. В номере представлены двуспальная кровать, рабочая зона и ванная комната с душевой кабиной. Из каждого номера открывается потрясающая панорама города, можно выбрать любое направление из четырех: северное, южное, восточное или западное.Максимальное количество гостей в номере: 1.'),
(6, 'Номер 5104', 1, 2, 'Великолепный номер премиум-класса, площадью 60 кв.м., оформленный в классическом стиле в нежных пастельных тонах. Главная изюминка номера - джакузи у панорамных окон, откуда гости могут любоваться по-настоящему захватывающим видом на город. Спальное место — кровать кинг-сайз. Максимальное количество гостей – 2.'),
(7, 'Номер 5105', 1, 1, 'Единственный номер в отеле, площадью 80 кв.м., оформленный в современном стиле. Главная изюминка номера - круглая ванна у панорамных окон, откуда гости могут любоваться по-настоящему захватывающим видом на город. Спальное место — кровать кинг-сайз. Максимальное количество гостей – 2.'),
(8, 'Стандарт 2-местный', 2, 2, 'Номер, площадью 28 кв. м, оснащен роскошной двуспальной кроватью, рабочей зоной и зоной отдыха с журнальным столиком и креслом. Ванная комната располагает всем необходимым: душевые принадлежности, полотенца, халат, тапочки. Номера этой категории расположены в направлениях: северо-восточное, юго-восточное и юго-западное. Номер идеально подходит для семейных пар. В номерах данной категории представлены смежные номера, что позволяет максимально комфортно разместиться семье с детьми.\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\nМаксимальное количество гостей в номере: 2.'),
(28, 'Комната-5', 2, 2, 'Комната - 5');

-- --------------------------------------------------------

--
-- Структура таблицы `rooms_in_the_booking`
--

CREATE TABLE `rooms_in_the_booking` (
  `id` int(11) NOT NULL,
  `id_booking` int(11) NOT NULL,
  `id_room` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `rooms_in_the_booking`
--

INSERT INTO `rooms_in_the_booking` (`id`, `id_booking`, `id_room`) VALUES
(20, 51, 5),
(23, 30, 6),
(24, 31, 6),
(43, 50, 5),
(50, 64, 5),
(51, 64, 7),
(56, 69, 7),
(57, 69, 8),
(58, 70, 5),
(59, 70, 6),
(60, 70, 7),
(61, 70, 8),
(63, 72, 6),
(64, 73, 5),
(65, 73, 6),
(83, 83, 5),
(84, 83, 6),
(85, 84, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `room_comfort`
--

CREATE TABLE `room_comfort` (
  `id` int(11) NOT NULL,
  `title_comfort` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `room_comfort`
--

INSERT INTO `room_comfort` (`id`, `title_comfort`) VALUES
(1, 'люкс'),
(2, 'стандарт');

-- --------------------------------------------------------

--
-- Структура таблицы `room_rates`
--

CREATE TABLE `room_rates` (
  `id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `price_date` date NOT NULL,
  `id_comfort` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `room_rates`
--

INSERT INTO `room_rates` (`id`, `price`, `price_date`, `id_comfort`) VALUES
(1, 1000, '2022-11-05', 1),
(2, 2000, '2022-11-05', 2),
(4, 5000, '2023-03-26', 1),
(5, 4500, '2023-03-28', 1),
(6, 23423, '2023-04-12', 1),
(8, 2147483647, '2023-04-01', 1),
(9, 2147483647, '2023-04-01', 1),
(10, 1, '2023-04-01', 1),
(12, 2, '2023-04-02', 2),
(13, 2300, '2023-04-13', 2),
(16, 3100, '2023-04-16', 2),
(17, 5200, '2023-04-15', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `services`
--

INSERT INTO `services` (`id`, `title`, `description`) VALUES
(1, 'Оздоровительный центр', 'На 14 этаже гостиницы «Президент-Отель» открыта уютная спа-зона, которая поможет снять усталость после тяжелого трудового дня и зарядиться энергией.'),
(2, 'Детский сервис', 'Гостиница «Президент-Отель» с большим удовольствием принимает гостей с детьми и предлагает широкий спектр услуг для комфортного отдыха семей с детьми.'),
(3, 'Велопрокат', 'Уважаемые гости!Предлагаем воспользоваться услугой проката велосипедов и прямо с территории гостиницы совершать поездки по Москве.Для Вашего удобства и безопасности мы предлагаем Вам шлемы и замки, а для гостей с детьми предусмотрены детские кресла.');

-- --------------------------------------------------------

--
-- Структура таблицы `service_prices`
--

CREATE TABLE `service_prices` (
  `id` int(11) NOT NULL,
  `price` float NOT NULL,
  `price_date` date NOT NULL,
  `id_services` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `set_of_equipment`
--

CREATE TABLE `set_of_equipment` (
  `id` int(11) NOT NULL,
  `id_configuration` int(11) NOT NULL,
  `id_comfort` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `set_of_equipment`
--

INSERT INTO `set_of_equipment` (`id`, `id_configuration`, `id_comfort`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(11, 10, 1),
(12, 11, 1),
(13, 12, 2),
(14, 1, 2),
(15, 2, 2),
(17, 4, 2),
(18, 5, 2),
(20, 16, 2),
(21, 13, 2),
(22, 6, 2),
(25, 9, 1),
(26, 8, 1),
(27, 9, 2),
(28, 8, 2),
(29, 3, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `set_of_services`
--

CREATE TABLE `set_of_services` (
  `id` int(11) NOT NULL,
  `id_services` int(11) NOT NULL,
  `id_booking` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `patronymic` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` text NOT NULL,
  `date_registration` date NOT NULL,
  `id_right` int(11) NOT NULL,
  `password` varchar(250) NOT NULL,
  `token` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `patronymic`, `email`, `phone`, `date_registration`, `id_right`, `password`, `token`) VALUES
(1, 'Елена', 'Самохина', 'Константиновн', 'df@df.df', '89123574856', '2022-11-10', 2, '$2y$10$2W8zWJST7ui6uQH3uOac8u0VLP8O9DsnevZ6k080CBywd6F7.TqX6', '4e308303b86f4b0caf5b94e68fae51c423577e93'),
(2, 'Настя', 'Лубкова', 'Сергеевна', 'sam@sam.ru', '81282222222', '2022-11-25', 3, '$2y$10$Wm0MZzzlPRXxJyWz/u9lzetftYzFEE0YcGZwmqWReCJ.3ArJ1kCfK', '7de1470080f91df5aae84d9835baf0429766baa4'),
(3, 'Анжелика', 'Петрова', 'Васильевна', 'len@len.com', '89122323454', '2022-11-25', 4, '$2y$10$7OqtXi2rNi2bDW9KW0lUMOfpT2mkhPypEfDyyKmHXsnXU0TvgsiKq', '9fda2c7f9695750d0bca50482755a66db6841676'),
(5, 'Анастаси', 'Петрова', 'Петровна', 'sam@ld.com', '89234564523', '2022-12-13', 1, '$2y$10$QOTy8t/i/MUXrT4I/px52uPilTZMx9mVfv24IsmwZMzf9aSL.IYiS', '114a260dcd2977b3e9d5d0d5b72dbbf8944b0f46'),
(7, 'Мария', 'Кочнева', 'Андреевна', 'fgg@fdd.gh', '89564543434', '2022-12-06', 1, '$2y$10$OIL9OBUEUlR0ylMhR6IOle/sdcXX.fkG1UujqGUjtCQ9s93jMZWZu', 'fc9d9976af40233d4186076cffe4b0dfab51b76e'),
(9, 'Петр', 'Петров', 'Петровича', 'dff@gfh.c', '89543433434', '2022-12-15', 1, '$2y$10$RGuFE5OxTp6R1rqcyFfmrepqLpxXa8wVloqQYnfdrLhgRb9r/Dffe', ''),
(13, 'Петр', 'Петров', 'Петрович', 'dfjk@sd.ru', '+79237181281', '2023-03-31', 1, '$2y$10$efcCbFxYlXsx7oOIBfemCehoI7GeQ0dTcCD5iJ5NNzWkTaeZvHlSW', '6ef06b86417ae5ffafa480149a62f5c708191e3e'),
(14, 'Петр', 'Петров', 'Петрович', 'ddffjk@sd.ru', '+79237181282', '2023-03-31', 1, '$2y$10$jYb1E4Cg/J.10EFICViVKukHzx1c2xngxI3i9pWsF4xCYYfLMtJjK', '7085b8f57e109b8a2cad45cec78ebfea5a877cb6'),
(15, 'Анна', 'Либерта', 'Мироновна', 'Lubere@list.ru', '+79126256343', '2023-04-17', 1, '$2y$10$VGAGXFBg1aVflKjk13BNVeAkkeDmxxbp.rxZYGOnKEnCGs4TMyMBO', '493bfdb05d1cc9886d3e'),
(17, 'Петр', 'Петров', 'Петровичу', 'dfjkdfdf@sd.ru', '+79267181281', '2023-04-24', 1, '$2y$10$QVTjXp49pOwaK685FTtbyOO/Z/90Mg0i4d/Lg1QR9h3R9pzHND82u', '85726ccf5336283f29af'),
(18, 'Ева', 'Санара', 'Петровна', 'd23fjk@sd.ru', '+79437181281', '2023-04-24', 1, '$2y$10$o77JiL/xtOL2IgJWTlM7JOthlEltembU32qCB18KSeDL6oxKXKO.q', '08ace4ac2fb9097d9a69');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_payment_method` (`id_payment_method`),
  ADD KEY `id_status` (`id_status`);

--
-- Индексы таблицы `booking_statuses`
--
ALTER TABLE `booking_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `configuration`
--
ALTER TABLE `configuration`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `hotel_information`
--
ALTER TABLE `hotel_information`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_users` (`id_users`);

--
-- Индексы таблицы `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `photos_of_the_rooms`
--
ALTER TABLE `photos_of_the_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_room` (`id_room`);

--
-- Индексы таблицы `photo_services`
--
ALTER TABLE `photo_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_services` (`id_services`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_booking` (`id_booking`),
  ADD KEY `id_moderator` (`id_moderator`);

--
-- Индексы таблицы `rights`
--
ALTER TABLE `rights`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_comfort` (`id_comfort`);

--
-- Индексы таблицы `rooms_in_the_booking`
--
ALTER TABLE `rooms_in_the_booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms_in_the_booking_ibfk_1` (`id_room`),
  ADD KEY `id_booking` (`id_booking`);

--
-- Индексы таблицы `room_comfort`
--
ALTER TABLE `room_comfort`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `room_rates`
--
ALTER TABLE `room_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_comfort` (`id_comfort`);

--
-- Индексы таблицы `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `service_prices`
--
ALTER TABLE `service_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_services` (`id_services`);

--
-- Индексы таблицы `set_of_equipment`
--
ALTER TABLE `set_of_equipment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_comfort` (`id_comfort`),
  ADD KEY `id_configuration` (`id_configuration`);

--
-- Индексы таблицы `set_of_services`
--
ALTER TABLE `set_of_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_booking` (`id_booking`),
  ADD KEY `id_services` (`id_services`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_right` (`id_right`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT для таблицы `booking_statuses`
--
ALTER TABLE `booking_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `configuration`
--
ALTER TABLE `configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `photos_of_the_rooms`
--
ALTER TABLE `photos_of_the_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `photo_services`
--
ALTER TABLE `photo_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `rights`
--
ALTER TABLE `rights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT для таблицы `rooms_in_the_booking`
--
ALTER TABLE `rooms_in_the_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT для таблицы `room_comfort`
--
ALTER TABLE `room_comfort`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `room_rates`
--
ALTER TABLE `room_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `service_prices`
--
ALTER TABLE `service_prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `set_of_equipment`
--
ALTER TABLE `set_of_equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `set_of_services`
--
ALTER TABLE `set_of_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`id_payment_method`) REFERENCES `payment_method` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`id_status`) REFERENCES `booking_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `hotel_information`
--
ALTER TABLE `hotel_information`
  ADD CONSTRAINT `hotel_information_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `photos_of_the_rooms`
--
ALTER TABLE `photos_of_the_rooms`
  ADD CONSTRAINT `photos_of_the_rooms_ibfk_1` FOREIGN KEY (`id_room`) REFERENCES `rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `photo_services`
--
ALTER TABLE `photo_services`
  ADD CONSTRAINT `photo_services_ibfk_1` FOREIGN KEY (`id_services`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`id_booking`) REFERENCES `booking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`id_moderator`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`id_comfort`) REFERENCES `room_comfort` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `rooms_in_the_booking`
--
ALTER TABLE `rooms_in_the_booking`
  ADD CONSTRAINT `rooms_in_the_booking_ibfk_1` FOREIGN KEY (`id_room`) REFERENCES `rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rooms_in_the_booking_ibfk_2` FOREIGN KEY (`id_booking`) REFERENCES `booking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `room_rates`
--
ALTER TABLE `room_rates`
  ADD CONSTRAINT `room_rates_ibfk_1` FOREIGN KEY (`id_comfort`) REFERENCES `room_comfort` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `service_prices`
--
ALTER TABLE `service_prices`
  ADD CONSTRAINT `service_prices_ibfk_1` FOREIGN KEY (`id_services`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `set_of_equipment`
--
ALTER TABLE `set_of_equipment`
  ADD CONSTRAINT `set_of_equipment_ibfk_1` FOREIGN KEY (`id_comfort`) REFERENCES `room_comfort` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `set_of_equipment_ibfk_2` FOREIGN KEY (`id_configuration`) REFERENCES `configuration` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `set_of_services`
--
ALTER TABLE `set_of_services`
  ADD CONSTRAINT `set_of_services_ibfk_1` FOREIGN KEY (`id_booking`) REFERENCES `booking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `set_of_services_ibfk_2` FOREIGN KEY (`id_services`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_right`) REFERENCES `rights` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
