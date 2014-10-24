USE `showdb`;

CREATE TABLE `panel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `class` varchar(45) DEFAULT NULL,
  `x` float NOT NULL DEFAULT '0.3',
  `y` float NOT NULL DEFAULT '3',
  `width` float NOT NULL DEFAULT '4',
  `height` float NOT NULL DEFAULT '-1',
  `data_lock` int(11) NOT NULL DEFAULT '1',
  `ishide` int(11) NOT NULL DEFAULT '0',
  `analysis_show` int(11) DEFAULT '0',
  `page_width` float DEFAULT NULL,
  `page_height` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
