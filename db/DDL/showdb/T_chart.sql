USE `showdb`;

CREATE TABLE `chart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL DEFAULT 'line',
  `data` longtext NOT NULL,
  `dashboard_id` varchar(45) NOT NULL,
  `help_msg` longtext NOT NULL,
  `analysis_msg` longtext,
  `data_lock` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;
