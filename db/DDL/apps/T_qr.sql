USE `apps`;

CREATE TABLE `qr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_path` varchar(255) NOT NULL,
  `app_name` varchar(45) NOT NULL,
  `data` varchar(255) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=283 DEFAULT CHARSET=utf8 COMMENT='二维码信息';
