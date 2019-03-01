--
-- Table `accesslevel`
--

DROP TABLE IF EXISTS `accesslevel`;

CREATE TABLE `accesslevel` (
  `#` int(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `accesslevel` int(20) DEFAULT NULL,
  `author` int(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `description` text,
  `editor` int(20) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `published` datetime DEFAULT NULL,
  `publisher` int(20) DEFAULT NULL,
  `status` int(20) DEFAULT NULL,
  `title` text,
  PRIMARY KEY (`#`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Access Level';

INSERT INTO `accesslevel` VALUES (0,'none',0,1,NOW(),'Nobody can access',NULL,NULL,NOW(),1,1,'None');
INSERT INTO `accesslevel` VALUES (1,'public',4,1,NOW(),'Everyone can access',NULL,NULL,NOW(),1,1,'Public');
INSERT INTO `accesslevel` VALUES (2,'registered',4,1,NOW(),'Users who have logged in can access',NULL,NULL,NOW(),1,1,'Registered');
INSERT INTO `accesslevel` VALUES (3,'guest',4,1,NOW(),'Users who have not logged in can access',NULL,NULL,NOW(),1,1,'Guest');
INSERT INTO `accesslevel` VALUES (4,'private',4,1,NOW(),'Users who know how to reach the item can access',NULL,NULL,NOW(),1,1,'Private');
INSERT INTO `accesslevel` VALUES (5,'admin',4,1,NOW(),'Only content managers can access',NULL,NULL,NOW(),1,1,'Admin');

ALTER TABLE `accesslevel` AUTO_INCREMENT = 1001, CHANGE COLUMN `#` `#` INT(20) NOT NULL AUTO_INCREMENT;
