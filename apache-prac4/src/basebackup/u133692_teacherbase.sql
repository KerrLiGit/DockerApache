-- MySQL dump 10.13  Distrib 5.7.36, for Linux (x86_64)
--
-- Host: localhost    Database: u133692_teacherbase
-- ------------------------------------------------------
-- Server version	5.7.36-log-cll-lve

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account` (
  `login` varchar(20) NOT NULL COMMENT 'Логин',
  `password` varchar(20) NOT NULL COMMENT 'Пароль',
  `role` varchar(20) NOT NULL COMMENT 'Роль',
  `surname` varchar(20) NOT NULL COMMENT 'Фамилия',
  `name` varchar(20) NOT NULL COMMENT 'Имя',
  `secname` varchar(20) NOT NULL COMMENT 'Отчество',
  `classnum` int(10) unsigned DEFAULT NULL COMMENT 'Номер класса',
  `classlit` varchar(1) DEFAULT NULL COMMENT 'Литера класса',
  `confirm` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Подтвержден',
  PRIMARY KEY (`login`),
  KEY `FK_account_1` (`classnum`,`classlit`),
  KEY `FK_account_2` (`role`),
  CONSTRAINT `FK_account_1` FOREIGN KEY (`classnum`, `classlit`) REFERENCES `class` (`classnum`, `classlit`) ON DELETE SET NULL,
  CONSTRAINT `FK_account_2` FOREIGN KEY (`role`) REFERENCES `role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Пользователь';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` VALUES ('catherina','11072015','teacher','Анощенкова','Екатерина','Васильевна',NULL,NULL,1),('kerrli','TeTriandox','admin','Богатырева','Анна','Алексеевна',NULL,NULL,1);
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`tmp_538746e41033`@`localhost`*/ /*!50003 TRIGGER `accountAFTERINSERT` AFTER INSERT ON `account` FOR EACH ROW INSERT INTO `log` (eventdate, login, `action`, tablename, descript)
    VALUES (NOW(), (SELECT login FROM `session` WHERE `session` = CONNECTION_ID()), 'INSERT', 'account',
    CONCAT('login: "', NEW.login, '"; password: "', NEW.`password`, '"; role: "', NEW.role, 
      '"; surname: "', NEW.surname, '"; name: "', NEW.name, '"; secname: "', NEW.secname, 
      '"; classnum: "', NEW.classnum, '"; classlit: "', NEW.classlit, '"; confirm: "', NEW.confirm, '"')) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`tmp_538746e41033`@`localhost`*/ /*!50003 TRIGGER `accountAFTERUPDATE` AFTER UPDATE ON `account` FOR EACH ROW INSERT INTO `log` (eventdate, login, `action`, tablename, descript)
    VALUES (NOW(), (SELECT login FROM `session` WHERE `session` = CONNECTION_ID()), 'UPDATE', 'account',
      TRIM(';' FROM CONCAT_WS(';',
        CONCAT('login: "', OLD.login, '" '),
        IF (NEW.`password` != OLD.`password`, CONCAT('changed_password: "', OLD.`password`, '"=>"', NEW.`password`, '" '), ''),
        IF (NEW.role != OLD.role, CONCAT('changed_role: "', OLD.role, '"=>"', NEW.role, '" '), ''),
        IF (CONCAT(NEW.surname, NEW.name, NEW.secname) != CONCAT(OLD.surname, OLD.name, OLD.secname), 
          CONCAT('changed_name: "', CONCAT(OLD.surname, " ", OLD.name, " ", OLD.secname), '"=>"', 
          CONCAT(NEW.surname, " ", NEW.name, " ", NEW.secname), '" '), ''),
        IF (CONCAT(NEW.classnum, NEW.classlit) != CONCAT(OLD.classnum, OLD.classlit), 
          CONCAT('changed_class: "', CONCAT(OLD.classnum, OLD.classlit), '"=>"', CONCAT(NEW.classnum, NEW.classlit), '" '), ''),
        IF (NEW.confirm != OLD.confirm, CONCAT('changed_confirm: "', OLD.confirm, '"=>"', NEW.confirm, '" '), '')
      ))
    ) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`tmp_538746e41033`@`localhost`*/ /*!50003 TRIGGER `accountAFTERDELETE` AFTER DELETE ON `account` FOR EACH ROW INSERT INTO `log` (eventdate, login, `action`, tablename, descript)
    VALUES (NOW(), (SELECT login FROM `session` WHERE `session` = CONNECTION_ID()), 'DELETE', 'account',
    CONCAT('login: "', OLD.login, '"; password: "', OLD.`password`, '"; role: "', OLD.role, 
      '"; surname: "', OLD.surname, '"; name: "', OLD.name, '"; secname: "', OLD.secname, 
      '"; classnum: "', OLD.classnum, '"; classlit: "', OLD.classlit, '"; confirm: "', OLD.confirm, '"')) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class` (
  `classnum` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Номер класса',
  `classlit` varchar(1) NOT NULL COMMENT 'Литера класса',
  `classid` int(10) unsigned DEFAULT NULL COMMENT 'Описание',
  PRIMARY KEY (`classnum`,`classlit`) USING BTREE,
  CONSTRAINT `FK_class_1` FOREIGN KEY (`classnum`) REFERENCES `classnum` (`classnum`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='Класс';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class`
--

LOCK TABLES `class` WRITE;
/*!40000 ALTER TABLE `class` DISABLE KEYS */;
INSERT INTO `class` VALUES (5,'А',17),(5,'Б',18),(5,'В',19),(5,'Р',20),(6,'А',21),(6,'Б',22),(6,'В',23),(6,'Р',24),(7,'А',25),(7,'Б',26),(7,'В',27),(7,'Р',28),(8,'А',29),(8,'Б',30),(8,'В',31),(8,'Р',32),(9,'А',33),(9,'Б',34),(9,'В',35),(9,'Р',36);
/*!40000 ALTER TABLE `class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classnum`
--

DROP TABLE IF EXISTS `classnum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classnum` (
  `classnum` int(10) unsigned NOT NULL COMMENT 'Номер класса',
  `descript` varchar(20) DEFAULT NULL COMMENT 'Описание',
  PRIMARY KEY (`classnum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Номер класса';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classnum`
--

LOCK TABLES `classnum` WRITE;
/*!40000 ALTER TABLE `classnum` DISABLE KEYS */;
INSERT INTO `classnum` VALUES (1,'Первый'),(2,'Второй'),(3,'Третий'),(4,'Четвертый'),(5,'Пятый'),(6,'Шестой'),(7,'Седьмой'),(8,'Восьмой'),(9,'Девятый'),(10,'Десятый'),(11,'Одиннадцатый');
/*!40000 ALTER TABLE `classnum` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `link`
--

DROP TABLE IF EXISTS `link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `link` (
  `login` varchar(20) NOT NULL COMMENT 'Логин',
  `classnum` int(10) unsigned NOT NULL COMMENT 'Номер класса',
  `type` varchar(20) NOT NULL COMMENT 'Тип',
  `topicnum` int(10) unsigned NOT NULL COMMENT 'Номер темы',
  `deadline` date NOT NULL COMMENT 'Срок выполнения',
  KEY `FK_link_1` (`login`),
  KEY `FK_link_2` (`classnum`,`type`,`topicnum`),
  CONSTRAINT `FK_link_1` FOREIGN KEY (`login`) REFERENCES `account` (`login`) ON DELETE CASCADE,
  CONSTRAINT `FK_link_2` FOREIGN KEY (`classnum`, `type`, `topicnum`) REFERENCES `topic` (`classnum`, `type`, `topicnum`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Связь';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `link`
--

LOCK TABLES `link` WRITE;
/*!40000 ALTER TABLE `link` DISABLE KEYS */;
/*!40000 ALTER TABLE `link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `log` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `eventdate` datetime NOT NULL COMMENT 'Дата и время добавления лога',
  `login` varchar(20) DEFAULT NULL COMMENT 'Логин',
  `action` varchar(20) NOT NULL COMMENT 'Действие, произведенное с базой данных',
  `tablename` varchar(20) NOT NULL COMMENT 'Название таблицы',
  `descript` varchar(5000) NOT NULL COMMENT 'Содержание лога',
  PRIMARY KEY (`log`) USING BTREE,
  KEY `Index_2` (`eventdate`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COMMENT='Хранилище логов';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `role` varchar(20) NOT NULL COMMENT 'Роль',
  `descript` varchar(20) NOT NULL COMMENT 'Описание',
  PRIMARY KEY (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Роль';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES ('admin','Администратор'),('student','Ученик'),('teacher','Учитель');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session` (
  `login` varchar(20) NOT NULL COMMENT 'Логин',
  `session` int(10) unsigned NOT NULL COMMENT 'Сессия',
  KEY `Index_1` (`session`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Привязка логинов пользователей к сессиям MySQL';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session`
--

LOCK TABLES `session` WRITE;
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
/*!40000 ALTER TABLE `session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topic`
--

DROP TABLE IF EXISTS `topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topic` (
  `classnum` int(10) unsigned NOT NULL COMMENT 'Номер класса',
  `type` varchar(20) NOT NULL COMMENT 'Тип',
  `topicnum` int(10) unsigned NOT NULL COMMENT 'Номер темы',
  `title` varchar(80) NOT NULL COMMENT 'Заголовок',
  `subtitle` varchar(20) NOT NULL COMMENT 'Подзаголовок',
  `content` varchar(1000) NOT NULL COMMENT 'Контент',
  `hidden` varchar(1000) DEFAULT NULL COMMENT 'Скрытый контент',
  PRIMARY KEY (`classnum`,`type`,`topicnum`),
  KEY `FK_topic_2` (`type`),
  CONSTRAINT `FK_topic_1` FOREIGN KEY (`classnum`) REFERENCES `classnum` (`classnum`),
  CONSTRAINT `FK_topic_2` FOREIGN KEY (`type`) REFERENCES `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Тема';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topic`
--

LOCK TABLES `topic` WRITE;
/*!40000 ALTER TABLE `topic` DISABLE KEYS */;
INSERT INTO `topic` VALUES (6,'olymp',1,'ТРЕНИРОВОЧНЫЙ ВАРИАНТ','ТВ','<div <div style=\'padding-bottom: 10px;\'>Ребята, готовимся к школьному этапу всероссийской олимпиады школьников.</div>\r\n<div <div style=\'padding-bottom: 10px;\'>Предлагаю вам тренировочный вариант с платформы Сириус.</div>\r\n<div <div style=\'padding-bottom: 10px;\'>   </div>\r\n<a href=\'https://forms.gle/NvbgWnkcF8JcVvhf8\'>Решать тренировочный вариант</a>\r\n<div <div style=\'padding-bottom: 10px;\'>   </div>\r\n<div <div style=\'padding-bottom: 10px;\'>Время решения задач не ограничено, количество отправлений тоже не ограничено.</div>\r\n<div <div style=\'padding-bottom: 10px;\'>В 17:00 выложу результаты и разбор заданий. </div>',''),(7,'alg',1,'Урок 1. Седьмой класс','Урок 1','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?'),(7,'alg',2,'Урок 2. Седьмой класс','Урок 2','But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?',''),(9,'alg',1,'1','1','1','1'),(9,'alg',2,'2','2','2','2');
/*!40000 ALTER TABLE `topic` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`tmp_538746e41033`@`localhost`*/ /*!50003 TRIGGER `topicAFTERINSERT` AFTER INSERT ON `topic` FOR EACH ROW INSERT INTO `log` (eventdate, login, `action`, tablename, descript)
    VALUES (NOW(), (SELECT login FROM `session` WHERE `session` = CONNECTION_ID()), 'INSERT', 'topic',
    CONCAT('classnum: "', NEW.classnum, '"; type: "', NEW.`type`, '"; topicnum: "', NEW.topicnum, 
      '"; title: "', NEW.title, '"; content: "', NEW.content, '"; hidden: "', NEW.hidden, '"')) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`tmp_538746e41033`@`localhost`*/ /*!50003 TRIGGER `topicAFTERUPDATE` AFTER UPDATE ON `topic` FOR EACH ROW INSERT INTO `log` (eventdate, login, `action`, tablename, descript)
    VALUES (NOW(), (SELECT login FROM `session` WHERE `session` = CONNECTION_ID()), 'UPDATE', 'topic',
      TRIM(';' FROM CONCAT_WS(';',
        CONCAT('classnum: "', OLD.classnum, '" '),
        CONCAT('type: "', OLD.`type`, '" '),
        CONCAT('topicnum: "', OLD.topicnum, '" '),
        IF (NEW.title != OLD.title, CONCAT('changed_title: "', OLD.title, '"=>"', NEW.title, '" '), ''),
        IF (NEW.subtitle != OLD.subtitle, CONCAT('changed_subtitle: "', OLD.subtitle, '"=>"', NEW.subtitle, '" '), ''),
        IF (NEW.content != OLD.content, CONCAT('changed_content: "', OLD.content, '"=>"', NEW.content, '" '), ''),
        IF (NEW.hidden != OLD.hidden, CONCAT('changed_hidden: "', OLD.hidden, '"=>"', NEW.hidden, '" '), '')
      ))
    ) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`tmp_538746e41033`@`localhost`*/ /*!50003 TRIGGER `topicAFTERDELETE` AFTER DELETE ON `topic` FOR EACH ROW INSERT INTO `log` (eventdate, login, `action`, tablename, descript)
    VALUES (NOW(), (SELECT login FROM `session` WHERE `session` = CONNECTION_ID()), 'DELETE', 'topic',
    CONCAT('classnum: "', OLD.classnum, '"; type: "', OLD.`type`, '"; topicnum: "', OLD.topicnum, 
      '"; title: "', OLD.title, '"; content: "', OLD.content, '"; hidden: "', OLD.hidden, '"')) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `type`
--

DROP TABLE IF EXISTS `type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type` (
  `type` varchar(20) NOT NULL COMMENT 'Тип',
  `descript` varchar(40) NOT NULL COMMENT 'Описание',
  PRIMARY KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Тип';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type`
--

LOCK TABLES `type` WRITE;
/*!40000 ALTER TABLE `type` DISABLE KEYS */;
INSERT INTO `type` VALUES ('alg','Алгебра'),('geo','Геометрия'),('math','Математика'),('olymp','Олимпиада');
/*!40000 ALTER TABLE `type` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-04 10:26:34
