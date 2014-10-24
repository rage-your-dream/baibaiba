USE `showdb`;

CREATE TABLE `sys_log_description_trans` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `description` VARCHAR(128) DEFAULT NULL,
  `transname` VARCHAR(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/* 初始化数据 */
INSERT INTO `sys_log_description_trans` (`description`, `transname`) 
VALUES
  ('post.php?target=mobo_confluence', 'Confluence'),
  ('http://oa.it.mobogarden.com/jira', 'Jira'),
  ('http://oa.it.mobogarden.com/AppsAngle/index.php?app_name=Mobogenie', 'Mobo二维码'),
  ('http://hudson.it.mobogarden.com', 'Hudson'),
  ('http://oa.it.mobogarden.com/testlink', 'Testlink'),
  ('http://confluence.oversea.mobogarden.com:8090','Cunfl海外'),
  ('home.php','首页'),
  ('dashboard.php?id=2', 'dashboard') ;