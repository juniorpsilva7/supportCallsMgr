-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 17-Nov-2016 às 15:36
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `supp`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `calls`
--

CREATE TABLE IF NOT EXISTS `calls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datecall` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `startcall` time DEFAULT NULL,
  `tel_ava` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `typecall` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `contacts` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `company` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `cnpj` varchar(18) CHARACTER SET latin1 DEFAULT NULL,
  `deviceinfo` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `notes` varchar(300) CHARACTER SET latin1 DEFAULT NULL,
  `endcall` time DEFAULT NULL,
  `totalcall` time DEFAULT NULL,
  `later` tinyint(1) DEFAULT NULL COMMENT 'Flag de lembrete se vai abrir case depois',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tickets`
--

CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'id do usuário',
  `opened` int(11) DEFAULT NULL COMMENT 'casos abertos',
  `assigned` int(11) DEFAULT NULL COMMENT 'casos assumidos',
  `closed` int(11) DEFAULT NULL COMMENT 'casos fechados',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID do Usuário',
  `user` varchar(255) NOT NULL COMMENT 'Usuário',
  `user_name` varchar(255) NOT NULL COMMENT 'Nome do usuário',
  `user_password` varchar(255) NOT NULL COMMENT 'Senha',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`user_id`, `user`, `user_name`, `user_password`) VALUES
(1, 'admin', 'admin', '$1$1b0..74.$0f8lLE0fwuFGbcTzyzWcP.');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
