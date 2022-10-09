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
  CONSTRAINT `FK_account_1` FOREIGN KEY (`classnum`, `classlit`) REFERENCES `class` (`classnum`, `classlit`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `FK_account_2` FOREIGN KEY (`role`) REFERENCES `role` (`role`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Пользователь';

--
-- Dumping data for table `account`
--

/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` (`login`,`password`,`role`,`surname`,`name`,`secname`,`classnum`,`classlit`,`confirm`) VALUES 
 ('catherina','11072015','teacher','Анощенкова','Екатерина','Васильевна',NULL,NULL,1),
 ('ivan','qwerty','student','Иванов','Иван','Иванов',5,'А',0),
 ('kerrli','TeTriandox','admin','Богатырева','Анна','Алексеевна',NULL,NULL,1);
/*!40000 ALTER TABLE `account` ENABLE KEYS */;


--
-- Definition of trigger `accountAFTERINSERT`
--

DROP TRIGGER /*!50030 IF EXISTS */ `accountAFTERINSERT`;

DELIMITER $$

CREATE DEFINER = `root`@`localhost` TRIGGER `accountAFTERINSERT` AFTER INSERT ON `account` FOR EACH ROW INSERT INTO `log` (eventdate, login, `action`, tablename, descript)
    VALUES (NOW(), (SELECT login FROM `session` WHERE `session` = CONNECTION_ID()), 'INSERT', 'account',
    CONCAT('login: "', NEW.login, '"; password: "', NEW.`password`, '"; role: "', NEW.role, 
      '"; surname: "', NEW.surname, '"; name: "', NEW.name, '"; secname: "', NEW.secname, 
      '"; classnum: "', NEW.classnum, '"; classlit: "', NEW.classlit, '"; confirm: "', NEW.confirm, '"')) $$

DELIMITER ;

--
-- Definition of trigger `accountAFTERUPDATE`
--

DROP TRIGGER /*!50030 IF EXISTS */ `accountAFTERUPDATE`;

DELIMITER $$

CREATE DEFINER = `root`@`localhost` TRIGGER `accountAFTERUPDATE` AFTER UPDATE ON `account` FOR EACH ROW INSERT INTO `log` (eventdate, login, `action`, tablename, descript)
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
    ) $$

DELIMITER ;

--
-- Definition of trigger `accountAFTERDELETE`
--

DROP TRIGGER /*!50030 IF EXISTS */ `accountAFTERDELETE`;

DELIMITER $$

CREATE DEFINER = `root`@`localhost` TRIGGER `accountAFTERDELETE` AFTER DELETE ON `account` FOR EACH ROW INSERT INTO `log` (eventdate, login, `action`, tablename, descript)
    VALUES (NOW(), (SELECT login FROM `session` WHERE `session` = CONNECTION_ID()), 'DELETE', 'account',
    CONCAT('login: "', OLD.login, '"; password: "', OLD.`password`, '"; role: "', OLD.role, 
      '"; surname: "', OLD.surname, '"; name: "', OLD.name, '"; secname: "', OLD.secname, 
      '"; classnum: "', OLD.classnum, '"; classlit: "', OLD.classlit, '"; confirm: "', OLD.confirm, '"')) $$

DELIMITER ;

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
  `deadline` date NOT NULL COMMENT 'Срок выполнения',
  KEY `FK_link_1` (`login`),
  KEY `FK_link_2` (`classnum`,`type`,`topicnum`),
  CONSTRAINT `FK_link_1` FOREIGN KEY (`login`) REFERENCES `account` (`login`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `FK_link_2` FOREIGN KEY (`classnum`, `type`, `topicnum`) REFERENCES `topic` (`classnum`, `type`, `topicnum`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Связь';

--
-- Dumping data for table `link`
--

/*!40000 ALTER TABLE `link` DISABLE KEYS */;
/*!40000 ALTER TABLE `link` ENABLE KEYS */;


--
-- Definition of table `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `log` int unsigned NOT NULL AUTO_INCREMENT,
  `eventdate` datetime NOT NULL COMMENT 'Дата и время добавления лога',
  `login` varchar(20) DEFAULT NULL COMMENT 'Логин',
  `action` varchar(20) NOT NULL COMMENT 'Действие, произведенное с базой данных',
  `tablename` varchar(20) NOT NULL COMMENT 'Название таблицы',
  `descript` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Содержание лога',
  PRIMARY KEY (`log`) USING BTREE,
  KEY `Index_2` (`eventdate`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Хранилище логов';

--
-- Dumping data for table `log`
--

/*!40000 ALTER TABLE `log` DISABLE KEYS */;
INSERT INTO `log` (`log`,`eventdate`,`login`,`action`,`tablename`,`descript`) VALUES 
 (6,'2022-09-14 18:45:50','kerrli','INSERT','topic','classnum: \"7\"; type: \"alg\"; topicnum: \"2\"; title: \"Урок 2. Седьмой класс\"; content: \"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"; hidden: \"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\"'),
 (7,'2022-09-14 18:48:10','kerrli','UPDATE','topic','content: \"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"=>\"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?\" ;hidden: \"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\"=>\"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.\" '),
 (8,'2022-09-17 21:45:22',NULL,'INSERT','account','login: \"12\"; password: \"12\"; role: \"student\"; surname: \"12\"; name: \"12\"; secname: \"12\"; classnum: \"5\"; classlit: \"А\"; confirm: \"0\"'),
 (9,'2022-09-17 21:45:59','kerrli','DELETE','account','login: \"12\"; password: \"12\"; role: \"student\"; surname: \"12\"; name: \"12\"; secname: \"12\"; classnum: \"5\"; classlit: \"А\"; confirm: \"0\"'),
 (10,'2022-10-02 12:52:34',NULL,'UPDATE','topic','classnum: \"7\" ;type: \"alg\" ;topicnum: \"2\" ;;changed_subtitle: \"Урок 2\"=>\"Урок 2a\" '),
 (11,'2022-10-02 12:53:02',NULL,'UPDATE','topic','classnum: \"7\" ;type: \"alg\" ;topicnum: \"2\" ;;changed_subtitle: \"Урок 2a\"=>\"Урок 2\" '),
 (12,'2022-10-02 15:10:16',NULL,'UPDATE','topic','classnum: \"7\" ;type: \"alg\" ;topicnum: \"2\" ;;;;changed_hidden: \"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.\"=>\"\" '),
 (13,'2022-10-02 15:11:25',NULL,'UPDATE','topic','classnum: \"7\" ;type: \"alg\" ;topicnum: \"2\" '),
 (14,'2022-10-02 20:03:27',NULL,'INSERT','account','login: \"1\"; password: \"1\"; role: \"student\"; surname: \"1\"; name: \"1\"; secname: \"1\"; classnum: \"5\"; classlit: \"В\"; confirm: \"0\"'),
 (15,'2022-10-02 20:08:41',NULL,'UPDATE','account','login: \"1\" ;;;;;changed_confirm: \"0\"=>\"1\" '),
 (16,'2022-10-02 20:43:04',NULL,'INSERT','account','login: \"2\"; password: \"2\"; role: \"student\"; surname: \"2\"; name: \"2\"; secname: \"2\"; classnum: \"5\"; classlit: \"А\"; confirm: \"0\"'),
 (17,'2022-10-02 20:58:03','kerrli','UPDATE','account','login: \"2\" ;;;;;changed_confirm: \"0\"=>\"1\" '),
 (18,'2022-10-02 20:58:12','kerrli','UPDATE','account','login: \"2\" '),
 (19,'2022-10-02 20:59:22','kerrli','UPDATE','account','login: \"2\" '),
 (20,'2022-10-02 20:59:33',NULL,'UPDATE','account','login: \"1\" ;;;;;changed_confirm: \"1\"=>\"0\" '),
 (21,'2022-10-02 20:59:33',NULL,'UPDATE','account','login: \"2\" ;;;;;changed_confirm: \"1\"=>\"0\" '),
 (22,'2022-10-02 20:59:39','kerrli','UPDATE','account','login: \"1\" ;;;;;changed_confirm: \"0\"=>\"1\" '),
 (23,'2022-10-02 20:59:42','kerrli','DELETE','account','login: \"2\"; password: \"2\"; role: \"student\"; surname: \"2\"; name: \"2\"; secname: \"2\"; classnum: \"5\"; classlit: \"А\"; confirm: \"0\"'),
 (24,'2022-10-02 21:00:41',NULL,'UPDATE','account','login: \"1\" '),
 (25,'2022-10-02 21:32:28','kerrli','INSERT','topic','classnum: \"9\"; type: \"alg\"; topicnum: \"1\"; title: \"1\"; content: \"1\"; hidden: \"1\"'),
 (26,'2022-10-03 14:51:22','kerrli','INSERT','topic','classnum: \"9\"; type: \"alg\"; topicnum: \"2\"; title: \"2\"; content: \"2\"; hidden: \"2\"'),
 (27,'2022-10-03 22:09:27','kerrli','INSERT','topic','classnum: \"6\"; type: \"olymp\"; topicnum: \"1\"; title: \"ТРЕНИРОВОЧНЫЙ ВАРИАНТ\"; content: \"<div style=\"padding-bottom: 10px;\">Ребята, готовимся к школьному этапу всероссийской олимпиады школьников.</div>\r\n<div style=\"padding-bottom: 10px;\">Предлагаю вам тренировочный вариант с платформы Сириус.</div>\r\n<div style=\"padding-bottom: 10px;\">   </div>\r\n<a href=\"https://forms.gle/NvbgWnkcF8JcVvhf8\">Решать тренировочный вариант</a>\r\n<div style=\"padding-bottom: 10px;\">   </div>\r\n<div style=\"padding-bottom: 10px;\">Время решения задач не ограничено, количество отправлений тоже не ограничено.</div>\r\n<div style=\"padding-bottom: 10px;\">В 17:00 выложу результаты и разбор заданий. </div>\"; hidden: \"\"'),
 (28,'2022-10-03 22:51:41',NULL,'UPDATE','topic','classnum: \"7\" ;type: \"alg\" ;topicnum: \"2\" '),
 (29,'2022-10-03 22:51:45',NULL,'UPDATE','topic','classnum: \"7\" ;type: \"alg\" ;topicnum: \"2\" ;;;;changed_hidden: \" \"=>\"\" '),
 (30,'2022-10-03 23:44:30',NULL,'UPDATE','topic','classnum: \"6\" ;type: \"olymp\" ;topicnum: \"1\" ;;;changed_content: \"<div style=\"padding-bottom: 10px;\">Ребята, готовимся к школьному этапу всероссийской олимпиады школьников.</div>\r\n<div style=\"padding-bottom: 10px;\">Предлагаю вам тренировочный вариант с платформы Сириус.</div>\r\n<div style=\"padding-bottom: 10px;\">   </div>\r\n<a href=\"https://forms.gle/NvbgWnkcF8JcVvhf8\">Решать тренировочный вариант</a>\r\n<div style=\"padding-bottom: 10px;\">   </div>\r\n<div style=\"padding-bottom: 10px;\">Время решения задач не ограничено, количество отправлений тоже не ограничено.</div>\r\n<div style=\"padding-bottom: 10px;\">В 17:00 выложу результаты и разбор заданий. </div>\"=>\"<div>Ребята, готовимся к школьному этапу всероссийской олимпиады школьников.</div>\r\n<div>Предлагаю вам тренировочный вариант с платформы Сириус.</div>\r\n<div>   </div>\r\n<a href=\'https://forms.gle/NvbgWnkcF8JcVvhf8\'>Решать тренировочный вариант</a>\r\n<div>   </div>\r\n<div>Время решения задач не ограничено, количество отправлений тоже не ограничено.</div>\r\n<div>В 17:00 выложу результаты и разбор заданий. </div>\" '),
 (31,'2022-10-03 23:48:04',NULL,'UPDATE','topic','classnum: \"6\" ;type: \"olymp\" ;topicnum: \"1\" ;;;changed_content: \"<div>Ребята, готовимся к школьному этапу всероссийской олимпиады школьников.</div>\r\n<div>Предлагаю вам тренировочный вариант с платформы Сириус.</div>\r\n<div>   </div>\r\n<a href=\'https://forms.gle/NvbgWnkcF8JcVvhf8\'>Решать тренировочный вариант</a>\r\n<div>   </div>\r\n<div>Время решения задач не ограничено, количество отправлений тоже не ограничено.</div>\r\n<div>В 17:00 выложу результаты и разбор заданий. </div>\"=>\"<div <div style=\'padding-bottom: 10px;\'>Ребята, готовимся к школьному этапу всероссийской олимпиады школьников.</div>\r\n<div <div style=\'padding-bottom: 10px;\'>Предлагаю вам тренировочный вариант с платформы Сириус.</div>\r\n<div <div style=\'padding-bottom: 10px;\'>   </div>\r\n<a href=\'https://forms.gle/NvbgWnkcF8JcVvhf8\'>Решать тренировочный вариант</a>\r\n<div <div style=\'padding-bottom: 10px;\'>   </div>\r\n<div <div style=\'padding-bottom: 10px;\'>Время решения задач не ограничено, количество отправлений тоже не ограничено.</div>\r\n<div <div style=\'padding-bottom: 10px;\'>В 17:00 выложу результаты и разбор заданий. </div>\" '),
 (32,'2022-10-04 00:29:34','kerrli','UPDATE','topic','classnum: \"5\" ;type: \"math\" ;topicnum: \"1\" ;;;changed_content: \"<div style=\"padding-bottom: 10px;\">\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.\r\n</div>\"=>\"1\" ;changed_hidden: \"<div style=\"padding-bottom: 10px;\">\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n</div>\"=>\"1\" '),
 (33,'2022-10-04 00:31:36','kerrli','UPDATE','topic','classnum: \"5\" ;type: \"math\" ;topicnum: \"1\" '),
 (34,'2022-10-04 00:33:14','kerrli','UPDATE','topic','classnum: \"5\" ;type: \"math\" ;topicnum: \"1\" ;;;changed_content: \"1\"=>\"\" ;changed_hidden: \"1\"=>\"\" '),
 (35,'2022-10-04 00:35:01','kerrli','UPDATE','topic','classnum: \"5\" ;type: \"math\" ;topicnum: \"1\" ;;;changed_content: \"\"=>\"1\" ;changed_hidden: \"\"=>\"1\" '),
 (36,'2022-10-04 00:44:13','kerrli','UPDATE','topic','classnum: \"5\" ;type: \"math\" ;topicnum: \"1\" '),
 (37,'2022-10-04 00:44:24','kerrli','UPDATE','topic','classnum: \"5\" ;type: \"math\" ;topicnum: \"1\" ;;;changed_content: \"1\"=>\"12\" ;changed_hidden: \"1\"=>\"12\" '),
 (38,'2022-10-04 00:45:31','kerrli','DELETE','topic','classnum: \"5\"; type: \"math\"; topicnum: \"1\"; title: \"Урок 1. Рациональные числа\"; content: \"12\"; hidden: \"12\"'),
 (39,'2022-10-04 00:46:03','kerrli','INSERT','topic','classnum: \"5\"; type: \"math\"; topicnum: \"1\"; title: \"1\"; content: \"1\"; hidden: \"1\"'),
 (40,'2022-10-04 00:46:12','kerrli','DELETE','topic','classnum: \"5\"; type: \"math\"; topicnum: \"1\"; title: \"1\"; content: \"1\"; hidden: \"1\"'),
 (41,'2022-10-04 00:47:43','kerrli','INSERT','topic','classnum: \"5\"; type: \"math\"; topicnum: \"1\"; title: \"1\"; content: \"1\"; hidden: \"1\"'),
 (42,'2022-10-04 00:47:47','kerrli','DELETE','topic','classnum: \"5\"; type: \"math\"; topicnum: \"1\"; title: \"1\"; content: \"1\"; hidden: \"1\"'),
 (43,'2022-10-04 00:48:01','kerrli','INSERT','topic','classnum: \"5\"; type: \"math\"; topicnum: \"1\"; title: \"1\"; content: \"1\"; hidden: \"1\"'),
 (44,'2022-10-04 00:48:13','kerrli','DELETE','topic','classnum: \"5\"; type: \"math\"; topicnum: \"2\"; title: \"Урок 2. Иррациональные числа\"; content: \"<div style=\"padding-bottom: 10px;\">\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.\r\n</div>\"; hidden: \"<div style=\"padding-bottom: 10px;\">\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n</div>\"'),
 (45,'2022-10-04 00:48:14','kerrli','DELETE','topic','classnum: \"5\"; type: \"math\"; topicnum: \"1\"; title: \"1\"; content: \"1\"; hidden: \"1\"'),
 (46,'2022-10-04 01:04:53','kerrli','UPDATE','topic','classnum: \"7\" ;type: \"alg\" ;topicnum: \"1\" '),
 (47,'2022-10-04 02:09:17','kerrli','DELETE','topic','classnum: \"7\"; type: \"alg\"; topicnum: \"2\"; title: \"Урок 2. Седьмой класс\"; content: \"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?\"; hidden: \"\"'),
 (48,'2022-10-04 02:10:28',NULL,'UPDATE','account','login: \"catherina\" ;changed_password: \"11062015\"=>\"11072015\" '),
 (49,'2022-10-04 02:10:43','catherina','DELETE','topic','classnum: \"7\"; type: \"alg\"; topicnum: \"1\"; title: \"Урок 1. Седьмой класс\"; content: \"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"; hidden: \"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\"'),
 (50,'2022-10-04 10:52:29',NULL,'INSERT','account','login: \"2\"; password: \"2\"; role: \"student\"; surname: \"2\"; name: \"2\"; secname: \"2\"; classnum: \"5\"; classlit: \"В\"; confirm: \"0\"'),
 (51,'2022-10-04 10:54:48','kerrli','DELETE','account','login: \"2\"; password: \"2\"; role: \"student\"; surname: \"2\"; name: \"2\"; secname: \"2\"; classnum: \"5\"; classlit: \"В\"; confirm: \"0\"'),
 (52,'2022-10-04 10:55:14',NULL,'DELETE','account','login: \"1\"; password: \"1\"; role: \"student\"; surname: \"1\"; name: \"1\"; secname: \"1\"; classnum: \"5\"; classlit: \"В\"; confirm: \"1\"'),
 (53,'2022-10-04 10:55:30',NULL,'INSERT','account','login: \"1\"; password: \"1\"; role: \"student\"; surname: \"1\"; name: \"1\"; secname: \"1\"; classnum: \"5\"; classlit: \"А\"; confirm: \"0\"'),
 (54,'2022-10-04 10:55:36',NULL,'UPDATE','account','login: \"1\" ;;;;;changed_confirm: \"0\"=>\"1\" '),
 (55,'2022-10-04 10:55:44',NULL,'DELETE','account','login: \"1\"; password: \"1\"; role: \"student\"; surname: \"1\"; name: \"1\"; secname: \"1\"; classnum: \"5\"; classlit: \"А\"; confirm: \"1\"'),
 (56,'2022-10-04 10:55:57',NULL,'INSERT','account','login: \"1\"; password: \"1\"; role: \"student\"; surname: \"1\"; name: \"1\"; secname: \"1\"; classnum: \"5\"; classlit: \"А\"; confirm: \"0\"'),
 (57,'2022-10-04 10:56:05','catherina','DELETE','account','login: \"1\"; password: \"1\"; role: \"student\"; surname: \"1\"; name: \"1\"; secname: \"1\"; classnum: \"5\"; classlit: \"А\"; confirm: \"0\"'),
 (58,'2022-10-07 02:22:54',NULL,'INSERT','account','login: \"ivan\"; password: \"qwerty\"; role: \"student\"; surname: \"Иванов\"; name: \"Иван\"; secname: \"Иванов\"; classnum: \"5\"; classlit: \"А\"; confirm: \"0\"'),
 (59,'2022-10-07 02:37:56',NULL,'DELETE','account','login: \"ivan\"; password: \"qwerty\"; role: \"student\"; surname: \"Иванов\"; name: \"Иван\"; secname: \"Иванов\"; classnum: \"5\"; classlit: \"А\"; confirm: \"0\"'),
 (60,'2022-10-07 02:47:13',NULL,'INSERT','account','login: \"ivan\"; password: \"qwerty\"; role: \"student\"; surname: \"Иванов\"; name: \"Иван\"; secname: \"Иванов\"; classnum: \"5\"; classlit: \"А\"; confirm: \"0\"'),
 (61,'2022-10-07 10:52:10',NULL,'UPDATE','account','login: \"ivan\" ;;;changed_name: \"Иванов Иван Иванов\"=>\"Иванов Иван Иванович\" ;changed_class: \"5А\"=>\"5В\" ;changed_confirm: \"0\"=>\"1\" '),
 (62,'2022-10-07 10:52:38',NULL,'UPDATE','account','login: \"ivan\" ;;;;;changed_confirm: \"1\"=>\"0\" '),
 (63,'2022-10-07 11:01:07',NULL,'UPDATE','account','login: \"ivan\" ;;;changed_name: \"Иванов Иван Иванович\"=>\"Иванов Иван Иванов\" ;changed_class: \"5В\"=>\"5А\" ;changed_confirm: \"0\"=>\"1\" '),
 (64,'2022-10-07 11:03:32',NULL,'UPDATE','account','login: \"ivan\" '),
 (65,'2022-10-07 11:04:40',NULL,'UPDATE','account','login: \"ivan\" '),
 (66,'2022-10-07 11:05:02',NULL,'UPDATE','account','login: \"ivan\" ;;;;;changed_confirm: \"1\"=>\"0\" '),
 (67,'2022-10-07 12:23:44',NULL,'INSERT','topic','classnum: \"5\"; type: \"math\"; topicnum: \"1\"; title: \"Title\"; content: \"This is topic content.\"; hidden: \"This is hidden topic content.\"'),
 (68,'2022-10-07 12:35:31',NULL,'UPDATE','topic','classnum: \"5\" ;type: \"math\" ;topicnum: \"1\" ;;;changed_content: \"This is topic content.\"=>\"This is new topic content.\" ;changed_hidden: \"This is hidden topic content.\"=>\"This is new hidden topic content.\" '),
 (69,'2022-10-07 12:35:48',NULL,'UPDATE','topic','classnum: \"5\" ;type: \"math\" ;topicnum: \"1\" '),
 (70,'2022-10-07 12:44:33',NULL,'DELETE','topic','classnum: \"5\"; type: \"math\"; topicnum: \"1\"; title: \"Title\"; content: \"This is new topic content.\"; hidden: \"This is new hidden topic content.\"');
/*!40000 ALTER TABLE `log` ENABLE KEYS */;


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
-- Definition of table `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `login` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Логин',
  `session` int unsigned NOT NULL COMMENT 'Сессия',
  KEY `Index_1` (`session`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Привязка логинов пользователей к сессиям MySQL';

--
-- Dumping data for table `session`
--

/*!40000 ALTER TABLE `session` DISABLE KEYS */;
/*!40000 ALTER TABLE `session` ENABLE KEYS */;


--
-- Definition of table `topic`
--

DROP TABLE IF EXISTS `topic`;
CREATE TABLE `topic` (
  `classnum` int unsigned NOT NULL COMMENT 'Номер класса',
  `type` varchar(20) NOT NULL COMMENT 'Тип',
  `topicnum` int unsigned NOT NULL COMMENT 'Номер темы',
  `title` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Заголовок',
  `subtitle` varchar(20) NOT NULL COMMENT 'Подзаголовок',
  `content` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Контент',
  `hidden` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Скрытый контент',
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
 (6,'olymp',1,'ТРЕНИРОВОЧНЫЙ ВАРИАНТ','ТВ','<div <div style=\'padding-bottom: 10px;\'>Ребята, готовимся к школьному этапу всероссийской олимпиады школьников.</div>\r\n<div <div style=\'padding-bottom: 10px;\'>Предлагаю вам тренировочный вариант с платформы Сириус.</div>\r\n<div <div style=\'padding-bottom: 10px;\'>   </div>\r\n<a href=\'https://forms.gle/NvbgWnkcF8JcVvhf8\'>Решать тренировочный вариант</a>\r\n<div <div style=\'padding-bottom: 10px;\'>   </div>\r\n<div <div style=\'padding-bottom: 10px;\'>Время решения задач не ограничено, количество отправлений тоже не ограничено.</div>\r\n<div <div style=\'padding-bottom: 10px;\'>В 17:00 выложу результаты и разбор заданий. </div>',''),
 (9,'alg',1,'1','1','1','1'),
 (9,'alg',2,'2','2','2','2');
/*!40000 ALTER TABLE `topic` ENABLE KEYS */;


--
-- Definition of trigger `topicAFTERINSERT`
--

DROP TRIGGER /*!50030 IF EXISTS */ `topicAFTERINSERT`;

DELIMITER $$

CREATE DEFINER = `root`@`localhost` TRIGGER `topicAFTERINSERT` AFTER INSERT ON `topic` FOR EACH ROW INSERT INTO `log` (eventdate, login, `action`, tablename, descript)
    VALUES (NOW(), (SELECT login FROM `session` WHERE `session` = CONNECTION_ID()), 'INSERT', 'topic',
    CONCAT('classnum: "', NEW.classnum, '"; type: "', NEW.`type`, '"; topicnum: "', NEW.topicnum, 
      '"; title: "', NEW.title, '"; content: "', NEW.content, '"; hidden: "', NEW.hidden, '"')) $$

DELIMITER ;

--
-- Definition of trigger `topicAFTERUPDATE`
--

DROP TRIGGER /*!50030 IF EXISTS */ `topicAFTERUPDATE`;

DELIMITER $$

CREATE DEFINER = `root`@`localhost` TRIGGER `topicAFTERUPDATE` AFTER UPDATE ON `topic` FOR EACH ROW INSERT INTO `log` (eventdate, login, `action`, tablename, descript)
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
    ) $$

DELIMITER ;

--
-- Definition of trigger `topicAFTERDELETE`
--

DROP TRIGGER /*!50030 IF EXISTS */ `topicAFTERDELETE`;

DELIMITER $$

CREATE DEFINER = `root`@`localhost` TRIGGER `topicAFTERDELETE` AFTER DELETE ON `topic` FOR EACH ROW INSERT INTO `log` (eventdate, login, `action`, tablename, descript)
    VALUES (NOW(), (SELECT login FROM `session` WHERE `session` = CONNECTION_ID()), 'DELETE', 'topic',
    CONCAT('classnum: "', OLD.classnum, '"; type: "', OLD.`type`, '"; topicnum: "', OLD.topicnum, 
      '"; title: "', OLD.title, '"; content: "', OLD.content, '"; hidden: "', OLD.hidden, '"')) $$

DELIMITER ;

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
