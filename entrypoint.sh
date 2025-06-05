#!/bin/bash
service mariadb start

ADMIN_PASSWORD=$(openssl rand -base64 12)

HASH=$(php -r "echo password_hash('$ADMIN_PASSWORD', PASSWORD_DEFAULT);")

mysql -u root -e "CREATE DATABASE IF NOT EXISTS webapp;"
mysql -u root -e "CREATE USER IF NOT EXISTS 'webuser'@'%' IDENTIFIED BY 'webpassword';"
mysql -u root -e "GRANT ALL PRIVILEGES ON webapp.* TO 'webuser'@'%';"
mysql -u root -e "FLUSH PRIVILEGES;"

mysql -u root webapp < /docker-entrypoint-initdb.d/database.sql

mysql -u root -e "INSERT INTO webapp.users (id, username, password, secret, avatar, role) VALUES (1337, 'admin', '$HASH', '$ADMIN_PASSWORD', 'https://hackerlab.pro/game_api/images/avatars/4f7d8c97-12c1-4930-90f5-34d40b4d8526.webp?1745843705237&amp;w=256&amp;q=75', 'admin');"

apache2-foreground
