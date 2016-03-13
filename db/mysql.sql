DROP DATABASE IF EXISTS projeto_integrador;

CREATE DATABASE projeto_integrador;

USE projeto_integrador;

-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 21/06/2015 às 23:36
-- Versão do servidor: 5.5.43-0ubuntu0.14.04.1
-- Versão do PHP: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `projeto_integrador`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Fazendo dump de dados para tabela `categories`
--

INSERT INTO `categories` (`id`, `description`) VALUES
(1, 'Manutenção Física'),
(2, 'Manutenção Lógica'),
(3, 'Redes'),
(4, 'Otimização do sistema'),
(5, 'Periféricos');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `states_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_cities_states` (`states_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Fazendo dump de dados para tabela `cities`
--

INSERT INTO `cities` (`id`, `name`, `states_id`) VALUES
(1, 'Guarapuava', 16),
(2, 'Londrina', 16),
(3, 'Dracena', 25),
(4, 'São Paulo', 25),
(5, 'Concórdia', 24),
(6, 'Florianópolis', 24);

-- --------------------------------------------------------

--
-- Estrutura para tabela `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `address` varchar(70) NOT NULL,
  `email` varchar(60) DEFAULT NULL,
  `phone` varchar(11) NOT NULL,
  `client_type` char(1) NOT NULL,
  `cities_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_clients_cities` (`cities_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Fazendo dump de dados para tabela `clients`
--

INSERT INTO `clients` (`id`, `name`, `address`, `email`, `phone`, `client_type`, `cities_id`) VALUES
(4, 'Danilo Augusto Pinotti de Mello', 'Rua Marechal Rondon, 60', 'danilopinotti@hotmail.com', '18997096654', 'F', 3),
(14, 'Marieli Rieckel Antoniucci', 'Rua Angelo Dala Vechia', 'mari.antoniucci@gmail.com', '4236241113', 'F', 1),
(15, 'Rafhael Mello Correa', 'Rua Guaíra', 'rafhaelnes@hotmail.com', '4230352828', 'F', 3),
(16, 'Cleiri de Fátima Rickel', 'Rua Pedro Alvares', 'cleirifatima@gmail.com', '4298541236', 'F', 5),
(17, 'Ana Paula Campos', 'Rua Juvelina Cunha', 'anapaula@gmail.com', '4236298541', 'J', 6),
(18, 'Danielle Rieckel Antoniucci', 'Rua XV de Novembro', 'danielle@gmail.com', '4299491379', 'J', 6),
(19, 'João Pedro da Silva', 'Rua XV de outubro', 'joao@gmail.com', '423035698', 'F', 3),
(20, 'Jorge Neto', 'Rua das Laranjeiras', 'jorge@gmail.com', '4298520031', 'F', 5),
(21, 'Roberto Campos', 'Rua Juvelina Cunha', 'robertocampos@gmail.com', '4288456232', 'J', 6),
(22, 'Daniel Oliveira', 'Rua Saldanha Marinho', 'daniel@gmail.com', '4236241598', 'J', 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `genre` char(1) NOT NULL,
  `date_contratation` date NOT NULL,
  `date_exit` date DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  `last_access` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Fazendo dump de dados para tabela `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `phone`, `genre`, `date_contratation`, `date_exit`, `password`, `last_access`) VALUES
(1, 'Pedro da Silva', 'admin@admin.com', '4236243624', 'M', '2012-07-20', '2014-02-14', 'd033e22ae348aeb5660fc2140aec35850c4da997', '2015-06-07 00:00:00'),
(2, 'João Cardoso', 'joao@gmail.com', '1234123', 'M', '2015-06-17', NULL, 'd033e22ae348aeb5660fc2140aec35850c4da997', '0000-00-00 00:00:00'),
(3, 'Maria de Jesus', 'maria@gmail.com', '4236243624', 'F', '2014-09-18', NULL, 'd033e22ae348aeb5660fc2140aec35850c4da997', '0000-00-00 00:00:00'),
(4, 'João Cabral', 'joao@gmail.com', '4236593659', 'M', '2014-09-12', NULL, 'd033e22ae348aeb5660fc2140aec35850c4da997', '0000-00-00 00:00:00'),
(5, 'Paulo Roberto Reis', 'paulo@gmail.com', '4236253625', 'M', '2015-06-08', NULL, 'd033e22ae348aeb5660fc2140aec35850c4da997', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `items_service_order`
--

CREATE TABLE IF NOT EXISTS `items_service_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cost` float DEFAULT NULL,
  `service_orders_id` int(11) NOT NULL,
  `services_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_items_service_order_services` (`services_id`),
  KEY `FK_items_service_order_service_orders` (`service_orders_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Fazendo dump de dados para tabela `items_service_order`
--

INSERT INTO `items_service_order` (`id`, `cost`, `service_orders_id`, `services_id`) VALUES
(7, 50, 9, 1),
(8, 450, 9, 2),
(9, 50, 10, 1),
(10, 50, 13, 1),
(12, 50, 14, 7),
(13, 68, 15, 19),
(14, 65, 16, 9),
(15, 260, 17, 8),
(16, 60, 18, 6),
(17, 45, 19, 10),
(18, 68, 20, 19),
(19, 98, 20, 20),
(20, 50, 20, 1),
(21, 20, 21, 13),
(22, 48, 22, 16),
(23, 260, 23, 8),
(24, 98, 23, 20),
(25, 15, 24, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `juridical_clients`
--

CREATE TABLE IF NOT EXISTS `juridical_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cnpj` char(14) NOT NULL,
  `clients_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_juridical_clients_clients` (`clients_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Fazendo dump de dados para tabela `juridical_clients`
--

INSERT INTO `juridical_clients` (`id`, `cnpj`, `clients_id`) VALUES
(6, '08378718000128', 17),
(7, '17824825000123', 18),
(8, '35355787000199', 21),
(9, '56717685000146', 22);

-- --------------------------------------------------------

--
-- Estrutura para tabela `physical_clients`
--

CREATE TABLE IF NOT EXISTS `physical_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `genre` char(1) DEFAULT NULL,
  `cpf` char(11) NOT NULL,
  `clients_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_physical_clients_clients` (`clients_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Fazendo dump de dados para tabela `physical_clients`
--

INSERT INTO `physical_clients` (`id`, `genre`, `cpf`, `clients_id`) VALUES
(3, 'M', '42532770805', 4),
(9, 'F', '04776840928', 14),
(10, 'M', '09122393951', 15),
(11, 'F', '33476321258', 16),
(12, 'M', '04776843943', 19),
(13, 'M', '22387685210', 20);

-- --------------------------------------------------------

--
-- Estrutura para tabela `priorities`
--

CREATE TABLE IF NOT EXISTS `priorities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Fazendo dump de dados para tabela `priorities`
--

INSERT INTO `priorities` (`id`, `name`) VALUES
(2, 'Alta'),
(3, 'Normal'),
(4, 'Baixa');

-- --------------------------------------------------------

--
-- Estrutura para tabela `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `cost` float NOT NULL,
  `categories_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_services_categories` (`categories_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Fazendo dump de dados para tabela `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `cost`, `categories_id`) VALUES
(1, 'Formatação simples sem ativação', 'Formatação simples sem backup com Windows 7 não ativado', 50, 2),
(2, 'Formatação simples com ativação', 'Formatação simples sem backup com Windows 7 ativado', 450, 2),
(3, 'Limpeza do computador', 'Fazer limpeza externa de um notebook DELL 15''', 15, 1),
(4, 'Troca de placa mãe', 'Colocar placa mãe GigaByte p/ AMD GA-78LMT-USB3', 312, 1),
(5, 'Troca de memória RAM', 'Aumentar memória RAM para Kingston 8gb Ddr3', 254, 1),
(6, 'Formatação com backup', 'Fazer formatação com backup e instalação de windows 8', 60, 2),
(7, 'Remover vírus', 'Fazer remoção de vírus com formatação do notebook', 50, 4),
(8, 'Instalação do pacote Office', 'Instalar pacote Office 365 Home Premium para windows 8.1', 260, 2),
(9, 'Trocar porta USB', 'Colocar entrada USB 3.0 em todas as portas do notebook', 65, 5),
(10, 'Configuração de roteador', 'Configurar roteador e modem wifi', 45, 3),
(11, 'Instalação de modem wifi', 'Instalar e configurar modem wifi', 120, 3),
(12, 'Configuração de rede interna', 'Configurar rede para 9 computadores em empresa', 150, 3),
(13, 'Desfragmentação de disco', 'Fazer desfragmentação de disco rígido', 20, 4),
(14, 'Troca de tela', 'Trocar tela de notebook quebrada', 260, 5),
(15, 'Troca de HD', 'Trocar HD interno para um Seagate 1TB', 480, 1),
(16, 'Troca de fonte', 'Trocar fonte para notebook Acer 14''', 48, 5),
(17, 'Implantação de firewall', 'Implantar e gerenciar firewall no sistema de uma empresa', 70, 3),
(18, 'Instalação de servidor', 'Fazer dual boot e instalar linux junto com windows 7', 43, 2),
(19, 'Recuperar dados', 'Recuperar dados de HD interno', 68, 5),
(20, 'Instalação de antivirus', 'Instalar antivirus Kaspersky', 98, 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `service_orders`
--

CREATE TABLE IF NOT EXISTS `service_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `priorities_id` int(1) NOT NULL,
  `situations_id` int(1) NOT NULL,
  `opening_date` datetime NOT NULL,
  `prevision` date NOT NULL,
  `total_cost` float NOT NULL,
  `reported_problem` varchar(150) NOT NULL,
  `observation` varchar(150) DEFAULT NULL,
  `employees_id` int(11) NOT NULL,
  `clients_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_service_orders_clients` (`clients_id`),
  KEY `FK_service_orders_priorities` (`priorities_id`),
  KEY `FK_service_orders_situations` (`situations_id`),
  KEY `FK_service_orders_employees` (`employees_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Fazendo dump de dados para tabela `service_orders`
--

INSERT INTO `service_orders` (`id`, `priorities_id`, `situations_id`, `opening_date`, `prevision`, `total_cost`, `reported_problem`, `observation`, `employees_id`, `clients_id`) VALUES
(9, 2, 4, '2015-06-20 01:21:05', '2015-06-26', 500, 'Problema no esner', 'asasd', 1, 4),
(10, 3, 4, '2015-06-21 13:03:16', '0000-00-00', 50, 'asdasdasasd', '', 1, 4),
(13, 3, 5, '2015-06-21 15:57:04', '2015-06-18', 100, 'O computador está lento', '', 1, 4),
(14, 3, 6, '2015-06-21 22:53:59', '2015-06-17', 50, 'Computador com vírus', '', 2, 14),
(15, 2, 6, '2015-06-21 22:55:07', '2015-06-12', 68, 'Perca de dados do HD', 'HD interno', 2, 15),
(16, 4, 5, '2015-06-21 22:56:29', '2015-06-16', 65, 'USB com problema', '', 3, 19),
(17, 3, 6, '2015-06-21 23:00:10', '2015-06-10', 260, 'Computador sem Office', '', 1, 22),
(18, 2, 6, '2015-06-21 23:01:33', '2015-06-09', 60, 'Precisa de formatação', '', 2, 20),
(19, 4, 2, '2015-06-21 23:02:43', '2015-06-01', 45, 'Roteador com problemas', '', 5, 17),
(20, 2, 2, '2015-06-21 23:03:48', '2015-06-04', 216, 'Virus no computador', '', 4, 21),
(21, 4, 2, '2015-06-21 23:05:12', '0000-00-00', 20, 'Precisa de desfragmentação de disco', '', 1, 4),
(22, 3, 2, '2015-06-21 23:05:42', '2015-06-19', 48, 'Fonte do notebook queimada', '', 3, 18),
(23, 4, 2, '2015-06-21 23:06:18', '2015-06-05', 358, 'Instalação de pacotes', '', 2, 14),
(24, 4, 6, '2015-06-21 23:07:45', '2015-06-18', 15, 'Computador precisa de limpeza', '', 5, 19);

-- --------------------------------------------------------

--
-- Estrutura para tabela `service_orders_situation`
--

CREATE TABLE IF NOT EXISTS `service_orders_situation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_orders_id` int(11) NOT NULL,
  `previous_situations_id` int(11) NOT NULL,
  `actual_situations_id` int(11) NOT NULL,
  `modification_date` datetime NOT NULL,
  `employees_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_service_orders_situation_employees` (`employees_id`),
  KEY `FK_service_orders_situation_service_orders` (`service_orders_id`),
  KEY `FK_service_orders_situation_previous_situations` (`previous_situations_id`),
  KEY `FK_service_orders_situation_actual_situations` (`actual_situations_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `situations`
--

CREATE TABLE IF NOT EXISTS `situations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Fazendo dump de dados para tabela `situations`
--

INSERT INTO `situations` (`id`, `name`) VALUES
(1, 'Novo'),
(2, 'Em aberto'),
(3, 'Aprovada'),
(4, 'Concluída'),
(5, 'Reprovada'),
(6, 'Cancelada');

-- --------------------------------------------------------

--
-- Estrutura para tabela `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acronym` char(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Fazendo dump de dados para tabela `states`
--

INSERT INTO `states` (`id`, `acronym`) VALUES
(1, 'AC'),
(2, 'AL'),
(3, 'AP'),
(4, 'AM'),
(5, 'BA'),
(6, 'CE'),
(7, 'DF'),
(8, 'ES'),
(9, 'GO'),
(10, 'MA'),
(11, 'MT'),
(12, 'MS'),
(13, 'MG'),
(14, 'PA'),
(15, 'PB'),
(16, 'PR'),
(17, 'PE'),
(18, 'PI'),
(19, 'RJ'),
(20, 'RN'),
(21, 'RS'),
(22, 'RO'),
(23, 'RR'),
(24, 'SC'),
(25, 'SP'),
(26, 'SE'),
(27, 'TO');

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `FK_cities_states` FOREIGN KEY (`states_id`) REFERENCES `states` (`id`);

--
-- Restrições para tabelas `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `FK_clients_cities` FOREIGN KEY (`cities_id`) REFERENCES `cities` (`id`);

--
-- Restrições para tabelas `items_service_order`
--
ALTER TABLE `items_service_order`
  ADD CONSTRAINT `FK_items_service_order_service_orders` FOREIGN KEY (`service_orders_id`) REFERENCES `service_orders` (`id`),
  ADD CONSTRAINT `FK_items_service_order_services` FOREIGN KEY (`services_id`) REFERENCES `services` (`id`);

--
-- Restrições para tabelas `juridical_clients`
--
ALTER TABLE `juridical_clients`
  ADD CONSTRAINT `FK_juridical_clients_clients` FOREIGN KEY (`clients_id`) REFERENCES `clients` (`id`);

--
-- Restrições para tabelas `physical_clients`
--
ALTER TABLE `physical_clients`
  ADD CONSTRAINT `FK_physical_clients_clients` FOREIGN KEY (`clients_id`) REFERENCES `clients` (`id`);

--
-- Restrições para tabelas `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `FK_services_categories` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`);

--
-- Restrições para tabelas `service_orders`
--
ALTER TABLE `service_orders`
  ADD CONSTRAINT `FK_service_orders_clients` FOREIGN KEY (`clients_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `FK_service_orders_employees` FOREIGN KEY (`employees_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `FK_service_orders_priorities` FOREIGN KEY (`priorities_id`) REFERENCES `priorities` (`id`),
  ADD CONSTRAINT `FK_service_orders_situations` FOREIGN KEY (`situations_id`) REFERENCES `situations` (`id`);

--
-- Restrições para tabelas `service_orders_situation`
--
ALTER TABLE `service_orders_situation`
  ADD CONSTRAINT `FK_service_orders_situation_actual_situations` FOREIGN KEY (`actual_situations_id`) REFERENCES `situations` (`id`),
  ADD CONSTRAINT `FK_service_orders_situation_employees` FOREIGN KEY (`employees_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `FK_service_orders_situation_previous_situations` FOREIGN KEY (`previous_situations_id`) REFERENCES `situations` (`id`),
  ADD CONSTRAINT `FK_service_orders_situation_service_orders` FOREIGN KEY (`service_orders_id`) REFERENCES `service_orders` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;