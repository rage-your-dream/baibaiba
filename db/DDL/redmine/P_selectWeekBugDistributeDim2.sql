DELIMITER $$

USE `redmine`$$

DROP PROCEDURE IF EXISTS `selectWeekBugDistributeDim2`$$

CREATE DEFINER=`redmine`@`10.6.196.100` PROCEDURE `selectWeekBugDistributeDim2`()
BEGIN
CALL selectBugAssignDate(SUBDATE(CURDATE(),DATE_FORMAT(CURDATE(),'%w')-1));
CREATE TEMPORARY  TABLE tem_bug1
SELECT AssignName AS`name`,
COUNT(BugID) AS `y`,
CASE StatusId WHEN 1 THEN '#42A07B' WHEN 2 THEN '#9B5E4A' WHEN 5 THEN '#514F78' WHEN 8 THEN '#514F78' WHEN 9 THEN '#514F78' WHEN 22 THEN '#1F949A' END AS `color` 
FROM tem_bug 
WHERE StatusId IN(1,2,5,8,9,22) 
AND CreateTime > SUBDATE(CURDATE(),DATE_FORMAT(CURDATE(),'%w')-1) 
GROUP BY `name`,color 
ORDER BY StatusId;
SELECT CONCAT(a.`name`,":",a.`y`,"个") AS `name` ,`y`,a.`color`  FROM tem_bug1 a;
DROP TEMPORARY TABLE IF EXISTS tem_bug1;
DROP TEMPORARY TABLE IF EXISTS tem_bug;
    END$$

DELIMITER ;