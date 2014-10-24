<?php
/*
 * Created on 2014-5-9
 * 存储各种内部系统账号配置或用户名，密码
 * 切记此文件不能提交到GIT上
 */
 #数据库配置
 define("DB_DSN_SVN","mysql:host=10.1.11.63;dbname=svn");
 define("DB_DSN_PMS","mysql:host=10.1.11.63;dbname=pms");
 define("DB_DSN_SHOW","mysql:host=10.1.11.63;dbname=showdb");
 define("DB_DSN_REDMINE","mysql:host=10.59.94.100:3301;dbname=redmine");
 define("DB_DSN_MOBO_JIRA","mysql:host=10.1.11.68:4040;dbname=jira");
 define("DB_MOBO_JIRA_USERNAME","17173_jira_user");
 define("DB_MOBO_JIRA_PASSWORD","17173_jira_user@cyou-inc.com"); 
 
 define("DB_USERNAME","mysqladmin");
 define("DB_PASSWORD","123465");
 #SVN配置
 define("SVN_USERNAME_BEIJING","testgroupbj");
 define("SVN_PASSWORD_BEIJING","123qwe!@#");
 define("SVN_USERNAME_FUZHOU","testgroup");
 define("SVN_PASSWORD_FUZHOU","vF98fkeNKzQKsq");
 #邮件配置
 define("MAIL_HOST","10.59.95.5");
 define("MAIL_HOST_PORT",25);
 define("MAIL_FROM","zhangchengtao@cyou-inc.com");//17173-QA@17173-inc.com
 
 #LDAP设置参数
 define("LDAP_HOST","10.6.125.11");
 define("LDAP_PORT",389);
 define("LDAP_DN","CN=MRDSCM,OU=Users,OU=Managed,DC=cyou-inc,DC=com");
 define("LDAP_PSW","mrdscmdmmbzk");
 #MD5 公钥
 define("MD5_KEY","cuiyue");
 
?>
