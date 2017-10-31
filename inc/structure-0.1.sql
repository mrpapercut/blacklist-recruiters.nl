CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `companyname` varchar(256) NOT NULL,
  `allowed` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `company_id` int(10) NOT NULL,
  `name` varchar(256) NOT NULL,
  `report` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `allowed` tinyint(1) NOT NULL,
  `hash` varchar(128) NOT NULL,
  `mailtoken` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `reports` ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);