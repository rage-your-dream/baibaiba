DELIMITER $$

USE `redmine`$$

DROP PROCEDURE IF EXISTS `selectBugAssignDate`$$

CREATE DEFINER=`redmine`@`10.6.196.100` PROCEDURE `selectBugAssignDate`(IN fromDate VARCHAR(16))
BEGIN
/*
* 查询指定日期的bug数据，放入零时表，调用后删除临时表tem_bug提高效率
*/
DROP TEMPORARY TABLE IF EXISTS tem_bug;
CREATE TEMPORARY  TABLE tem_bug
SELECT 
    ProjectID, 
    proj.`name` AS ParentName, 
    projBug.Project AS ProjectName,
    BugID, 
    BugSubject, 
    projBug.Essentiality AS Essentiality, 
    StatusId,
    CreateTime, 
    UpdateTime, 
    CloseTime, 
    CONCAT(LastName ,FirstName) AS AuthorName,
    CONCAT(assLastName ,assFirstName) AS AssignName
FROM projects AS proj JOIN
    (
        SELECT p.NAME AS Project , cv.`value` AS Essentiality , p.parent_id AS ParentId, i.status_id AS StatusId, i.created_on AS CreateTime,
        i.closed_on AS CloseTime, i.updated_on AS UpdateTime, p.id AS ProjectID, u.firstname AS FirstName, u.lastname AS LastName,uass.firstname AS assFirstName, uass.lastname AS assLastName,
        i.id AS BugID,i.`subject` AS BugSubject
        FROM issues AS i, users AS u,users AS uass, projects AS p, custom_values AS cv,
            (   -- 取出“技术中心-测试组-测试项目”下的所有项目，一共三级
                SELECT id FROM projects 
                -- WHERE parent_id = 72 AND STATUS = 1
                -- UNION
                -- SELECT p1.id AS id FROM projects p1 JOIN projects p2 ON p1.parent_id = p2.id WHERE p2.parent_id = 72 AND p1.STATUS = 1
            ) pid
        WHERE 1 = 1 
    -- and i.created_on > \'%s\' and i.created_on < \'%s\'
    AND i.created_on > fromDate -- '2013-01-01' -- DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
    AND i.status_id IN (1,2,5,8,9,22)
    AND i.project_id = p.id AND i.author_id = u.id AND i.assigned_to_id = uass.id AND i.id = cv.customized_id AND cv.custom_field_id=1
    AND p.id = pid.id
 
    ) AS projBug
 ON proj.id = projBug.ParentId
 ORDER BY parentName, projectName, Essentiality;
    END$$

DELIMITER ;