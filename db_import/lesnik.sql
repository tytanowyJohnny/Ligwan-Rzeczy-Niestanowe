-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 20 Lip 2023, 18:24
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `lesnik`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `devices`
--

CREATE TABLE `devices` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `DA` tinyint(1) DEFAULT NULL,
  `DG` tinyint(1) DEFAULT NULL,
  `DH` tinyint(1) DEFAULT NULL,
  `DL` tinyint(1) DEFAULT NULL,
  `BZ` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `devices`
--

INSERT INTO `devices` (`id`, `name`, `DA`, `DG`, `DH`, `DL`, `BZ`) VALUES
(1, 'Łóżko/leżanka', 0, 0, 1, 1, 0),
(2, 'Stelaż', 0, 0, 1, 0, 0),
(3, 'Szafka nocna', 0, 0, 1, 0, 0),
(4, 'Lampka nocna', 0, 0, 1, 1, 0),
(5, 'Kanapa rozkładana', 0, 0, 1, 0, 0),
(6, 'Fotel', 1, 0, 1, 1, 1),
(7, 'Stolik', 1, 1, 1, 1, 1),
(8, 'Komoda', 0, 0, 1, 1, 0),
(9, 'Szafa', 0, 1, 1, 1, 1),
(10, 'Wieszak pokój', 0, 0, 1, 1, 1),
(11, 'Wieszak łazienka', 0, 0, 1, 1, 1),
(12, 'Telefon', 1, 1, 1, 1, 1),
(13, 'Telewizor', 0, 0, 1, 0, 0),
(14, 'Radio', 0, 1, 1, 1, 0),
(15, 'Pilot', 0, 0, 1, 1, 0),
(16, 'Czajnik bezprzewodowy', 1, 1, 1, 1, 1),
(17, 'Krzesło', 1, 1, 1, 1, 1),
(18, 'Półka', 0, 1, 1, 1, 1),
(19, 'Kaloryfer/y', 0, 1, 1, 1, 1),
(20, 'Lampa sufitowa pokój/gabinet/biuro', 1, 1, 1, 1, 1),
(21, 'Lampa sufitowa łazienka', 1, 1, 1, 1, 1),
(22, 'Kinkiet pokój/gabinet', 1, 0, 1, 1, 1),
(23, 'Kinkiet łazienka', 1, 1, 1, 1, 1),
(24, 'Lampa sufitowa przedpokój', 0, 0, 1, 0, 0),
(25, 'Gniazdko', 1, 1, 1, 1, 1),
(26, 'Gniazdko TV', 0, 0, 1, 0, 0),
(27, 'Gniazdko telefon', 1, 1, 1, 1, 1),
(28, 'Gniazdko internet', 1, 1, 1, 1, 1),
(29, 'Wyłącznik', 1, 1, 1, 1, 1),
(30, 'Ściana', 1, 1, 1, 1, 1),
(31, 'Sufit', 1, 1, 1, 1, 1),
(32, 'Sufit w łazience', 1, 1, 1, 1, 1),
(33, 'Wykładzina', 1, 0, 1, 1, 1),
(34, 'Parkiet', 0, 1, 1, 1, 0),
(35, 'Panele podłogowe', 0, 0, 1, 0, 0),
(36, 'Listwa przypodłogowa', 1, 0, 1, 0, 1),
(37, 'Umywalka', 1, 1, 1, 1, 1),
(38, 'Bateria umywalkowa', 1, 1, 1, 1, 0),
(39, 'Bateria wannowa', 0, 0, 0, 1, 0),
(40, 'Bateria zlewozmywakowa', 0, 1, 1, 1, 0),
(41, 'Bateria prysznicowa', 0, 0, 1, 1, 0),
(42, 'Wąż prysznicowy', 0, 1, 1, 1, 0),
(43, 'Słuchawka prysznicowa', 0, 1, 1, 1, 0),
(44, 'Rolki kabiny', 0, 0, 1, 0, 0),
(45, 'Drzwi kabiny', 0, 0, 1, 0, 0),
(46, 'Kabina', 0, 0, 1, 0, 0),
(47, 'Brodzik', 0, 0, 1, 0, 0),
(48, 'Wnna', 0, 0, 0, 1, 0),
(49, 'Uchwyt słuchawki', 0, 1, 1, 1, 0),
(50, 'Deska sedes', 0, 1, 1, 1, 0),
(51, 'Spłuczka', 0, 1, 1, 1, 0),
(52, 'Sedes', 0, 1, 1, 1, 0),
(53, 'Drzwi wejściowe', 1, 1, 1, 1, 1),
(54, 'Drzwi wewnętrzne', 0, 0, 1, 0, 0),
(55, 'Drzwi łazienki', 0, 1, 1, 0, 0),
(56, 'Zawiasy', 1, 1, 1, 1, 1),
(57, 'Zamek', 1, 1, 1, 1, 1),
(58, 'Klamka/i drzwi', 1, 1, 1, 1, 1),
(59, 'Okno', 1, 1, 1, 1, 1),
(60, 'Klamka/i okna', 1, 1, 1, 1, 1),
(61, 'Silikon kabina', 0, 0, 1, 0, 0),
(62, 'Silikon umywalka', 1, 1, 1, 1, 0),
(63, 'Silikon toaleta', 1, 1, 1, 1, 0),
(64, 'Kratka wentylacyjna', 1, 1, 1, 1, 0),
(65, 'Drzwi szafy', 1, 1, 1, 1, 1),
(66, 'Drzwi szafki', 1, 1, 1, 1, 1),
(67, 'Szuflada komody', 0, 0, 1, 0, 0),
(68, 'Drzwi komody', 0, 0, 1, 0, 0),
(69, 'Lustro', 1, 1, 1, 1, 0),
(70, 'Lampka lustra', 0, 0, 1, 0, 0),
(71, 'Suszarka do włosów', 0, 0, 1, 1, 0),
(72, 'Grzejnik olejowy', 0, 0, 1, 1, 0),
(73, 'Panel wezgłowie', 0, 0, 1, 0, 0),
(74, 'Panel załóżkowy', 0, 0, 1, 0, 0),
(75, 'Panel odbojowy', 0, 0, 1, 0, 0),
(76, 'Wentylator', 0, 1, 1, 1, 0),
(77, 'Wentylator łazienkowy', 0, 1, 1, 1, 0),
(78, 'Chodnik', 0, 0, 1, 0, 0),
(79, 'Kosz na śmieci', 1, 1, 1, 1, 1),
(80, 'Karnisz', 0, 1, 1, 1, 0),
(81, 'Roleta', 0, 1, 1, 1, 0),
(82, 'Lodówka', 0, 1, 1, 1, 0),
(83, 'Zmywarka', 0, 1, 1, 0, 0),
(84, 'Internet', 1, 1, 1, 1, 1),
(85, 'Internet - antena', 0, 0, 1, 1, 0),
(86, 'Wersalka', 0, 0, 1, 1, 0),
(87, 'Uchwyt na papier', 0, 1, 1, 1, 0),
(88, 'Uchwyt na ręcznik', 0, 0, 1, 0, 0),
(89, 'Samozamykacz', 0, 1, 1, 1, 0),
(90, 'Regał/y', 0, 1, 1, 1, 0),
(91, 'Szyldy klamek', 1, 1, 1, 1, 1),
(92, 'Komputer', 1, 1, 1, 1, 1),
(93, 'Monitor', 1, 1, 1, 1, 1),
(94, 'Drukarka', 1, 1, 1, 1, 1),
(95, 'Stand interaktywny', 0, 0, 1, 0, 0),
(96, 'POS', 0, 0, 0, 1, 0),
(97, 'Klawiatura', 1, 1, 1, 1, 1),
(98, 'Mysz', 1, 1, 1, 1, 1),
(99, 'Kabel antenowy', 0, 0, 1, 0, 0),
(100, 'Kabel zasilający', 1, 1, 1, 1, 1),
(101, 'Kanbel inny', 1, 1, 1, 1, 1),
(102, 'Lampa świetlówka długa', 0, 1, 1, 1, 1),
(103, 'Lampa świetlówka krótka', 0, 1, 0, 1, 0),
(104, 'Zlew', 0, 1, 1, 1, 0),
(105, 'Butla CO2', 0, 0, 0, 1, 0),
(106, 'Saturator', 0, 0, 0, 1, 0),
(107, 'Rower treningowy', 0, 0, 0, 1, 0),
(108, 'Orbitrek', 0, 0, 0, 1, 0),
(109, 'Bieżnia', 0, 0, 0, 1, 0),
(110, 'Rolety', 0, 0, 1, 1, 0),
(111, 'Żaluzje', 0, 1, 1, 1, 1),
(112, 'Aquavibron - węże', 0, 0, 0, 1, 0),
(113, 'Aquavibron - głowica', 0, 0, 0, 1, 0),
(114, 'Filtry inhalatorów', 0, 0, 0, 1, 0),
(115, 'Filtry sterylizatorów', 0, 1, 0, 1, 0),
(116, 'Wózek/i kelnerski/e', 0, 1, 0, 0, 0),
(117, 'Wózek/i transportowy/e', 1, 1, 1, 1, 0),
(118, 'Stół', 0, 1, 0, 0, 0),
(119, 'Biurko', 1, 1, 1, 1, 1),
(120, 'Noże', 0, 1, 0, 0, 0),
(121, 'Kamera/y', 1, 1, 1, 1, 0),
(122, 'Obieraczka do ziemniaków', 0, 1, 0, 0, 0),
(123, 'Krajalnica', 0, 1, 0, 0, 0),
(124, 'Krajalnica - noże', 0, 1, 0, 0, 0),
(125, 'Krajalnica - sitko', 0, 1, 0, 0, 0),
(126, 'Waga', 0, 1, 1, 1, 0),
(127, 'Parawan', 0, 0, 0, 1, 0),
(128, 'Fotel/e relaksacyjny/e', 0, 0, 0, 1, 0),
(129, 'Stół do masażu', 0, 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lokalizacje`
--

CREATE TABLE `lokalizacje` (
  `id` int(11) NOT NULL,
  `dzial` varchar(40) NOT NULL,
  `dzial_code` varchar(8) NOT NULL,
  `poziom` varchar(40) NOT NULL,
  `pomieszczenie` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `lokalizacje`
--

INSERT INTO `lokalizacje` (`id`, `dzial`, `dzial_code`, `poziom`, `pomieszczenie`) VALUES
(185, 'Hotelowy', 'DH', 'LZ', 'Apt. 1'),
(186, 'Hotelowy', 'DH', 'LZ', 'Apt. 2'),
(187, 'Hotelowy', 'DH', 'LZ', 'Apt. 3'),
(188, 'Hotelowy', 'DH', 'LZ', 'Apt. 4'),
(189, 'Hotelowy', 'DH', 'LZ', 'Apt. 5'),
(190, 'Hotelowy', 'DH', 'LZ', 'Apt. 6'),
(191, 'Hotelowy', 'DH', 'LZ', 'Pralnia'),
(192, 'Hotelowy', 'DH', 'LZ', 'Narciarnia'),
(193, 'Hotelowy', 'DH', 'LZ', 'Magazyn I'),
(194, 'Hotelowy', 'DH', 'LZ', 'Magazyn 2'),
(195, 'Hotelowy', 'DH', 'I piętro', 'P. 101'),
(196, 'Hotelowy', 'DH', 'I piętro', 'P. 102'),
(197, 'Hotelowy', 'DH', 'I piętro', 'P. 103'),
(198, 'Hotelowy', 'DH', 'I piętro', 'P. 104'),
(199, 'Hotelowy', 'DH', 'I piętro', 'P. 105'),
(200, 'Hotelowy', 'DH', 'I piętro', 'P. 106'),
(201, 'Hotelowy', 'DH', 'I piętro', 'P. 107'),
(202, 'Hotelowy', 'DH', 'I piętro', 'P. 108'),
(203, 'Hotelowy', 'DH', 'I piętro', 'P. 109'),
(204, 'Hotelowy', 'DH', 'I piętro', 'P. 110'),
(205, 'Hotelowy', 'DH', 'I piętro', 'P. 111'),
(206, 'Hotelowy', 'DH', 'I piętro', 'P. 112'),
(207, 'Hotelowy', 'DH', 'I piętro', 'P. 113'),
(208, 'Hotelowy', 'DH', 'I piętro', 'P. 114'),
(209, 'Hotelowy', 'DH', 'I piętro', 'P. 115'),
(210, 'Hotelowy', 'DH', 'I piętro', 'P. 116'),
(211, 'Hotelowy', 'DH', 'I piętro', 'P. 117'),
(212, 'Hotelowy', 'DH', 'I piętro', 'P. 118'),
(213, 'Hotelowy', 'DH', 'I piętro', 'P. 119'),
(214, 'Hotelowy', 'DH', 'I piętro', 'P. 120'),
(215, 'Hotelowy', 'DH', 'I piętro', 'P. 121'),
(216, 'Hotelowy', 'DH', 'I piętro', 'P. 122'),
(217, 'Hotelowy', 'DH', 'I piętro', 'P. 123'),
(218, 'Hotelowy', 'DH', 'I piętro', 'P. 124'),
(219, 'Hotelowy', 'DH', 'I piętro', 'P. 125'),
(220, 'Hotelowy', 'DH', 'I piętro', 'P. 126'),
(221, 'Hotelowy', 'DH', 'I piętro', 'P. 127'),
(222, 'Hotelowy', 'DH', 'I piętro', 'P. 128'),
(223, 'Hotelowy', 'DH', 'I piętro', 'P. 129'),
(224, 'Hotelowy', 'DH', 'I piętro', 'P. 130'),
(225, 'Hotelowy', 'DH', 'I piętro', 'Korytarz'),
(226, 'Hotelowy', 'DH', 'I piętro', 'Klatka ewak.'),
(227, 'Hotelowy', 'DH', 'I piętro', 'Hall'),
(228, 'Hotelowy', 'DH', 'II piętro', 'P. 201'),
(229, 'Hotelowy', 'DH', 'II piętro', 'p. 202'),
(230, 'Hotelowy', 'DH', 'II piętro', 'P. 203'),
(231, 'Hotelowy', 'DH', 'II piętro', 'P. 204'),
(232, 'Hotelowy', 'DH', 'II piętro', 'P. 205'),
(233, 'Hotelowy', 'DH', 'II piętro', 'P. 206'),
(234, 'Hotelowy', 'DH', 'II piętro', 'P. 207'),
(235, 'Hotelowy', 'DH', 'II piętro', 'P. 208'),
(236, 'Hotelowy', 'DH', 'II piętro', 'P. 209'),
(237, 'Hotelowy', 'DH', 'II piętro', 'P. 210'),
(238, 'Hotelowy', 'DH', 'II piętro', 'P. 211'),
(239, 'Hotelowy', 'DH', 'II piętro', 'P. 212'),
(240, 'Hotelowy', 'DH', 'II piętro', 'P. 213'),
(241, 'Hotelowy', 'DH', 'II piętro', 'P. 214'),
(242, 'Hotelowy', 'DH', 'II piętro', 'P. 215'),
(243, 'Hotelowy', 'DH', 'II piętro', 'P. 216'),
(244, 'Hotelowy', 'DH', 'II piętro', 'P. 217'),
(245, 'Hotelowy', 'DH', 'II piętro', 'P. 218'),
(246, 'Hotelowy', 'DH', 'II piętro', 'P. 219'),
(247, 'Hotelowy', 'DH', 'II piętro', 'P. 220'),
(248, 'Hotelowy', 'DH', 'II piętro', 'P. 221'),
(249, 'Hotelowy', 'DH', 'II piętro', 'P. 222'),
(250, 'Hotelowy', 'DH', 'II piętro', 'P. 223'),
(251, 'Hotelowy', 'DH', 'II piętro', 'P. 224'),
(252, 'Hotelowy', 'DH', 'II piętro', 'P. 225'),
(253, 'Hotelowy', 'DH', 'II piętro', 'P. 226'),
(254, 'Hotelowy', 'DH', 'II piętro', 'P. 227'),
(255, 'Hotelowy', 'DH', 'II piętro', 'P. 228'),
(256, 'Hotelowy', 'DH', 'II piętro', 'P. 229'),
(257, 'Hotelowy', 'DH', 'II piętro', 'P. 230'),
(258, 'Hotelowy', 'DH', 'II piętro', 'Korytarz'),
(259, 'Hotelowy', 'DH', 'II piętro', 'Klatka ewak.'),
(260, 'Hotelowy', 'DH', 'II piętro', 'Sala Rekreacyjna'),
(261, 'Hotelowy', 'DH', 'II piętro', 'Hall'),
(262, 'Hotelowy', 'DH', 'III piętro', 'P. 301'),
(263, 'Hotelowy', 'DH', 'III piętro', 'P. 302'),
(264, 'Hotelowy', 'DH', 'III piętro', 'P. 303'),
(265, 'Hotelowy', 'DH', 'III piętro', 'P. 304'),
(266, 'Hotelowy', 'DH', 'III piętro', 'P. 305'),
(267, 'Hotelowy', 'DH', 'III piętro', 'P. 306'),
(268, 'Hotelowy', 'DH', 'III piętro', 'P. 307'),
(269, 'Hotelowy', 'DH', 'III piętro', 'P. 308'),
(270, 'Hotelowy', 'DH', 'III piętro', 'P. 309'),
(271, 'Hotelowy', 'DH', 'III piętro', 'P. 310'),
(272, 'Hotelowy', 'DH', 'III piętro', 'P. 311'),
(273, 'Hotelowy', 'DH', 'III piętro', 'P. 312'),
(274, 'Hotelowy', 'DH', 'III piętro', 'P. 313'),
(275, 'Hotelowy', 'DH', 'III piętro', 'P. 314'),
(276, 'Hotelowy', 'DH', 'III piętro', 'P. 315'),
(277, 'Hotelowy', 'DH', 'III piętro', 'P. 316'),
(278, 'Hotelowy', 'DH', 'III piętro', 'P. 317'),
(279, 'Hotelowy', 'DH', 'III piętro', 'P. 318'),
(280, 'Hotelowy', 'DH', 'III piętro', 'P. 319'),
(281, 'Hotelowy', 'DH', 'III piętro', 'P. 320'),
(282, 'Hotelowy', 'DH', 'III piętro', 'P. 321'),
(283, 'Hotelowy', 'DH', 'III piętro', 'P. 322'),
(284, 'Hotelowy', 'DH', 'III piętro', 'P. 323'),
(285, 'Hotelowy', 'DH', 'III piętro', 'P. 324'),
(286, 'Hotelowy', 'DH', 'III piętro', 'P. 325'),
(287, 'Hotelowy', 'DH', 'III piętro', 'P. 326'),
(288, 'Hotelowy', 'DH', 'III piętro', 'P. 327'),
(289, 'Hotelowy', 'DH', 'III piętro', 'P. 328'),
(290, 'Hotelowy', 'DH', 'III piętro', 'P. 329'),
(291, 'Hotelowy', 'DH', 'III piętro', 'P. 330'),
(292, 'Hotelowy', 'DH', 'III piętro', 'Korytarz'),
(293, 'Hotelowy', 'DH', 'III piętro', 'Sala Telewizyjna'),
(294, 'Hotelowy', 'DH', 'III piętro', 'Klatka ewak.'),
(295, 'Hotelowy', 'DH', 'III piętro', 'Hall'),
(296, 'Hotelowy', 'DH', 'IV piętro', 'P. 401'),
(297, 'Hotelowy', 'DH', 'IV piętro', 'P. 402'),
(298, 'Hotelowy', 'DH', 'IV piętro', 'P. 403'),
(299, 'Hotelowy', 'DH', 'IV piętro', 'P. 404'),
(300, 'Hotelowy', 'DH', 'IV piętro', 'P. 405'),
(301, 'Hotelowy', 'DH', 'IV piętro', 'P. 406'),
(302, 'Hotelowy', 'DH', 'IV piętro', 'P. 407'),
(303, 'Hotelowy', 'DH', 'IV piętro', 'P. 408'),
(304, 'Hotelowy', 'DH', 'IV piętro', 'P. 409'),
(305, 'Hotelowy', 'DH', 'IV piętro', 'P. 410'),
(306, 'Hotelowy', 'DH', 'IV piętro', 'P. 411'),
(307, 'Hotelowy', 'DH', 'IV piętro', 'P. 412'),
(308, 'Hotelowy', 'DH', 'IV piętro', 'P. 413'),
(309, 'Hotelowy', 'DH', 'IV piętro', 'P. 414'),
(310, 'Hotelowy', 'DH', 'IV piętro', 'P. 415'),
(311, 'Hotelowy', 'DH', 'IV piętro', 'P. 416'),
(312, 'Hotelowy', 'DH', 'IV piętro', 'P. 417'),
(313, 'Hotelowy', 'DH', 'IV piętro', 'P. 418'),
(314, 'Hotelowy', 'DH', 'IV piętro', 'P. 419'),
(315, 'Hotelowy', 'DH', 'IV piętro', 'P. 420'),
(316, 'Hotelowy', 'DH', 'IV piętro', 'P. 422'),
(317, 'Hotelowy', 'DH', 'IV piętro', 'P. 423'),
(318, 'Hotelowy', 'DH', 'IV piętro', 'P. 424'),
(319, 'Hotelowy', 'DH', 'IV piętro', 'P. 425'),
(320, 'Hotelowy', 'DH', 'IV piętro', 'P. 426'),
(321, 'Hotelowy', 'DH', 'IV piętro', 'P. 427'),
(322, 'Hotelowy', 'DH', 'IV piętro', 'P. 428'),
(323, 'Hotelowy', 'DH', 'IV piętro', 'P. 429'),
(324, 'Hotelowy', 'DH', 'IV piętro', 'Pralnia'),
(325, 'Hotelowy', 'DH', 'IV piętro', 'Pomieszcz. Mycia Maszyn'),
(326, 'Hotelowy', 'DH', 'IV piętro', 'Magazyn Lodówek'),
(327, 'Hotelowy', 'DH', 'IV piętro', 'telewizja/klatka'),
(328, 'Hotelowy', 'DH', 'IV piętro', 'Korytarzyk'),
(329, 'Hotelowy', 'DH', 'IV piętro', 'Korytarz'),
(330, 'Hotelowy', 'DH', 'IV piętro', 'Sala Telewizyjna'),
(331, 'Hotelowy', 'DH', 'IV piętro', 'Klatka ewak.'),
(332, 'Hotelowy', 'DH', 'IV piętro', 'Hall'),
(333, 'Hotelowy', 'DH', 'PG II', 'P. 231'),
(334, 'Hotelowy', 'DH', 'PG II', 'P. 232'),
(335, 'Hotelowy', 'DH', 'PG II', 'P. 233'),
(336, 'Hotelowy', 'DH', 'PG II', 'P. 234'),
(337, 'Hotelowy', 'DH', 'PG II', 'P. 235'),
(338, 'Hotelowy', 'DH', 'PG II', 'P. 236'),
(339, 'Hotelowy', 'DH', 'PG II', 'P. 237'),
(340, 'Hotelowy', 'DH', 'PG II', 'P. 238'),
(341, 'Hotelowy', 'DH', 'PG II', 'P. 239'),
(342, 'Hotelowy', 'DH', 'PG II', 'P. 240'),
(343, 'Hotelowy', 'DH', 'PG II', 'P. 241'),
(344, 'Hotelowy', 'DH', 'PG II', 'P. 242'),
(345, 'Hotelowy', 'DH', 'PG II', 'Korytarz'),
(346, 'Hotelowy', 'DH', 'PG II', 'Schowek'),
(347, 'Hotelowy', 'DH', 'PG II', 'Klatka Schodowa PG'),
(348, 'Hotelowy', 'DH', 'PG II', 'Klatka schodowa Ż'),
(349, 'Hotelowy', 'DH', 'PG 0', 'Sala Wykładowa'),
(350, 'Hotelowy', 'DH', 'PG 1', 'Magazyn Pośc. Czystej'),
(351, 'Hotelowy', 'DH', 'PG 2', 'Magazyn Pość. Brudnej'),
(352, 'Hotelowy', 'DH', 'PG 3', 'Korytarzyk Mag.Pościeli'),
(353, 'Hotelowy', 'DH', 'PG 4', 'WC służbowe'),
(354, 'Hotelowy', 'DH', 'PG 5', 'Magazyn Podręczny'),
(355, 'Hotelowy', 'DH', 'PG 6', 'Socjalny Pokojowych'),
(356, 'Hotelowy', 'DH', 'PG 7', 'Szatnia Recepcji'),
(357, 'Hotelowy', 'DH', 'PG 8', 'Korytarzyk Socj.'),
(358, 'Hotelowy', 'DH', 'PG 9', 'Toalety Publiczne'),
(359, 'Hotelowy', 'DH', 'PG 10', 'Biuro Kier. Administracji'),
(360, 'Hotelowy', 'DH', 'PG 11', 'Pom. Za Biurem'),
(361, 'Hotelowy', 'DH', 'PG 12', 'Korytarz'),
(362, 'Hotelowy', 'DH', 'PG 13', 'Hall'),
(363, 'Hotelowy', 'DH', 'PG 14', 'Wiatrołap'),
(364, 'Hotelowy', 'DH', 'PG 15', '@ cafe'),
(365, 'Hotelowy', 'DH', 'PG 16', 'Łącznik poz. 0'),
(366, 'Hotelowy', 'DH', 'PG 17', 'Biuro Kier. Dz. Hotelowego'),
(367, 'Hotelowy', 'DH', 'PG 18', 'Księgowość'),
(368, 'Hotelowy', 'BZ', 'PG 19', 'Biuro Prezesa Zarządu'),
(369, 'Hotelowy', 'DH', 'PG 20', 'Sekretariat'),
(370, 'Hotelowy', 'DH', 'PG 21', 'Recepcja'),
(371, 'Hotelowy', 'DH', 'PG 22', 'Zaplecze Recepcji'),
(372, 'Hotelowy', 'DH', 'PG 23', 'Magazyn Recepcji'),
(373, 'Hotelowy', 'DH', 'PG 24', 'Serwerownia'),
(374, 'Hotelowy', 'DH', 'PG 25', 'Rozdzielnia Główna'),
(375, 'Hotelowy', 'DH', 'PG 26', 'Korytarz do Rozdzielni'),
(376, 'Hotelowy', 'DH', 'PG 27', 'Klatka schodowa Ż'),
(377, 'Hotelowy', 'DH', 'PG 28', 'Klatka schodowa PG'),
(378, 'Hotelowy', 'DH', 'PG 29', 'Łącznik poz. 1'),
(379, 'Hotelowy', 'DH', '-1', 'Korytarz klatka -1'),
(380, 'Hotelowy', 'DH', '0', 'Kawiarnia'),
(381, 'Hotelowy', 'DH', '0', 'Magazynek Kawiarni.Kotł.'),
(382, 'Hotelowy', 'DH', '0', 'Magazynek Kawiarni'),
(383, 'Hotelowy', 'DH', '0', 'Magazyn Śr. Czystości'),
(384, 'Hotelowy', 'DH', '0', 'Korytarz Mag.Śr.Czyst+Wy'),
(385, 'Gastronomia', 'DG', '-', 'Jadalnia'),
(386, 'Gastronomia', 'DG', '-', 'Schody na Jadalnię'),
(387, 'Gastronomia', 'DG', '-', 'Korytarz'),
(388, 'Gastronomia', 'DG', '-', 'Klatka schodowa PG'),
(389, 'Gastronomia', 'DG', '-', 'Klatka schodowa Ż'),
(390, 'Gastronomia', 'DG', '-', 'Biuro Kier. Gastronomii'),
(391, 'Gastronomia', 'DG', '-', 'Kuchnia i magazyny'),
(392, 'Gastronomia', 'DG', '-', 'Rozdzielnia kelnerska'),
(393, 'Gastronomia', 'DG', '-', 'Zmywalnia'),
(394, 'Gastronomia', 'DG', '-', 'Szatnia'),
(395, 'Gastronomia', 'DG', '-', 'Łazienka'),
(396, 'Gastronomia', 'DG', '-', 'WC'),
(397, 'Gastronomia', 'DG', '-', 'Zlewki'),
(398, 'Lecznictwo', 'DL', '-', 'Korytarz główny'),
(399, 'Lecznictwo', 'DL', '-', 'Gabinet 1/2'),
(400, 'Lecznictwo', 'DL', '-', 'Gabinet 3'),
(401, 'Lecznictwo', 'DL', '-', 'Gabinet 4'),
(402, 'Lecznictwo', 'DL', '-', 'Gabinet 5'),
(403, 'Lecznictwo', 'DL', '-', 'Gabinet 6'),
(404, 'Lecznictwo', 'DL', '-', 'Gabinet 7'),
(405, 'Lecznictwo', 'DL', '-', 'Gabinet 8'),
(406, 'Lecznictwo', 'DL', '-', 'Gabinet 9'),
(407, 'Lecznictwo', 'DL', '-', 'Gabinet 10'),
(408, 'Lecznictwo', 'DL', '-', 'Gabinet 11'),
(409, 'Lecznictwo', 'DL', '-', 'Gabinet 12'),
(410, 'Lecznictwo', 'DL', '-', 'Gabinet 14'),
(411, 'Lecznictwo', 'DL', '-', 'Gabinet 15'),
(412, 'Lecznictwo', 'DL', '-', 'Szatnia Pielęgn. z WC'),
(413, 'Lecznictwo', 'DL', '-', 'Wirówki'),
(414, 'Lecznictwo', 'DL', '-', 'Masaż podwodny'),
(415, 'Lecznictwo', 'DL', '-', 'Bicze szkockie'),
(416, 'Lecznictwo', 'DL', '-', 'Korytarz Biczy Szk.'),
(417, 'Lecznictwo', 'DL', '-', 'Toaleta Publiczna'),
(418, 'Lecznictwo', 'DL', '-', 'Toalety dla personelu'),
(419, 'Lecznictwo', 'DL', '-', 'Kąpiele Borowinowe'),
(420, 'Lecznictwo', 'DL', '-', 'Krioterapia'),
(421, 'Lecznictwo', 'DL', '-', 'Kriokomora'),
(422, 'Lecznictwo', 'DL', '-', 'Fizykoterapia - Rozruch'),
(423, 'Lecznictwo', 'DL', '-', 'Sauna'),
(424, 'Lecznictwo', 'DL', '-', 'Deszczownica'),
(425, 'Lecznictwo', 'DL', '-', 'Wirówka Kończyn Dolnych'),
(426, 'Lecznictwo', 'DL', '-', 'Korytarz borowina'),
(427, 'Lecznictwo', 'DL', '-', 'Korytarz Hydro'),
(428, 'Lecznictwo', 'DL', '-', 'Wanna 1 kąp. solankowa'),
(429, 'Lecznictwo', 'DL', '-', 'Wanna 2 kąp. Solankowa'),
(430, 'Lecznictwo', 'DL', '-', 'Wanna 3 kąp. Solankowa'),
(431, 'Lecznictwo', 'DL', '-', 'Wanna 4 kąp. Solankowa'),
(432, 'Lecznictwo', 'DL', '-', 'Wanna 5 kąp. Solankowa'),
(433, 'Lecznictwo', 'DL', '-', 'Magazyn Sur. Natur.'),
(434, 'Lecznictwo', 'DL', '-', 'Korytarzyk Magazynu'),
(435, 'Lecznictwo', 'DL', '-', 'Socjalny'),
(436, 'Lecznictwo', 'DL', '-', 'Szatnia'),
(437, 'Lecznictwo', 'DL', '-', 'Toaleta niepełnospr.'),
(438, 'Lecznictwo', 'DL', '-', 'Składzik za toaletą'),
(439, 'Lecznictwo', 'DL', '-', 'Korytarz'),
(440, 'Lecznictwo', 'DL', '-', 'Fizykoterapia'),
(441, 'Lecznictwo', 'DL', '-', 'Korytarz fizykoterapii'),
(442, 'Lecznictwo', 'DL', '-', 'Fizykoterapia Szatnia z WC'),
(443, 'Lecznictwo', 'DL', '-', 'Sala Rehabilitacyjna I'),
(444, 'Lecznictwo', 'DL', '-', 'Magazyn Odpadów Med.'),
(445, 'Lecznictwo', 'DL', '-', 'Sala Rehabilitacyjna II'),
(446, 'Magazyn Żywnosci', '', '-', 'Magazyny jarzyn'),
(447, 'Magazyn Żywnosci', '', '-', 'Obieralnia'),
(448, 'Magazyn Żywnosci', '', '-', 'Magazyn jaj'),
(449, 'Magazyn Żywnosci', '', '-', 'Magazyn mrożonek'),
(450, 'Magazyn Żywnosci', '', '-', 'Pomieszczenie techniczne'),
(451, 'Magazyn Żywnosci', '', '-', 'Magazyn \"Puszki\"+Napoje'),
(452, 'Magazyn Żywnosci', '', '-', 'Magazyn Prod. Suchych'),
(453, 'Magazyn Żywnosci', '', '-', 'Magazyn porcelany'),
(454, 'Magazyn Żywnosci', '', '-', 'Korytarze'),
(455, 'Magazyn Żywnosci', '', '-', 'WC'),
(456, 'Magazyn Żywnosci', '', '-', 'Biuro'),
(457, 'Magazyn Żywnosci', '', '-', 'Szatnia z łazienką'),
(458, 'Magazyn Żywnosci', '', '-', 'Klatka schodowa'),
(459, 'Kotłownia', '', '-', 'Kotły'),
(460, 'Kotłownia', '', '-', 'Pompy'),
(461, 'Kotłownia', '', '-', 'Zbiorniki'),
(462, 'Kotłownia', '', '-', 'Hydrofory'),
(463, 'Kotłownia', '', '-', 'Hala'),
(464, 'Kotłownia', '', '-', 'Warsztat'),
(465, 'Kotłownia', '', '-', 'Korytarze'),
(466, 'Kotłownia', '', '-', 'WC'),
(467, 'Kotłownia', '', '-', 'Socjalny'),
(468, 'Kotłownia', '', '-', 'Klatka schodowa'),
(469, 'Administracja', '', '-', 'Wentylatorownia 1'),
(470, 'Administracja', '', '-', 'Wentylatorownia 2');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `statusy`
--

CREATE TABLE `statusy` (
  `id` int(11) NOT NULL,
  `label` varchar(40) NOT NULL,
  `value` varchar(40) NOT NULL,
  `active_status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `statusy`
--

INSERT INTO `statusy` (`id`, `label`, `value`, `active_status`) VALUES
(1, 'Nowy', 'new', 1),
(2, 'Przypisany', 'assigned', 1),
(3, 'W trakcie', 'in_progress', 1),
(4, 'Wykonane', 'completed', 1),
(5, 'Zweryfikowane', 'verified', 0),
(6, 'Zamknięte', 'closed', 0),
(7, 'Przekazane / Zwrócone', 'rejected', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `imie` varchar(40) NOT NULL,
  `nazwisko` varchar(40) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(120) NOT NULL,
  `type` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `imie`, `nazwisko`, `username`, `password`, `type`) VALUES
(1, 'Bartosz', 'Kubacki', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_types`
--

CREATE TABLE `user_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(40) NOT NULL,
  `type_label` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `user_types`
--

INSERT INTO `user_types` (`id`, `type_name`, `type_label`) VALUES
(1, 'admin', 'Administrator');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `usterki`
--

CREATE TABLE `usterki` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `usterki`
--

INSERT INTO `usterki` (`id`, `name`) VALUES
(1, 'Spalona/y'),
(2, 'Wyrwane/a/y'),
(3, 'Do regulacji'),
(4, 'Pęknięta/y/e'),
(5, 'Do malowania'),
(6, 'Do wymiany'),
(7, 'Wynieść'),
(8, 'Przenieść'),
(9, 'Cieknie'),
(10, 'Zatkana/y/e'),
(11, 'Ociera/ją'),
(12, 'Skrzypi/ą'),
(13, 'Krzywa/y/e'),
(14, 'Urwana/y/e'),
(15, 'Brak prądu'),
(16, 'Zamontować'),
(17, 'Brak sygnału'),
(18, 'Zepsuta/y/e'),
(19, 'Brak'),
(20, 'Dokręcić'),
(21, 'Nie zamyka się'),
(22, 'Nie grzeje/ą'),
(23, 'Odpowietrzyć'),
(24, 'Uszczelnić'),
(25, 'Naostrzyć'),
(26, 'Parkiet'),
(27, 'Wy/czyścić'),
(28, 'Ułożyć/ustawić'),
(29, 'Przykleić');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zgloszenia`
--

CREATE TABLE `zgloszenia` (
  `id` int(11) NOT NULL,
  `created_by` varchar(40) NOT NULL,
  `czas_wprowadzenie` datetime NOT NULL,
  `status` varchar(40) NOT NULL,
  `dzial` varchar(40) NOT NULL,
  `poziom` varchar(40) NOT NULL,
  `pomieszczenie` varchar(40) NOT NULL,
  `usterka` varchar(40) NOT NULL,
  `device` varchar(40) NOT NULL,
  `device_file` varchar(120) NOT NULL,
  `dzial_zglaszajacy` varchar(40) NOT NULL,
  `wykonawca` varchar(40) NOT NULL,
  `work_image` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `lokalizacje`
--
ALTER TABLE `lokalizacje`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `statusy`
--
ALTER TABLE `statusy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `usterki`
--
ALTER TABLE `usterki`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `zgloszenia`
--
ALTER TABLE `zgloszenia`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT dla tabeli `lokalizacje`
--
ALTER TABLE `lokalizacje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=471;

--
-- AUTO_INCREMENT dla tabeli `statusy`
--
ALTER TABLE `statusy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `user_types`
--
ALTER TABLE `user_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `usterki`
--
ALTER TABLE `usterki`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT dla tabeli `zgloszenia`
--
ALTER TABLE `zgloszenia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
