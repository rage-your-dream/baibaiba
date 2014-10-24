DELIMITER $$

USE `redmine`$$

DROP PROCEDURE IF EXISTS `selectLeaveBugLW`$$

CREATE DEFINER=`redmine`@`10.6.196.100` PROCEDURE `selectLeaveBugLW`()
BEGIN
CALL selectBugAssignDate(SUBDATE(CURDATE(),DATE_FORMAT(CURDATE(),'%w')-1));
SELECT ProjectName AS `name`,COUNT(ProjectName) AS `data` FROM tem_bug WHERE CreateTime > SUBDATE(CURDATE(),DATE_FORMAT(CURDATE(),'%w')-1)  AND StatusId IN(1,2,9,22) GROUP BY ProjectName;
DROP TEMPORARY TABLE tem_bug;
    END$$

DELIMITER ;