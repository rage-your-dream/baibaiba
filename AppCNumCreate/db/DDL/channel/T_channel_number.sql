USE `channel`;

CREATE TABLE `channel_number` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `channel_number` char(9) DEFAULT NULL,
  `channel_name` varchar(32) DEFAULT NULL,
  `promotion_number` char(2) DEFAULT NULL,
  `payment_number` char(1) DEFAULT NULL,
  `cooperation_number` char(1) DEFAULT NULL,
  `version_number` char(1) DEFAULT NULL,
  `has_sdk` char(1) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `bd` varchar(32) DEFAULT NULL,
  `tail_number` char(4) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
