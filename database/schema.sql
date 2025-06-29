-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 19, 2013 at 11:22 PM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `php_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `city` text NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `city`, `created_at`) VALUES
(1, 'Andrej', 'andrej@mail.test', 'Glasgow', '2013-09-19 22:20:19'),
(2, 'Juraj', 'juraj@mail.test', 'Praha', '2013-09-19 22:20:34'),
(3, 'Jožko', 'jozko@mail.test', 'Bratislava', '2013-09-19 22:21:04'),
(4, 'Peter', 'peter@mail.test', 'Brno', '2013-09-19 22:21:17'),
(5, 'Jon', 'jon@mail.test', 'New York', '2013-09-19 22:21:41');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

ALTER TABLE users MODIFY email VARCHAR(255) NOT NULL;
ALTER TABLE users ADD UNIQUE INDEX idx_unique_email (email);
ALTER TABLE users ADD phone_number VARCHAR(20);

ALTER TABLE users ENGINE=InnoDB;

ALTER TABLE users MODIFY city VARCHAR(255) NOT NULL;
-- cutting a corner for simplicity here, maybe the FULLTEXT index is better for contains queries
-- but a bit more complicated for set up, also cities search is usually okay to not be contains query IMO
ALTER TABLE users ADD INDEX idx_city(city);
