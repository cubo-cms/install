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

--
-- Table `article`
--

DROP TABLE IF EXISTS `article`;

CREATE TABLE `article` (
  `#` int(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `@attribute` text,
  `accesslevel` int(20) DEFAULT NULL,
  `author` int(20) DEFAULT NULL,
  `body` longtext,
  `category` int(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `description` text,
  `editor` int(20) DEFAULT NULL,
  `image` int(20) DEFAULT NULL,
  `intro` longtext,
  `language` int(20) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `published` datetime DEFAULT NULL,
  `publisher` int(20) DEFAULT NULL,
  `rating` varchar(100) DEFAULT NULL,
  `status` int(20) DEFAULT NULL,
  `tags` text,
  `template` int(20) DEFAULT NULL,
  `title` text,
  `visits` int(20) DEFAULT NULL,
  PRIMARY KEY (`#`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Article';

INSERT INTO `article` VALUES (1,'home',NULL,1,1,'<p>Welcome to the home page.</p>',1,NOW(),'This is the home page',NULL,NULL,'<p>There is no place like home.</p>',1,NULL,NOW(),1,NULL,1,NULL,NULL,'Home',0);
INSERT INTO `article` VALUES (2,'login',NULL,3,1,'<cubo:module name=\"login\" content=\"\" />',1,NOW(),'This is the login page',NULL,NULL,'<p>Please provide your user name and password</p>',1,NULL,NOW(),1,NULL,1,NULL,1,'User Login',0);

ALTER TABLE `article` AUTO_INCREMENT = 1001, CHANGE COLUMN `#` `#` INT(20) NOT NULL AUTO_INCREMENT;

--
-- Table `category`
--

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `#` int(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `@attribute` text,
  `accesslevel` int(20) DEFAULT NULL,
  `author` int(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `description` text,
  `editor` int(20) DEFAULT NULL,
  `html` longtext,
  `image` int(20) DEFAULT NULL,
  `language` int(20) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `parent` int(20) DEFAULT NULL,
  `published` datetime DEFAULT NULL,
  `publisher` int(20) DEFAULT NULL,
  `status` int(20) DEFAULT NULL,
  `tags` text,
  `title` text,
  PRIMARY KEY (`#`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Category';

INSERT INTO `category` VALUES (0,'none',NULL,0,1,NOW(),'Root category',NULL,NULL,NULL,1,NULL,NULL,NOW(),1,1,NULL,'None');
INSERT INTO `category` VALUES (1,'undefined',NULL,4,1,NOW(),'Undefined category',NULL,NULL,NULL,1,NULL,NULL,NOW(),1,1,NULL,'Undefined');

ALTER TABLE `category` AUTO_INCREMENT = 1001, CHANGE COLUMN `#` `#` INT(20) NOT NULL AUTO_INCREMENT;

--
-- Table `contact`
--

DROP TABLE IF EXISTS `category`;

CREATE TABLE `contact` (
  `#` int(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `@attribute` text,
  `accesslevel` int(20) DEFAULT NULL,
  `author` int(20) DEFAULT NULL,
  `body` longtext,
  `category` int(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `description` text,
  `displayname` varchar(100) DEFAULT NULL,
  `editor` int(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `image` int(20) DEFAULT NULL,
  `language` int(20) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `organisation` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `published` datetime DEFAULT NULL,
  `publisher` int(20) DEFAULT NULL,
  `rating` varchar(100) DEFAULT NULL,
  `status` int(20) DEFAULT NULL,
  `tags` text,
  `title` text,
  `visits` int(20) DEFAULT NULL,
  PRIMARY KEY (`#`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Contact';

INSERT INTO `contact` VALUES (1,'system',NULL,4,1,NULL,1,NOW(),'System account','Cubo CMS',NULL,NULL,NULL,1,1,NULL,NULL,'Cubo CMS',NULL,NOW(),1,NULL,1,NULL,'Cubo CMS',0);
INSERT INTO `contact` VALUES (2,'admin',NULL,4,1,NULL,1,NOW(),'Administrator account','Administrator',NULL,NULL,NULL,1,1,NULL,NULL,'Cubo CMS',NULL,NOW(),1,NULL,1,NULL,'Administrator',0);

ALTER TABLE `contact` AUTO_INCREMENT = 1001, CHANGE COLUMN `#` `#` INT(20) NOT NULL AUTO_INCREMENT;
