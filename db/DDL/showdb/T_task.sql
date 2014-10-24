USE `showdb`;

CREATE TABLE `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `ower_name` varchar(45) DEFAULT NULL,
  `ower_num` varchar(45) DEFAULT NULL,
  `target` varchar(255) DEFAULT NULL,
  `checklist` varchar(255) DEFAULT NULL,
  `status` varchar(10) DEFAULT 'ready',
  `lover` int(11) DEFAULT NULL,
  `comments_id` int(11) DEFAULT NULL,
  `receive_datetime` datetime DEFAULT NULL,
  `finish_datetime` datetime DEFAULT NULL,
  `plan_hour` int(11) DEFAULT NULL,
  `sprint_num` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
