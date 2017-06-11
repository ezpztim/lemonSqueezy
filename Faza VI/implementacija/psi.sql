-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jun 11, 2017 at 04:46 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `psi`
--

-- --------------------------------------------------------

--
-- Table structure for table `oglas`
--

CREATE TABLE `oglas` (
  `id` int(11) NOT NULL,
  `Naziv` varchar(128) COLLATE utf8_bin NOT NULL,
  `Mesto` varchar(30) COLLATE utf8_bin NOT NULL,
  `Ulica` varchar(50) COLLATE utf8_bin NOT NULL,
  `Cena1Dan` double NOT NULL,
  `CenaMesec` double NOT NULL,
  `Kvadratura` int(11) NOT NULL,
  `Tip` varchar(16) COLLATE utf8_bin NOT NULL,
  `BrSoba` double NOT NULL,
  `Namestenost` varchar(12) COLLATE utf8_bin NOT NULL,
  `Grejanje` varchar(12) COLLATE utf8_bin NOT NULL,
  `Ljubimci` varchar(12) COLLATE utf8_bin NOT NULL,
  `KontaktTelefon` varchar(12) COLLATE utf8_bin NOT NULL,
  `DatumObjave` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Opis` mediumtext COLLATE utf8_bin NOT NULL,
  `Podrum` tinyint(1) NOT NULL,
  `Parking` tinyint(1) NOT NULL,
  `Garaza` tinyint(1) NOT NULL,
  `Klima` tinyint(1) NOT NULL,
  `Terasa` tinyint(1) NOT NULL,
  `Kablovska` tinyint(1) NOT NULL,
  `Internet` tinyint(1) NOT NULL,
  `Telefon` tinyint(1) NOT NULL,
  `Lift` tinyint(1) NOT NULL,
  `Bazen` tinyint(1) NOT NULL,
  `Alarm` tinyint(1) NOT NULL,
  `Dvoriste` tinyint(1) NOT NULL,
  `Uizgradnji` tinyint(1) NOT NULL,
  `Novogradnja` tinyint(1) NOT NULL,
  `Status` varchar(12) COLLATE utf8_bin NOT NULL,
  `idKorisnika` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `oglas`
--

INSERT INTO `oglas` (`id`, `Naziv`, `Mesto`, `Ulica`, `Cena1Dan`, `CenaMesec`, `Kvadratura`, `Tip`, `BrSoba`, `Namestenost`, `Grejanje`, `Ljubimci`, `KontaktTelefon`, `DatumObjave`, `Opis`, `Podrum`, `Parking`, `Garaza`, `Klima`, `Terasa`, `Kablovska`, `Internet`, `Telefon`, `Lift`, `Bazen`, `Alarm`, `Dvoriste`, `Uizgradnji`, `Novogradnja`, `Status`, `idKorisnika`) VALUES
(24, 'Stan na Neimaru', 'Beograd', 'Južni Bulevar 26', 2500, 70000, 60, 'Stambeni objekat', 4, 'Nenamešten', 'Etažno', 'Dozvoljeni', '0612345678', '2017-06-11 13:42:40', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0, 0, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'Čeka potvrdu', 23),
(25, 'Kuća u Surčinu', 'Beograd', 'Surčinska', 2000, 50000, 100, 'Stambeni objekat', 4.5, 'Namešten', 'Gas', 'Dozvoljeni', '0624334334', '2017-06-11 14:26:37', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.', 1, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 1, 0, 0, 'Odbijen', 23),
(26, 'Stan u Ruzveltovoj', 'Beograd', 'Ruzveltova 100', 3000, 80000, 50, 'Poslovni objekat', 2.5, 'Nenamešten', 'Centralno', 'Zabranjeni', '0648444333', '2017-06-10 14:25:32', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur...', 0, 1, 0, 1, 1, 0, 1, 0, 1, 0, 0, 0, 0, 1, 'Odobren', 23),
(27, 'Kancelarija u Novom Sadu', 'Novi Sad', 'Novosadska 3', 1500, 30000, 100, 'Poslovni objekat', 3.5, 'Namešten', 'Centralno', 'Zabranjeni', '0682400333', '2017-06-09 14:25:23', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 'Odobren', 23),
(28, 'Plac na Goču', 'Goč', 'Gočska 10', 1000, 20000, 5000, 'Zemljište', 1, 'Nenamešten', 'Centralno', 'Dozvoljeni', '0691951954', '2017-06-09 14:25:06', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Odbijen', 23),
(29, 'Kuća na Banjici', 'Beograd', 'Banjička 10', 5000, 100000, 300, 'Stambeni objekat', 10, 'Namešten', 'Centralno', 'Zabranjeni', '0612345678', '2017-06-11 14:23:33', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 0, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 0, 1, 'Odobren', 22),
(30, 'Stan u Knez Mihajlovoj', 'Beograd', 'Knez Mihajlova 55', 4000, 100000, 200, 'Poslovni objekat', 8, 'Namešten', 'Centralno', 'Zabranjeni', '0624334334', '2017-06-08 14:23:39', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0, 1, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 1, 'Odobren', 22),
(31, 'Garaža u centru Kraljeva', 'Kraljevo', 'Kraljevačka 100', 500, 10000, 25, 'Skladište', 1, 'Nenamešten', 'Centralno', 'Dozvoljeni', '0648444333', '2017-06-05 14:24:08', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 'Odbijen', 22);

-- --------------------------------------------------------

--
-- Table structure for table `popust`
--

CREATE TABLE `popust` (
  `id` int(11) NOT NULL,
  `idOglas` int(11) NOT NULL,
  `Iznos` int(11) NOT NULL,
  `Razlog` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `popust`
--

INSERT INTO `popust` (`id`, `idOglas`, `Iznos`, `Razlog`) VALUES
(10, 25, 20, 'Za studente'),
(11, 28, 10, 'Za one koji su već dolazili'),
(12, 29, 5, 'Za duže periode (više od godinu dana)'),
(13, 31, 10, 'Za penzionere');

-- --------------------------------------------------------

--
-- Table structure for table `prestup`
--

CREATE TABLE `prestup` (
  `id` int(11) NOT NULL,
  `idOglas` int(11) NOT NULL,
  `idKorisnika` int(11) NOT NULL,
  `Razlog` varchar(50) COLLATE utf8_bin NOT NULL,
  `jeVeliki` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `prestup`
--

INSERT INTO `prestup` (`id`, `idOglas`, `idKorisnika`, `Razlog`, `jeVeliki`) VALUES
(7, 31, 22, 'Nepostojeća ulica', 0),
(8, 28, 23, 'Lažan oglas', 1),
(9, 25, 23, 'Objekat nije uknjižen', 1);

-- --------------------------------------------------------

--
-- Table structure for table `slika`
--

CREATE TABLE `slika` (
  `id` int(11) NOT NULL,
  `idOglas` int(11) NOT NULL,
  `Ime` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slika`
--

INSERT INTO `slika` (`id`, `idOglas`, `Ime`) VALUES
(47, 24, '149718856013724593d48d063908.jpg'),
(48, 24, '14971885602981593d48d06a669.jpg'),
(49, 25, '149718899727514593d4a85bd2b0.jpg'),
(50, 26, '14971891737979593d4b35c09a3.jpg'),
(51, 26, '14971891733976593d4b35c7aed.jpg'),
(52, 27, '149718994823716593d4e3c9e41b.jpg'),
(53, 27, '14971899486669593d4e3ca788d.jpg'),
(54, 27, '149718994815810593d4e3cad64e.jpg'),
(55, 27, '14971899486099593d4e3cd08d6.jpg'),
(56, 28, '149719025929257593d4f73084b4.jpg'),
(57, 29, '14971904917952593d505be0ecc.jpg'),
(58, 29, '149719049118953593d505beaef6.jpg'),
(59, 29, '149719049129710593d505bf2bf8.jpg'),
(60, 29, '149719049224111593d505c06e8a.jpg'),
(61, 29, '14971904927228593d505c0d804.jpg'),
(62, 29, '149719049232197593d505c11a6d.jpg'),
(63, 29, '149719049217178593d505c15cd6.jpg'),
(64, 30, '14971907135966593d5139c7f28.jpg'),
(65, 30, '149719071324687593d5139d07e2.jpg'),
(66, 30, '14971907144476593d513a0cb1d.jpg'),
(67, 30, '149719071427141593d513a497d3.jpg'),
(68, 31, '149719091423130593d5202c0417.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `selector` char(12) NOT NULL,
  `token` varchar(64) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `surname` varchar(50) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `password` varchar(60) COLLATE utf8_bin NOT NULL,
  `isadmin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `password`, `isadmin`) VALUES
(21, 'Pera', 'Perić', 'ezpztim@gmail.com', '$2y$10$2f9gZAMbuin9HQmnmcz4xuHRpdPfOfR1Z16Gyx58gj5YtKtphS5pm', 1),
(22, 'Aleksa', 'Funduk', 'aleksa.funduk@gmail.com', '$2y$10$buPNBrwJS6SQRnL5g7BQRuGNJBROKryAa7SGczCn0L9I.a4urnzzG', NULL),
(23, 'Nemanja', 'Šćepanović', 'scepa.rock.ql@gmail.com', '$2y$10$NLt.nrn8RkqdWeI1UnnoguAJM8s0uMdoaydVqp.epOsU/vITyPdKq', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `oglas`
--
ALTER TABLE `oglas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `popust`
--
ALTER TABLE `popust`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prestup`
--
ALTER TABLE `prestup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slika`
--
ALTER TABLE `slika`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `oglas`
--
ALTER TABLE `oglas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `popust`
--
ALTER TABLE `popust`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `prestup`
--
ALTER TABLE `prestup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `slika`
--
ALTER TABLE `slika`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
