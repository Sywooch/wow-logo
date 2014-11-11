-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Ноя 04 2014 г., 11:01
-- Версия сервера: 5.5.39
-- Версия PHP: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `creativelogo`
--

-- --------------------------------------------------------

--
-- Структура таблицы `client_review`
--

CREATE TABLE IF NOT EXISTS `client_review` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `site_link` varchar(255) NOT NULL,
  `logo_url` varchar(64) NOT NULL,
  `client_image_url` varchar(64) NOT NULL,
  `is_published` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `client_review`
--

INSERT INTO `client_review` (`id`, `name`, `position`, `comment`, `site_link`, `logo_url`, `client_image_url`, `is_published`, `created_at`) VALUES
(1, 'Вася Пупкин', 'зам. зав ООО "Электроника"', 'Пацаны ваще ребята.\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id ', 'https://www.google.com.ua/', 'adhZTrhvpC9nqB6aPX7k-Ysni-sH-TS4.jpg', 'lnuYWj3A78-ooGA8Ue6IrVibFPhY4Ifv.jpg', 1, '2014-10-29 10:45:00'),
(2, 'Иван Иванов', 'Основатель блога «Хайзенберг позвонит»', 'Через сутки после того, как я, в меру своих скромных возможностей, сформулировал требования к логотипу, мне прислали несколько вариантов. Это было что-то невероятное: мое неловкое описание превратилось в несколько крепких, уверенных вариантов, за которые в агентстве с меня взяли бы целую кучу денег. ', 'http://siliconrus.com/2013/11/logo-startups/', 'ZqiMjmFqltR1HuGhKN3TFIjnCMwwZUtr.jpg', 'GBdvt-eCpqWB3qGVUl5neomtizymFfjA.jpg', 1, '2014-10-29 10:48:00');

-- --------------------------------------------------------

--
-- Структура таблицы `coupon`
--

CREATE TABLE IF NOT EXISTS `coupon` (
`id` int(10) unsigned NOT NULL,
  `code` varchar(64) NOT NULL,
  `price_drop` decimal(12,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `is_used` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `coupon`
--

INSERT INTO `coupon` (`id`, `code`, `price_drop`, `created_at`, `is_used`) VALUES
(1, 'qqq', '500.00', '2014-10-30 00:15:00', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `option`
--

CREATE TABLE IF NOT EXISTS `option` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `is_published` tinyint(1) unsigned NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `option`
--

INSERT INTO `option` (`id`, `name`, `price`, `is_published`) VALUES
(1, 'ч/б вариант лого', '500.00', 1),
(2, 'Дизайн визитки', '2000.00', 1),
(3, 'Карта цветов', '2000.00', 1),
(4, 'Карта шрифтов', '1000.00', 1),
(5, 'Брендбук', '20000.00', 1),
(6, 'Помощь с названием', '2000.00', 1),
(7, 'Фавикон на сайт', '500.00', 1),
(8, 'Иконка для приложения', '1000.00', 1),
(9, 'Логотип за 24 часа', '1000.00', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

CREATE TABLE IF NOT EXISTS `order` (
`id` int(10) unsigned NOT NULL,
  `status` smallint(6) unsigned NOT NULL DEFAULT '0',
  `composition` smallint(6) unsigned NOT NULL DEFAULT '3',
  `tariff` smallint(6) unsigned NOT NULL,
  `client_email` varchar(128) NOT NULL,
  `skype` varchar(128) DEFAULT NULL,
  `telephone` varchar(128) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT '',
  `site_link` varchar(255) DEFAULT '',
  `description` text,
  `logo_variants` int(10) unsigned NOT NULL DEFAULT '1',
  `hilarity` smallint(5) unsigned NOT NULL DEFAULT '50',
  `modernity` smallint(5) unsigned NOT NULL DEFAULT '50',
  `minimalism` smallint(5) unsigned NOT NULL DEFAULT '50',
  `money_earning` text,
  `who_clients` text,
  `company_strength` text,
  `who_competitors` text,
  `created_at` datetime NOT NULL,
  `price_no_disc` decimal(12,2) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `images_urls` text,
  `files_urls` text,
  `color_scheme` text,
  `coupon_id` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `order`
--

INSERT INTO `order` (`id`, `status`, `composition`, `tariff`, `client_email`, `skype`, `telephone`, `company_name`, `site_link`, `description`, `logo_variants`, `hilarity`, `modernity`, `minimalism`, `money_earning`, `who_clients`, `company_strength`, `who_competitors`, `created_at`, `price_no_disc`, `price`, `images_urls`, `files_urls`, `color_scheme`, `coupon_id`) VALUES
(1, 6, 1, 1, 'qwe@qwe.ru', 'qwead23', '555-3-32-23', 'huihiu', '', '', 1, 67, 20, 40, '', '', '', '', '2014-10-29 13:49:00', '9999.00', '1000.00', NULL, NULL, '', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `order_has_option`
--

CREATE TABLE IF NOT EXISTS `order_has_option` (
  `order_id` int(10) unsigned NOT NULL,
  `option_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `order_has_portfolio`
--

CREATE TABLE IF NOT EXISTS `order_has_portfolio` (
  `order_id` int(10) unsigned NOT NULL,
  `portfolio_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `order_has_user`
--

CREATE TABLE IF NOT EXISTS `order_has_user` (
  `order_id` int(10) unsigned NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `portfolio`
--

CREATE TABLE IF NOT EXISTS `portfolio` (
`id` int(10) unsigned NOT NULL,
  `thumbnail_url` varchar(64) NOT NULL,
  `title` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `images_urls` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `portfolio`
--

INSERT INTO `portfolio` (`id`, `thumbnail_url`, `title`, `created_at`, `images_urls`) VALUES
(1, 'W7Stphw6CN-hABouJd1TB_JFymILGw_w.jpg', 'Первый заказ', '2014-10-29 18:48:00', 'BburZxYwBIgJDCDIvNMPoQsqnKnWRDY7.jpg,Kly2GioBYx87JpqCkVeq3MIIXBSnC3Tz.jpg'),
(2, 'iu_q3WiuWMectc-HFqXbBJXRAIVmq_93.jpg', 'Второе портфолио', '2014-10-29 18:48:00', 'mCcqUaGotknf2NnEzlV1egayV3OeXi3Q.jpg,7qDkwiC4YDktM8qltPfmC4oItQYNBqxV.jpg'),
(3, 'GSqobUzrjvUWs1pA5c8tpREBMVHZEIGd.jpg', 'Третье', '2014-10-29 18:49:00', 'LB5ugPD9ihIvgVU58Hg-LJhD1NzCceKh.jpg,pliF3BjOvshbS3HOYqSIMFS5XfzgancH.jpg'),
(4, 'H5CiaAbUoYD3dxO8zp6cebi0zgHp-P77.jpg', 'Четвертое', '2014-10-29 18:49:00', 'Cc68bwcTHv_oKNv-4haNBpe1yMoHYRjr.jpg,PkeTIgc61h_WLhG53vzCFpx9aF0_5MY5.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `question_answer`
--

CREATE TABLE IF NOT EXISTS `question_answer` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `avatar_url` varchar(64) NOT NULL,
  `is_published` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `question_answer`
--

INSERT INTO `question_answer` (`id`, `name`, `position`, `comment`, `avatar_url`, `is_published`, `created_at`) VALUES
(1, 'Роман Горбачев', 'Директор', '<h3>ЧТО ДЕЛАТЬ, ЕСЛИ МНЕ НЕ ПОНРАВИТСЯ ЛОГОТИП?</h3><p>\r\n	Если вы заказали только один вариант, комплекта из трех правок вполне хватит, чтобы исправить то, что вам не по вкусу. При заказе нескольких вариантов все еще проще — следующие логотипы будут сделаны с учетом ваших пожеланий.Если у вас есть пожелания к логотипу, подробно изложите их на странице заказа, это поможет сэкономить время и деньги.\r\n</p><h3>У МЕНЯ НЕТ ИДЕИ ДЛЯ ЛОГОТИПА, КАК БЫТЬ?</h3><p>Это обычная ситуация. Придумывать символы и знаки — это наша работа, а не ваша. При оформлении заказа вам стоит уделить внимание разделу «понравившиеся логотипы». Поняв, какой стиль вам нравится, дизайнерам будет проще сделать лого в вашем вкусе.</p>', '5D1MmD240TIT1O4Op_Py06BfRcnz7-9O.jpg', 1, '2014-11-04 10:00:04'),
(2, 'Наталья Якименко', 'Клиентский менеджер', '<h3>В ПРОЦЕССЕ РАБОТЫ ЦЕНА НЕ ВЫРАСТЕТ В 10 РАЗ ?</h3><p>\r\n	Нет, такого еще не случалось. Нам не выгодно привлекать клиента низкой ценой, а потом пытаться «раскрутить» его на лишние траты денег. Если бы мы так работали, у нас бы просто перестали заказывать. Мы, также как и вы, заинтересованы в разработке хорошего логотипа с минимальными затратами ресурсов.\r\n</p><h3>В КАКОМ ВИДЕ Я ПОЛУЧУ ЛОГОТИП?</h3><p>\r\n	Все файлы, необходимые для распечатки логотипа в любом размере и другого использования, всегда будут находиться в вашем личном кабинете. Вы сможете скачать их в любой удобный момент.Кроме того, дизайнеры прикинут, как ваш лого будет выглядеть в жизни.\r\n</p>', 'X61gca-pgmUh2GF0ZXC9xDvB2o2InYVJ.png', 1, '2014-11-04 10:58:53');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` smallint(6) NOT NULL DEFAULT '0',
  `status` smallint(6) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'lFAIX3JbOnKAIZZET-MJoynQEyH4T_RG', '$2y$13$FtuELGWebQXDyqA4zU2NOuyo/Bf28CsL2/jiLJC8vPuJfQ2wnJ32W', NULL, 'admin@demo.com', 1, 1, '2014-10-14 12:14:04', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client_review`
--
ALTER TABLE `client_review`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `code_UNIQUE` (`code`);

--
-- Indexes for table `option`
--
ALTER TABLE `option`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_order_coupon1_idx` (`coupon_id`);

--
-- Indexes for table `order_has_option`
--
ALTER TABLE `order_has_option`
 ADD PRIMARY KEY (`order_id`,`option_id`), ADD KEY `fk_order_has_order_options_order_options1_idx` (`option_id`), ADD KEY `fk_order_has_order_options_order1_idx` (`order_id`);

--
-- Indexes for table `order_has_portfolio`
--
ALTER TABLE `order_has_portfolio`
 ADD PRIMARY KEY (`order_id`,`portfolio_id`), ADD KEY `fk_tbl_order_has_tbl_portfolio_tbl_portfolio1_idx` (`portfolio_id`), ADD KEY `fk_tbl_order_has_tbl_portfolio_tbl_order1_idx` (`order_id`);

--
-- Indexes for table `order_has_user`
--
ALTER TABLE `order_has_user`
 ADD PRIMARY KEY (`order_id`,`user_id`), ADD KEY `fk_order_has_user_user1_idx` (`user_id`), ADD KEY `fk_order_has_user_order1_idx` (`order_id`);

--
-- Indexes for table `portfolio`
--
ALTER TABLE `portfolio`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_answer`
--
ALTER TABLE `question_answer`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client_review`
--
ALTER TABLE `client_review`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `option`
--
ALTER TABLE `option`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `portfolio`
--
ALTER TABLE `portfolio`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `question_answer`
--
ALTER TABLE `question_answer`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `order`
--
ALTER TABLE `order`
ADD CONSTRAINT `fk_order_coupon1` FOREIGN KEY (`coupon_id`) REFERENCES `coupon` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `order_has_option`
--
ALTER TABLE `order_has_option`
ADD CONSTRAINT `fk_order_has_order_options_order1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_order_has_order_options_order_options1` FOREIGN KEY (`option_id`) REFERENCES `option` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `order_has_portfolio`
--
ALTER TABLE `order_has_portfolio`
ADD CONSTRAINT `fk_tbl_order_has_tbl_portfolio_tbl_order1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_tbl_order_has_tbl_portfolio_tbl_portfolio1` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `order_has_user`
--
ALTER TABLE `order_has_user`
ADD CONSTRAINT `fk_order_has_user_order1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_order_has_user_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
