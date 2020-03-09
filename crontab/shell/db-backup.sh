#!/bin/bash
/usr/local/mysql/bin/mysqldump -uuser -ppasswd databasename > /home/wwwroot/backup/date_$(date'+%Y%m%d').sql

# 修改权限并执行备份脚本
chmod +x dbbackup.shsh dbbackup.sh

# crontab -e 设置执行时间
56 23 * * * /root/dbbackup.sh