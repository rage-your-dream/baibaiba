DELIMITER $$

USE `redmine`$$

DROP PROCEDURE IF EXISTS `selectWeekBugTrend`$$

CREATE DEFINER=`redmine`@`10.6.196.100` PROCEDURE `selectWeekBugTrend`()
BEGIN
CALL selectBugAssignDate(SUBDATE(CURDATE(),DATE_FORMAT(CURDATE(),'%w')-1));
SELECT  
CASE DAYOFWEEK(CreateTime) WHEN 1 THEN 6 WHEN 2 THEN 0 WHEN 3 THEN 1 WHEN 4 THEN 2 WHEN 5 THEN 3 WHEN 6 THEN 4 WHEN 7 THEN 5 END AS `weekday`,
ProjectName AS `name`,
COUNT(ProjectName) AS `count` 
FROM tem_bug 
WHERE StatusId IN(1,2,5,8,9,22) 
AND CreateTime > SUBDATE(CURDATE(),DATE_FORMAT(CURDATE(),'%w')-1) 
GROUP BY `weekday`,ProjectName;
DROP TEMPORARY TABLE tem_bug;
    END$$

DELIMITER ;