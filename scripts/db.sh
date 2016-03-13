#!/bin/bash

db_user='root'
echo "Digite a senha do mysql (usuário "$db_user"): "
read -s db_pwd
echo "Processando..."
if [ ! -z $1 ] && [ $1 == "reload" ]; then
  mysql -u $db_user -p$db_pwd < db/mysql.sql
  echo "OK"
fi
