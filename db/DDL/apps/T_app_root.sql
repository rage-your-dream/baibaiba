USE `apps`;

CREATE TABLE `app_root` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_name` varchar(45) NOT NULL,
  `root_path` varchar(255) NOT NULL,
  `user_name` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `update_time` datetime NOT NULL,
  `isscanning` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `app_name_UNIQUE` (`app_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='每个应用的根目录在这里配置';
