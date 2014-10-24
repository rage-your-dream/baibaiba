USE `channel`;

CREATE TABLE `version_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version_number` char(1) DEFAULT NULL,
  `type_name` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/* 初始化数据 */
INSERT INTO `version_type` (`version_number`,`type_name`) 
VALUES
  ('0', 'PC：普通版'),
  ('1', 'PC：静默版'),
  ('2', 'PC：微端'),
  ('3', '手机：Lite版'),
  ('4', '手机：普通版'),
  ('5', '手机：活动版'),
  ('6', 'PC：重构版') ;
