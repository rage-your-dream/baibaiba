DELIMITER $$

USE `redmine`$$

DROP PROCEDURE IF EXISTS `selectWeekBugTable`$$

CREATE DEFINER=`redmine`@`10.6.196.100` PROCEDURE `selectWeekBugTable`()
BEGIN
  SELECT 
    pro.NAME,
    COUNT(a.project_id) AS `count1`,
    b.`count2` 
  FROM
    issues a 
    LEFT JOIN
    (SELECT 
      project_id AS `name`,
      COUNT(project_id) AS `count2` 
    FROM
      issues 
    WHERE status_id IN (1, 2, 9, 22) 
      AND created_on > SUBDATE(
        CURDATE(),
        DATE_FORMAT(CURDATE(), '%w') - 1
      ) 
      AND assigned_to_id IS NOT NULL
    GROUP BY project_id) b 
    ON a.project_id = b.`name` 
    LEFT JOIN
    projects pro 
    ON a.project_id = pro.id 
  WHERE a.created_on > SUBDATE(
      CURDATE(),
      DATE_FORMAT(CURDATE(), '%w') - 1
    ) 
    AND a.status_id IN (1, 2, 5, 8, 9, 22) 
    AND a.assigned_to_id IS NOT NULL
  GROUP BY a.project_id ;
END$$

DELIMITER ;