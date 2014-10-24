USE `channel`;

CREATE TABLE `payment_method` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_number` char(1) DEFAULT NULL,
  `payment_name` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


/* 初始化数据 */
INSERT INTO `payment_method` (`payment_number`,`payment_name`) 
VALUES
  (0, 'CPM'),
  (1, 'CPC'),
  (2, 'CPI'),
  (3, 'CPA'),
  (4, '免费') ;
