USE `showdb`;

CREATE TABLE `widgit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `widgit_id` int(11) NOT NULL DEFAULT '0',
  `widgit_left` float DEFAULT '-1',
  `widgit_top` float DEFAULT '-1',
  `widgit_width` float DEFAULT '4',
  `widgit_height` float DEFAULT '0',
  `board_width` float DEFAULT '-1',
  `board_height` float DEFAULT '-1',
  `data_lock` int(11) DEFAULT '1',
  `chart_hide` int(11) DEFAULT '0',
  `panel_hide` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
