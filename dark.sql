-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 20 2023 г., 23:40
-- Версия сервера: 10.7.5-MariaDB
-- Версия PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `dark`
--

-- --------------------------------------------------------

--
-- Структура таблицы `code`
--

CREATE TABLE `code` (
  `id` int(10) UNSIGNED NOT NULL,
  `on` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `code`
--

INSERT INTO `code` (`id`, `on`) VALUES
(1, '');

-- --------------------------------------------------------

--
-- Структура таблицы `color`
--

CREATE TABLE `color` (
  `id` int(10) UNSIGNED NOT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `color`
--

INSERT INTO `color` (`id`, `color`) VALUES
(1, 'custom');

-- --------------------------------------------------------

--
-- Структура таблицы `curr`
--

CREATE TABLE `curr` (
  `id` int(11) UNSIGNED NOT NULL,
  `on` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `curr`
--

INSERT INTO `curr` (`id`, `on`) VALUES
(1, 'on');

-- --------------------------------------------------------

--
-- Структура таблицы `customcolor`
--

CREATE TABLE `customcolor` (
  `id` int(10) UNSIGNED NOT NULL,
  `color1` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `color2` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `customcolor`
--

INSERT INTO `customcolor` (`id`, `color1`, `color2`) VALUES
(1, '#6a57ff', '#b6b9fb');

-- --------------------------------------------------------

--
-- Структура таблицы `design`
--

CREATE TABLE `design` (
  `id` int(11) UNSIGNED NOT NULL,
  `on` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `design`
--

INSERT INTO `design` (`id`, `on`) VALUES
(1, 'on');

-- --------------------------------------------------------

--
-- Структура таблицы `discord`
--

CREATE TABLE `discord` (
  `id` int(11) UNSIGNED NOT NULL,
  `on` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `discord`
--

INSERT INTO `discord` (`id`, `on`) VALUES
(1, '');

-- --------------------------------------------------------

--
-- Структура таблицы `docs`
--

CREATE TABLE `docs` (
  `id` int(10) UNSIGNED NOT NULL,
  `on` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `docs`
--

INSERT INTO `docs` (`id`, `on`) VALUES
(1, '');

-- --------------------------------------------------------

--
-- Структура таблицы `donate`
--

CREATE TABLE `donate` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `price` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `text` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `curr` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `cmd` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `img` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `on` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `kategory` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `list` tinyint(3) UNSIGNED DEFAULT NULL,
  `on1` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `sale` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `donate`
--

INSERT INTO `donate` (`id`, `name`, `price`, `text`, `curr`, `cmd`, `img`, `on`, `kategory`, `list`, `on1`, `type`, `sale`) VALUES
(3, 'СОЗДАТЕЛЬ', '11', '111', 'USD', '111', 'allay.png', 'on', 'Привилегии', 1, 'off', 'donate', 'Еблан'),
(9, 'Кейсы (10 шт)', '1', '11', 'USD', '11 %ИГРОК%', 'allay.png', 'off', 'Кейсы', 2, 'off', 'donate', '-');

-- --------------------------------------------------------

--
-- Структура таблицы `enot`
--

CREATE TABLE `enot` (
  `id` int(10) UNSIGNED NOT NULL,
  `shop_id` int(10) UNSIGNED DEFAULT NULL,
  `secret_key` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `secret_key2` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `kategory`
--

CREATE TABLE `kategory` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `kategory`
--

INSERT INTO `kategory` (`id`, `name`) VALUES
(2, 'Привилегии'),
(3, 'Кейсы');

-- --------------------------------------------------------

--
-- Структура таблицы `links`
--

CREATE TABLE `links` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `links`
--

INSERT INTO `links` (`id`, `title`, `link`, `color`) VALUES
(1, 'Youtube', 'youtube.com', '#ff0000'),
(2, 'Discord', 'discord.com', '#7300ff');

-- --------------------------------------------------------

--
-- Структура таблицы `login`
--

CREATE TABLE `login` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `lastlogin` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `login`
--

INSERT INTO `login` (`id`, `login`, `password`, `lastlogin`) VALUES
(1, 'admin', '$2y$10$ymw9poy01pVUuF0iYKfRLOvuDJ4t5SE19CWpAEBpg3qN3wpQLT9D.', '20.12.2023 в 23:29');

-- --------------------------------------------------------

--
-- Структура таблицы `maintext`
--

CREATE TABLE `maintext` (
  `id` int(10) UNSIGNED NOT NULL,
  `text` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `maintext`
--

INSERT INTO `maintext` (`id`, `text`) VALUES
(1, 'Наш сервер предлагает окунутся в мир как никогда популярного гриферского выживания. Стройте базу, убивайте игроков, создайте свой клан, найдите новых друзей!');

-- --------------------------------------------------------

--
-- Структура таблицы `moder`
--

CREATE TABLE `moder` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `prof` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `text` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `contacts` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `moder`
--

INSERT INTO `moder` (`id`, `name`, `email`, `prof`, `text`, `contacts`, `link`) VALUES
(1, '', 'fefef@fefe.t', 'Тестер', 'fefef', 'fefe', ''),
(2, 'dark', 'driko042@gmail.com', 'Тестер', 'dwdwdw', 'dwdwdw', '');

-- --------------------------------------------------------

--
-- Структура таблицы `obj`
--

CREATE TABLE `obj` (
  `id` int(10) UNSIGNED NOT NULL,
  `text` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `obj`
--

INSERT INTO `obj` (`id`, `text`) VALUES
(1, 'Пароль и логин от админки: admin/admin');

-- --------------------------------------------------------

--
-- Структура таблицы `oferta`
--

CREATE TABLE `oferta` (
  `id` int(10) UNSIGNED NOT NULL,
  `text` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `oferta`
--

INSERT INTO `oferta` (`id`, `text`) VALUES
(1, 'Текст публичной\r\nоферты');

-- --------------------------------------------------------

--
-- Структура таблицы `onas`
--

CREATE TABLE `onas` (
  `id` int(10) UNSIGNED NOT NULL,
  `text` text COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `onas`
--

INSERT INTO `onas` (`id`, `text`) VALUES
(1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatatп');

-- --------------------------------------------------------

--
-- Структура таблицы `opis`
--

CREATE TABLE `opis` (
  `id` int(11) UNSIGNED NOT NULL,
  `on` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `opis`
--

INSERT INTO `opis` (`id`, `on`) VALUES
(1, '');

-- --------------------------------------------------------

--
-- Структура таблицы `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `nick` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `donate_id` int(10) UNSIGNED DEFAULT NULL,
  `curr` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `amount` int(10) UNSIGNED DEFAULT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `payment_system` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `time` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `payments`
--

INSERT INTO `payments` (`id`, `nick`, `donate_id`, `curr`, `amount`, `date`, `payment_system`, `status`, `time`) VALUES
(1, 'Driko42', 3, 'USD', 11, '21.05.2023', 'Enot.io', 'Оплачено', NULL),
(2, 'Driko42', 3, 'USD', 11, '21.05.2023', 'UnitPay', 'Не оплачено', NULL),
(3, 'р', 3, 'USD', 11, '21.05.2023', 'UnitPay', 'Не оплачено', NULL),
(4, 'р', 3, 'USD', 11, '21.05.2023', 'UnitPay', 'Не оплачено', NULL),
(5, 'fefefef', 3, 'USD', 11, '08.07.2023', 'FreeKassa', 'Не оплачено', '02:53'),
(6, 'fefefef', 3, 'USD', 11, '08.07.2023', 'FreeKassa', 'Не оплачено', '02:53'),
(7, 'fefefef', 3, 'USD', 11, '08.07.2023', 'FreeKassa', 'Не оплачено', '02:53');

-- --------------------------------------------------------

--
-- Структура таблицы `preloader`
--

CREATE TABLE `preloader` (
  `id` int(10) UNSIGNED NOT NULL,
  `on` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `preloader`
--

INSERT INTO `preloader` (`id`, `on`) VALUES
(1, '');

-- --------------------------------------------------------

--
-- Структура таблицы `privacy`
--

CREATE TABLE `privacy` (
  `id` int(10) UNSIGNED NOT NULL,
  `text` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `privacy`
--

INSERT INTO `privacy` (`id`, `text`) VALUES
(1, 'Политика в отношении обработки персональных данных');

-- --------------------------------------------------------

--
-- Структура таблицы `promo`
--

CREATE TABLE `promo` (
  `id` int(10) UNSIGNED NOT NULL,
  `promo` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `sale` int(10) UNSIGNED DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `rcon`
--

CREATE TABLE `rcon` (
  `id` int(10) UNSIGNED NOT NULL,
  `host` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `port` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `rules`
--

CREATE TABLE `rules` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `text` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `rules`
--

INSERT INTO `rules` (`id`, `name`, `text`) VALUES
(8, 'Чат', 'ведите себя хорошо');

-- --------------------------------------------------------

--
-- Структура таблицы `sales`
--

CREATE TABLE `sales` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `sale` int(10) UNSIGNED DEFAULT NULL,
  `daten` date DEFAULT NULL,
  `datek` date DEFAULT NULL,
  `donates` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `sales`
--

INSERT INTO `sales` (`id`, `name`, `sale`, `daten`, `datek`, `donates`) VALUES
(1, 'Еблан', 10, '2023-12-17', '2023-12-31', '[3]');

-- --------------------------------------------------------

--
-- Структура таблицы `serverversion`
--

CREATE TABLE `serverversion` (
  `id` int(11) UNSIGNED NOT NULL,
  `version` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `serverversion`
--

INSERT INTO `serverversion` (`id`, `version`) VALUES
(1, '1.8-1.20');

-- --------------------------------------------------------

--
-- Структура таблицы `shopsettings`
--

CREATE TABLE `shopsettings` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `ip` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `mail` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `shopsettings`
--

INSERT INTO `shopsettings` (`id`, `name`, `ip`, `mail`) VALUES
(1, 'Dark.', 'hypixel.net', 'dark@dark.test');

-- --------------------------------------------------------

--
-- Структура таблицы `show`
--

CREATE TABLE `show` (
  `id` int(11) UNSIGNED NOT NULL,
  `on` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `show`
--

INSERT INTO `show` (`id`, `on`) VALUES
(1, ''),
(3, ''),
(4, ''),
(5, '');

-- --------------------------------------------------------

--
-- Структура таблицы `snow`
--

CREATE TABLE `snow` (
  `id` int(11) UNSIGNED NOT NULL,
  `on` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `snow`
--

INSERT INTO `snow` (`id`, `on`) VALUES
(1, 'on');

-- --------------------------------------------------------

--
-- Структура таблицы `static`
--

CREATE TABLE `static` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `page` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `stats`
--

CREATE TABLE `stats` (
  `id` int(10) UNSIGNED NOT NULL,
  `all` int(10) UNSIGNED DEFAULT NULL,
  `main` int(10) UNSIGNED DEFAULT NULL,
  `rules` int(10) UNSIGNED DEFAULT NULL,
  `donate` int(10) UNSIGNED DEFAULT NULL,
  `play` int(10) UNSIGNED DEFAULT NULL,
  `docs` int(10) UNSIGNED DEFAULT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `stats`
--

INSERT INTO `stats` (`id`, `all`, `main`, `rules`, `donate`, `play`, `docs`, `date`) VALUES
(4, 25, 17, 3, 4, 1, 0, '04.24.23'),
(5, 3, 3, 0, 0, 0, 0, '04.25.23'),
(6, 2, 2, 0, 0, 0, 0, '04.26.23'),
(7, 8, 8, 0, 0, 0, 0, '04.27.23'),
(8, 44, 44, 0, 0, 0, 0, '04.28.23'),
(9, 3, 3, 0, 0, 0, 0, '04.29.23'),
(10, 27, 27, 0, 0, 0, 0, '04.30.23'),
(11, 87, 86, 0, 1, 0, 0, '05.01.23'),
(12, 23, 23, 0, 0, 0, 0, '05.02.23'),
(13, 1, 1, 0, 0, 0, 0, '05.03.23'),
(14, 2, 2, 0, 0, 0, 0, '05.04.23'),
(15, 23, 22, 0, 1, 0, 0, '05.05.23'),
(16, 92, 91, 0, 1, 0, 0, '05.06.23'),
(17, 1, 1, 0, 0, 0, 0, '05.07.23'),
(18, 1, 1, 0, 0, 0, 0, '05.10.23'),
(19, 3, 3, 0, 0, 0, 0, '05.11.23'),
(20, 14, 14, 0, 0, 0, 0, '05.16.23'),
(21, 29, 29, 0, 0, 0, 0, '05.17.23'),
(22, 59, 58, 0, 0, 1, 0, '05.18.23'),
(23, 16, 16, 0, 0, 0, 0, '05.19.23'),
(24, 6, 6, 0, 0, 0, 0, '05.21.23'),
(25, 1, 1, 0, 0, 0, 0, '05.22.23'),
(26, 5, 5, 0, 0, 0, 0, '05.23.23'),
(27, 4, 4, 0, 0, 0, 0, '05.25.23'),
(28, 8, 8, 0, 0, 0, 0, '05.26.23'),
(29, 17, 15, 1, 1, 0, 0, '07.01.23'),
(30, 5, 4, 0, 1, 0, 0, '07.02.23'),
(31, 2, 2, 0, 0, 0, 0, '07.05.23'),
(32, 1, 1, 0, 0, 0, 0, '07.06.23'),
(33, 19, 18, 0, 1, 0, 0, '07.07.23'),
(34, 8, 8, 0, 0, 0, 0, '07.08.23'),
(35, 264, 264, 0, 0, 0, 0, '12.17.23'),
(36, 85, 84, 0, 1, 0, 0, '12.18.23'),
(37, 22, 8, 4, 10, 0, 0, '12.19.23'),
(38, 268, 182, 18, 35, 15, 18, '12.20.23');

-- --------------------------------------------------------

--
-- Структура таблицы `unitpay`
--

CREATE TABLE `unitpay` (
  `id` int(10) UNSIGNED NOT NULL,
  `shop_id` int(10) UNSIGNED DEFAULT NULL,
  `secret_key` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `public_key` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `code`
--
ALTER TABLE `code`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `curr`
--
ALTER TABLE `curr`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `customcolor`
--
ALTER TABLE `customcolor`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `design`
--
ALTER TABLE `design`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `discord`
--
ALTER TABLE `discord`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `docs`
--
ALTER TABLE `docs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `donate`
--
ALTER TABLE `donate`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `enot`
--
ALTER TABLE `enot`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_enot_shop` (`shop_id`);

--
-- Индексы таблицы `kategory`
--
ALTER TABLE `kategory`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `maintext`
--
ALTER TABLE `maintext`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `moder`
--
ALTER TABLE `moder`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `obj`
--
ALTER TABLE `obj`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oferta`
--
ALTER TABLE `oferta`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `onas`
--
ALTER TABLE `onas`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `opis`
--
ALTER TABLE `opis`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_payments_donate` (`donate_id`);

--
-- Индексы таблицы `preloader`
--
ALTER TABLE `preloader`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `privacy`
--
ALTER TABLE `privacy`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `promo`
--
ALTER TABLE `promo`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `rcon`
--
ALTER TABLE `rcon`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `serverversion`
--
ALTER TABLE `serverversion`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `shopsettings`
--
ALTER TABLE `shopsettings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `show`
--
ALTER TABLE `show`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `snow`
--
ALTER TABLE `snow`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `static`
--
ALTER TABLE `static`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `stats`
--
ALTER TABLE `stats`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `unitpay`
--
ALTER TABLE `unitpay`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_unitpay_shop` (`shop_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `code`
--
ALTER TABLE `code`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `color`
--
ALTER TABLE `color`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `curr`
--
ALTER TABLE `curr`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `customcolor`
--
ALTER TABLE `customcolor`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `design`
--
ALTER TABLE `design`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `discord`
--
ALTER TABLE `discord`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `docs`
--
ALTER TABLE `docs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `donate`
--
ALTER TABLE `donate`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `enot`
--
ALTER TABLE `enot`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `kategory`
--
ALTER TABLE `kategory`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `links`
--
ALTER TABLE `links`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `login`
--
ALTER TABLE `login`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `maintext`
--
ALTER TABLE `maintext`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `moder`
--
ALTER TABLE `moder`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `obj`
--
ALTER TABLE `obj`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `oferta`
--
ALTER TABLE `oferta`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `onas`
--
ALTER TABLE `onas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `opis`
--
ALTER TABLE `opis`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `preloader`
--
ALTER TABLE `preloader`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `privacy`
--
ALTER TABLE `privacy`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `promo`
--
ALTER TABLE `promo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `rcon`
--
ALTER TABLE `rcon`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `rules`
--
ALTER TABLE `rules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `serverversion`
--
ALTER TABLE `serverversion`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `shopsettings`
--
ALTER TABLE `shopsettings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `show`
--
ALTER TABLE `show`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `snow`
--
ALTER TABLE `snow`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `static`
--
ALTER TABLE `static`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `stats`
--
ALTER TABLE `stats`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT для таблицы `unitpay`
--
ALTER TABLE `unitpay`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `c_fk_payments_donate_id` FOREIGN KEY (`donate_id`) REFERENCES `donate` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
