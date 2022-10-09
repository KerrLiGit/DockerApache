-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	8.0.27


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema teacherbase
--

CREATE DATABASE IF NOT EXISTS teacherbase;
USE teacherbase;

--
-- Definition of table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `login` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Логин',
  `password` varchar(20) NOT NULL COMMENT 'Пароль',
  `role` varchar(20) NOT NULL COMMENT 'Роль',
  `surname` varchar(20) NOT NULL COMMENT 'Фамилия',
  `name` varchar(20) NOT NULL COMMENT 'Имя',
  `secname` varchar(20) NOT NULL COMMENT 'Отчество',
  `classnum` int unsigned DEFAULT NULL COMMENT 'Номер класса',
  `classlit` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Литера класса',
  `confirm` int unsigned NOT NULL DEFAULT '0' COMMENT 'Подтвержден',
  PRIMARY KEY (`login`),
  KEY `FK_account_1` (`classnum`,`classlit`),
  KEY `FK_account_2` (`role`),
  CONSTRAINT `FK_account_1` FOREIGN KEY (`classnum`, `classlit`) REFERENCES `class` (`classnum`, `classlit`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_account_2` FOREIGN KEY (`role`) REFERENCES `role` (`role`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Пользователь';

--
-- Dumping data for table `account`
--

/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` (`login`,`password`,`role`,`surname`,`name`,`secname`,`classnum`,`classlit`,`confirm`) VALUES 
 ('catherina','11062015','teacher','Анощенкова','Екатерина','Васильевна',NULL,NULL,1);
/*!40000 ALTER TABLE `account` ENABLE KEYS */;


--
-- Definition of table `class`
--

DROP TABLE IF EXISTS `class`;
CREATE TABLE `class` (
  `classnum` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'Номер класса',
  `classlit` varchar(1) NOT NULL COMMENT 'Литера класса',
  `classid` int unsigned DEFAULT NULL COMMENT 'Описание',
  PRIMARY KEY (`classnum`,`classlit`) USING BTREE,
  CONSTRAINT `FK_class_1` FOREIGN KEY (`classnum`) REFERENCES `classnum` (`classnum`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Класс';

--
-- Dumping data for table `class`
--

/*!40000 ALTER TABLE `class` DISABLE KEYS */;
INSERT INTO `class` (`classnum`,`classlit`,`classid`) VALUES 
 (5,'А',17),
 (5,'Б',18),
 (5,'В',19),
 (5,'Р',20),
 (6,'А',21),
 (6,'Б',22),
 (6,'В',23),
 (6,'Р',24),
 (7,'А',25),
 (7,'Б',26),
 (7,'В',27),
 (7,'Р',28),
 (8,'А',29),
 (8,'Б',30),
 (8,'В',31),
 (8,'Р',32),
 (9,'А',33),
 (9,'Б',34),
 (9,'В',35),
 (9,'Р',36);
/*!40000 ALTER TABLE `class` ENABLE KEYS */;


--
-- Definition of table `classnum`
--

DROP TABLE IF EXISTS `classnum`;
CREATE TABLE `classnum` (
  `classnum` int unsigned NOT NULL COMMENT 'Номер класса',
  `descript` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Описание',
  PRIMARY KEY (`classnum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Номер класса';

--
-- Dumping data for table `classnum`
--

/*!40000 ALTER TABLE `classnum` DISABLE KEYS */;
INSERT INTO `classnum` (`classnum`,`descript`) VALUES 
 (1,'Первый'),
 (2,'Второй'),
 (3,'Третий'),
 (4,'Четвертый'),
 (5,'Пятый'),
 (6,'Шестой'),
 (7,'Седьмой'),
 (8,'Восьмой'),
 (9,'Девятый'),
 (10,'Десятый'),
 (11,'Одиннадцатый');
/*!40000 ALTER TABLE `classnum` ENABLE KEYS */;


--
-- Definition of table `link`
--

DROP TABLE IF EXISTS `link`;
CREATE TABLE `link` (
  `login` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Логин',
  `classnum` int unsigned NOT NULL COMMENT 'Номер класса',
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Тип',
  `topicnum` int unsigned NOT NULL COMMENT 'Номер темы',
  `deadline` date NOT NULL COMMENT 'Срок выполнения'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Связь';

--
-- Dumping data for table `link`
--

/*!40000 ALTER TABLE `link` DISABLE KEYS */;
INSERT INTO `link` (`login`,`classnum`,`type`,`topicnum`,`deadline`) VALUES 
 ('1',5,'math',1,'2022-09-12');
/*!40000 ALTER TABLE `link` ENABLE KEYS */;


--
-- Definition of table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `role` varchar(20) NOT NULL COMMENT 'Роль',
  `descript` varchar(20) NOT NULL COMMENT 'Описание',
  PRIMARY KEY (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Роль';

--
-- Dumping data for table `role`
--

/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` (`role`,`descript`) VALUES 
 ('admin','Администратор'),
 ('student','Ученик'),
 ('teacher','Учитель');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;


--
-- Definition of table `topic`
--

DROP TABLE IF EXISTS `topic`;
CREATE TABLE `topic` (
  `classnum` int unsigned NOT NULL COMMENT 'Номер класса',
  `type` varchar(20) NOT NULL COMMENT 'Тип',
  `topicnum` int unsigned NOT NULL COMMENT 'Номер темы',
  `title` varchar(40) NOT NULL COMMENT 'Заголовок',
  `subtitle` varchar(20) NOT NULL COMMENT 'Подзаголовок',
  `content` varchar(600) NOT NULL COMMENT 'Контент',
  `hidden` varchar(600) NOT NULL COMMENT 'Скрытый контент',
  PRIMARY KEY (`classnum`,`type`,`topicnum`),
  KEY `FK_topic_2` (`type`),
  CONSTRAINT `FK_topic_1` FOREIGN KEY (`classnum`) REFERENCES `classnum` (`classnum`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_topic_2` FOREIGN KEY (`type`) REFERENCES `type` (`type`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Тема';

--
-- Dumping data for table `topic`
--

/*!40000 ALTER TABLE `topic` DISABLE KEYS */;
INSERT INTO `topic` (`classnum`,`type`,`topicnum`,`title`,`subtitle`,`content`,`hidden`) VALUES 
 (5,'math',1,'Урок 1. Рациональные числа','Урок 1','<div style=\"padding-bottom: 10px;\">\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.\r\n</div>','<div style=\"padding-bottom: 10px;\">\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n</div>'),
 (5,'math',2,'Урок 2. Иррациональные числа','Урок 2','<div style=\"padding-bottom: 10px;\">\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.\r\n</div>','<div style=\"padding-bottom: 10px;\">\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n</div>');
/*!40000 ALTER TABLE `topic` ENABLE KEYS */;


--
-- Definition of table `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE `type` (
  `type` varchar(20) NOT NULL COMMENT 'Тип',
  `descript` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Описание',
  PRIMARY KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Тип';

--
-- Dumping data for table `type`
--

/*!40000 ALTER TABLE `type` DISABLE KEYS */;
INSERT INTO `type` (`type`,`descript`) VALUES 
 ('alg','Алгебра'),
 ('geo','Геометрия'),
 ('math','Математика'),
 ('olymp','Олимпиада');
/*!40000 ALTER TABLE `type` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
