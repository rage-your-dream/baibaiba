USE `channel`;

CREATE TABLE `cooperation_mode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cooperation_number` char(1) DEFAULT NULL,
  `cooperation_name` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


/* 初始化数据 */
INSERT INTO `cooperation_mode` (`cooperation_number`,`cooperation_name`)
VALUES
  (0, '线上广告'),
  (1, '线上网盟'),
  (2, '线下预装'),
  (3, '换量'),
  (4, '短信'),
  (5, '免费'),
  (6, '线下刷机') ;