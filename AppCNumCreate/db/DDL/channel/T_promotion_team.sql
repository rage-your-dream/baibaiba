USE `channel`;

CREATE TABLE `promotion_team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `promotion_number` char(2) DEFAULT NULL,
  `team_name` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


/* 初始化数据 */
INSERT INTO `promotion_team` (`promotion_number`,`team_name`) 
VALUES
  (10, '印度'),
  (11, '马来'),
  (12, '国内'),
  (15, 'Webgame'),
  (16, '北美'),
  (17, '越南'),
  (18, '印尼'),
  (19, '巴西'),
  (20, '泰国'),
  (21, '中东'),
  (22, '墨西哥'),
  (23, '俄罗斯'),
  (24, '菲律宾') ;
