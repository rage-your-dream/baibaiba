DELIMITER $$

USE `redmine`$$

DROP PROCEDURE IF EXISTS `selectNewBugLW`$$

CREATE DEFINER=`redmine`@`10.6.196.100` PROCEDURE `selectNewBugLW`()
BEGIN
CALL selectBugAssignDate(SUBDATE(CURDATE(),DATE_FORMAT(CURDATE(),'%w')-1));
SELECT ProjectName AS `name`,COUNT(ProjectName) AS `data` FROM tem_bug WHERE CreateTime > SUBDATE(CURDATE(),DATE_FORMAT(CURDATE(),'%w')-1) GROUP BY ProjectName;
DROP TEMPORARY TABLE tem_bug;
    END$$

DELIMITER ;