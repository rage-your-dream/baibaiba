USE `showdb`;

CREATE TABLE `sys_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `event` varchar(16) DEFAULT NULL,
  `page` varchar(32) DEFAULT NULL,
  `description` varchar(128) DEFAULT NULL,
  `username` varchar(32) DEFAULT NULL,
  `ip` varchar(16) DEFAULT NULL,
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1151 DEFAULT CHARSET=utf8;
