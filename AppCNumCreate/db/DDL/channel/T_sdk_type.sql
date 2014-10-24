USE `channel`;

CREATE TABLE `sdk_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sdk_number` char(1) DEFAULT NULL,
  `type_name` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/* 初始化数据 */
INSERT INTO `sdk_type` (`sdk_number`, `type_name`) 
VALUES
  ('0', '无SDK'),
  ('1', '有SDK'),
  ('2', '有AppsFlyerSDK') ;
  