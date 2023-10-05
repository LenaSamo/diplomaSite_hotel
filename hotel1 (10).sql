-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 14 2023 г., 20:23
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
  `number_of_nights` int(50) NOT NULL,
  `check_in_date` date NOT NULL,
  `booking_date` date NOT NULL,
  `id_status` int(11) NOT NULL,
  `paid_or_not` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `booking`
--

INSERT INTO `booking` (`id`, `id_payment_method`, `id_user`, `number_of_nights`, `check_in_date`, `booking_date`, `id_status`, `paid_or_not`) VALUES
(30, 1, 7, 2, '2022-12-31', '2022-12-20', 2, NULL),
(31, 1, 7, 5, '2023-01-01', '2023-01-01', 2, NULL),
(50, 1, 5, 1, '2023-04-01', '2023-03-30', 3, NULL),
(51, 1, 2, 4, '2023-04-19', '2023-03-30', 2, NULL),
(64, 1, 5, 4, '2023-04-05', '2023-04-05', 2, NULL),
(69, 1, 5, 10, '2023-04-19', '2023-04-11', 3, NULL),
(70, 1, 13, 4, '2023-04-12', '2023-04-12', 2, NULL),
(72, 1, 7, 4, '2023-04-19', '2023-04-15', 2, NULL),
(73, 1, 5, 5, '2023-04-24', '2023-04-15', 2, 1),
(97, 1, 5, 4, '2023-05-02', '2023-05-01', 2, 1),
(104, 1, 34, 6, '2023-05-11', '2023-05-04', 2, 1),
(107, 1, 34, 2, '2023-05-08', '2023-05-04', 3, 0),
(108, 1, 1, 4, '2023-05-19', '2023-05-08', 2, 0),
(109, 1, 17, 5, '2023-05-16', '2023-05-10', 2, NULL),
(112, 1, 3, 3, '2023-06-01', '2023-05-30', 2, 1),
(116, 1, 9, 4, '2023-06-07', '2023-06-04', 2, 1),
(125, 1, 34, 5, '2023-06-12', '2023-06-06', 4, 1),
(128, 1, 1, 6, '2023-06-12', '2023-06-12', 4, 1),
(129, 1, 9, 7, '2023-06-26', '2023-06-12', 1, 1),
(130, 1, 1, 6, '2023-07-03', '2023-06-12', 1, NULL),
(131, 1, 46, 2, '2023-06-13', '2023-06-12', 2, 0),
(134, 1, 1, 18, '2023-06-20', '2023-06-12', 3, 1),
(138, 1, 46, 12, '2023-06-26', '2023-06-14', 1, NULL),
(139, 1, 44, 3, '2023-06-14', '2023-06-14', 4, 1),
(140, 1, 42, 7, '2023-06-14', '2023-06-14', 4, NULL),
(141, 1, 9, 3, '2023-06-14', '2023-06-14', 4, 1),
(144, 1, 42, 4, '2023-07-10', '2023-06-14', 1, NULL),
(147, 1, 46, 2, '2023-07-07', '2023-06-14', 1, 1),
(148, 1, 45, 6, '2023-07-17', '2023-06-14', 1, NULL);

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
(1, 'Гипоаллергенные подушки', ''),
(2, 'Косметические принадлежности, зубной набор, бритвенный набор', ''),
(3, 'Теплые махровые банные халаты и тапочки', ''),
(4, 'Фен', ''),
(5, 'ЖК телевизор', ''),
(8, 'Бутилированная вода', ''),
(9, 'Мини-бар', ''),
(10, 'Мультимедийная система + караоке', ''),
(11, 'Джакузи у панорамных окон', ''),
(12, 'Душевая кабина', ''),
(13, 'Оборудованная кухня', ''),
(14, 'Стиральная машина', ''),
(16, 'Столовые принадлежности', ''),
(21, 'Ванная', '');

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
  `phone` varchar(1000) NOT NULL,
  `info_hotel` text NOT NULL,
  `address` varchar(1000) NOT NULL,
  `img` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `hotel_information`
--

INSERT INTO `hotel_information` (`id`, `information`, `id_users`, `nameSite`, `email`, `phone`, `info_hotel`, `address`, `img`) VALUES
(1, 'Night paradise – это теплый прием, безупречное обслуживание и атмосфера доброжелательности, радушия и заботы.', 1, 'NIGHT PARADISE', 'hotelNightParadise1@gmail.co', '+7(902)234-39-84', 'В нашем отеле любители здорового образа жизни могут посетить спортзал, где к их услугам предоставлен личный тренер. На первом этаже отеля расположена столовая, которая ориентирована на посетителей со средним достатком.', ' ул. имени Александра Королёва, 2А', '298795.jpg'),
(7, '', 1, '', '', '', 'Так же на первом этаже расположен бар, где посетители отеля могут провести время в приятной компании, попробовать фирменные коктейли и послушать живую музыку. Кухня бара работает круглосуточно, что позволяет обеспечить 24-х часовой сервис.', '', ''),
(8, '', 1, '', '', '', 'Интересной на наш взгляд задумкой, является библиотека, расположенная на втором этаже отеля. Здесь можно уединиться, почитать любимое произведение, провести время за компьютером. В библиотеке есть бесплатный wi-fi.', '', ''),
(16, '', 1, '', '', '', 'На третьем этаже отеля расположен ночной клуб, где каждый день проходят тематические вечеринки. Во дворе отеля есть открытый бассейн с оборудованными шезлонгами. Наш отель придется по вкусу как любителям спокойного, размеренного, так и любителям активного, насыщенного отдыха.', '', '');

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
(2, 6, 'room2.jpg'),
(65, 28, 'Studio-01.jpg'),
(66, 63, 'hotel-visotsky-vip-rooms-5102-01.jpg'),
(67, 63, 'hotel-visotsky-vip-rooms-5102-02.jpg'),
(68, 63, 'hotel-visotsky-vip-rooms-5102-03.jpg'),
(82, 6, 'AX5A9581(sm).jpg'),
(88, 76, 'hotel-visotsky-rooms-deluxe-01.jpg'),
(90, 77, 'room5.jpg'),
(92, 79, 'room1.jpg');

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
(5, 1, 'wellness center.jpg'),
(8, 3, '0f77ef53-80b3-4c90-aec5-432bc059eb7a.jpeg'),
(19, 2, '16850.jpg'),
(27, 1, 'woman-at-physiotherapy-making-physical-exercises-with-qualified-therapist_1157-38100.jpg');

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
(6, 'Номер 5104', 1, 2, 'Великолепный номер премиум-класса, площадью 60 кв.м., оформленный в классическом стиле в нежных пастельных тонах. Главная изюминка номера - джакузи у панорамных окон, откуда гости могут любоваться по-настоящему захватывающим видом на город. Спальное место — кровать кинг-сайз. Максимальное количество гостей – 2.'),
(28, 'Номер 302', 15, 2, 'Номер, площадью 25-30 кв. м, оснащен роскошной двуспальной кроватью, рабочей зоной и зоной отдыха. Ванная комната располагает всем необходимым: стиральная машина, душевые принадлежности, полотенца, халат, тапочки. Панорамное остекление с видом на любую из четырёх сторон света: север, юг, запад, восток. Номер идеально подходит для семейных пар.Максимальное количество гостей в номере: 2.'),
(63, 'Номер 5902', 1, 3, 'Роскошный, двухкомнатный номер площадью 100 кв.м. с индивидуальным классическим дизайном порадует гостей своим высоким уровнем комфорта, качественной мебелью и джакузи у панорамных окон в элегантной ванной комнате. Просторная гостиная подойдет как для празднования семейных торжеств, так и для деловых переговоров. Спальное место — кровать кинг-сайз. Максимальное количество гостей – 2.'),
(76, 'Номер 201', 2, 1, 'Уютный номер, площадью 25 кв. м, располагает всем необходимым для комфортного проживания. В номере представлены двуспальная кровать, рабочая зона и ванная комната с душевой кабиной. Из каждого номера открывается потрясающая панорама города, можно выбрать любое направление из четырех: северное, южное, восточное или западное.Максимальное количество гостей в номере: 1.'),
(77, 'Номер 207', 2, 2, 'Номера категории Делюкс обладают площадью 30 кв.м. В номере располагается роскошная двуспальная кровать, рабочая зона, зона отдыха, и ванная комната, оборудованная всем необходимым. Также в номере можно разместить дополнительную кровать. Из номеров открывается вид на центральные улицы города: Малышева, Ленина и Карла Либкнехта. Максимальное количество гостей в номере: 2.'),
(79, 'Номер 555', 1, 2, 'Номера категории Делюкс обладают площадью 30 кв.м. В номере располагается роскошная двуспальная кровать, рабочая зона, зона отдыха, и ванная комната, оборудованная всем необходимым. Также в номере можно разместить дополнительную кровать. Из номеров открывается вид на центральные улицы города: Малышева, Ленина и Карла Либкнехта. Максимальное количество гостей в номере: 2.');

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
(23, 30, 6),
(24, 31, 6),
(59, 70, 6),
(101, 97, 6),
(110, 104, 6),
(121, 112, 6),
(127, 116, 63),
(140, 125, 76),
(143, 128, 28),
(144, 129, 76),
(145, 129, 77),
(146, 130, 63),
(147, 131, 77),
(150, 134, 6),
(154, 138, 28),
(155, 138, 79),
(156, 139, 79),
(157, 140, 6),
(158, 141, 63),
(161, 144, 76),
(162, 144, 77),
(165, 147, 76),
(166, 147, 77),
(167, 148, 76);

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
(2, 'стандарт'),
(15, 'vip');

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
(4, 5000, '2023-03-26', 1),
(5, 4500, '2023-03-28', 1),
(6, 23423, '2023-04-12', 1),
(8, 2147483647, '2023-04-01', 1),
(9, 2147483647, '2023-04-01', 1),
(17, 5200, '2023-04-15', 1),
(32, 3100, '2023-05-10', 1),
(34, 3100, '2023-05-19', 2),
(40, 3000, '2023-06-11', 2),
(41, 5500, '2023-06-06', 15),
(43, 6000, '2023-06-08', 15),
(49, 2000, '2023-07-01', 2);

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
(15, 2, 2),
(17, 4, 2),
(18, 5, 2),
(20, 16, 2),
(27, 9, 2),
(28, 8, 2),
(29, 3, 2),
(30, 3, 1),
(31, 1, 1),
(32, 2, 1),
(33, 4, 1),
(34, 5, 1),
(36, 9, 1),
(43, 10, 1),
(45, 11, 1),
(46, 21, 1),
(53, 1, 15),
(54, 2, 15),
(55, 3, 15),
(56, 4, 15),
(57, 5, 15),
(58, 9, 15),
(87, 8, 1),
(93, 12, 2);

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
  `name` varchar(1000) NOT NULL,
  `surname` varchar(1000) NOT NULL,
  `patronymic` varchar(1000) NOT NULL,
  `email` varchar(1000) NOT NULL,
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
(1, 'Мария', 'Самохина', 'Константиновна', 'Lubere@list.ru', '+7(912)625-67-90', '2022-11-10', 1, '$2y$10$XGrWzn/0u6V2pFOv14AQ1uY5zRFVHdcCQCi59Kv4.Lp.qU8ZCpA6C', 'ca1977c7014ce31bbb0957b2e5f9bd24f4117edb'),
(2, 'Настя', 'Лубкова', 'Мироновна', 'sam@sam.ru', '+7(812)822-22-22', '2022-11-25', 2, '$2y$10$Wm0MZzzlPRXxJyWz/u9lzetftYzFEE0YcGZwmqWReCJ.3ArJ1kCfK', '03246ffad9ed214e8116ec9dbdc2371e876fdf50'),
(3, 'Анжелика', 'Петрова', 'Васильевна', 'len@len.com', '+7(891)223-23-45', '2022-11-25', 4, '$2y$10$7OqtXi2rNi2bDW9KW0lUMOfpT2mkhPypEfDyyKmHXsnXU0TvgsiKq', '978a347513fcc8b6d7d281c6c735675ce5788b14'),
(5, 'Анастасия', 'Петрова', 'Петровна', 'sam@ld.com', '+7(892)345-64-52', '2022-12-13', 3, '$2y$10$GtixeLbjjqap6Q1NxjRPo.3q1bN3Obdav4OsIcYFTU0uTnPkw6hqq', '9f2ac450e963db91d72a3b2cf9cba6788d0a170b'),
(7, 'Мария', 'Кочнева', 'Андреевна', 'fgg@fdd.gh', '+7(895)645-43-43', '2022-12-06', 3, '$2y$10$OIL9OBUEUlR0ylMhR6IOle/sdcXX.fkG1UujqGUjtCQ9s93jMZWZu', 'fc9d9976af40233d4186076cffe4b0dfab51b76e'),
(9, 'Алексей', 'Петров', 'Петровича', 'dff@gfh.c', '+7(789)543-43-34', '2022-12-15', 1, '$2y$10$RGuFE5OxTp6R1rqcyFfmrepqLpxXa8wVloqQYnfdrLhgRb9r/Dffe', ''),
(13, 'Петр', 'Петров', 'Петрович', 'dfjk@sd.ru', '+7(923)718-12-81', '2023-03-31', 2, '$2y$10$efcCbFxYlXsx7oOIBfemCehoI7GeQ0dTcCD5iJ5NNzWkTaeZvHlSW', '42040d032e3cd29cc2ab8041f82284f8300c1350'),
(14, 'Виктор', 'Петров', 'Петрович', 'ddffj23k@sd.ru', '+7(923)718-12-82', '2023-03-31', 2, '$2y$10$jYb1E4Cg/J.10EFICViVKukHzx1c2xngxI3i9pWsF4xCYYfLMtJjK', '7085b8f57e109b8a2cad45cec78ebfea5a877cb6'),
(17, 'Петр', 'Петров', 'Петрович', 'dfjkdfdf@sd.ru', '+7(926)618-12-81', '2023-04-24', 1, '$2y$10$1IHJA7leJk8QahIc/PTMMuKUGs1jtgaXzOh6zdScNrdQ.RcetR8ae', '339320f362536d557f05b8b2ad6f13beb4e4fd67'),
(34, 'Михаил', 'Михнарев', 'Артемьевич', 'ghj@fjk.ru', '+7(923)945-45-45', '2023-05-05', 1, '$2y$10$dmlaXU6rurU77xOKwY/xauA/zMQjQj5WTPgxNVhFMlwXdRsnrNadq', 'de2bace6c835a19a51ff'),
(37, 'Анна', 'Мазель', 'Георгиевна', 'sdf_sf@dg.com', '+7(128)222-22-22', '2023-06-04', 3, '$2y$10$trOhkmJYQmnZWF5oryaXJ.e0xJZefUw6S5.ZIv/WiUSTjh/Wma.ai', ''),
(42, 'Англена', 'Татар', 'Мировановна', 'gjkj@list.rue', '+7(912)625-67-25', '2023-06-12', 1, '$2y$10$SAkvWmW6PjhjHo/PXeOUzebH04R6Mquv1VCOvsRkz0CAxIPwLcsTq', '390c4683d5c5901dea8e'),
(43, 'Виктория', 'Орлова', 'Мироновна', 'victoyu@list.ru', '+7(912)658-63-45', '2023-06-12', 1, '$2y$10$bsWi1aFLuB6EBvZwstgf9OEmk8px8HfgRkKHnKB2UZn3vix03b0Ty', '188651c90b3d5f6c47c4'),
(44, 'Алексей', 'Бажов', 'Михайлович', 'bagov@gmail.com', '+7(984)754-12-64', '2023-06-12', 1, '$2y$10$3duiTnhfI1m5MXEal7JdROhMUFVY/pLg7FXIfp6cZAFETLMjZjvGy', '692b6985221bf3b56d48'),
(45, 'Антон', 'Пакулов', 'Сергеевич', 'anton_18@gmail.com', '+7(978)451-12-55', '2023-06-12', 1, '$2y$10$Y4Mo.NT3vQNLipkl1ejv.uYNCQDV2n2UVHJ/Q4IG.ndx1JIBMRFZi', '95f06404b7df58c896aca9526589489590cf4adc'),
(46, 'Юрий', 'Фасин', 'Петрович', 'yu_12Fase@gmail.com', '+79126256705', '2023-06-12', 1, '$2y$10$6NupqzxfZM6b8/HCHyFNe..d2QRq09lSNTwQ1rieIL/Ru6ODYVON2', 'b5eb5348dff19262738b'),
(51, 'Руслан', 'Мизазов', 'Геннадьевич', 'mun@gmail.com', '+7(985)475-54-77', '2023-06-14', 2, '$2y$10$NAhVbroEUZ08ELCILBiTw./RiQTf0DOh0a6Ja/S8ZPKneNECan0EK', '');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `hotel_information`
--
ALTER TABLE `hotel_information`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT для таблицы `photo_services`
--
ALTER TABLE `photo_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT для таблицы `rooms_in_the_booking`
--
ALTER TABLE `rooms_in_the_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT для таблицы `room_comfort`
--
ALTER TABLE `room_comfort`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `room_rates`
--
ALTER TABLE `room_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT для таблицы `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `service_prices`
--
ALTER TABLE `service_prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `set_of_equipment`
--
ALTER TABLE `set_of_equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT для таблицы `set_of_services`
--
ALTER TABLE `set_of_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

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
