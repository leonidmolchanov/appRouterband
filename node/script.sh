#!/usr/local/bin/bash
DIR="/var/www/html/app/node" # ��� ва� ка�алог �о �к�ип�ом
nohup forever  "$DIR/rb8000.js" > "$DIR/server.out" 2>&1& # в�вод б�де� нап�авлен в �айл server.out
echo $! > server_pid # в �айл server_pid  б�де� запи�ан pid (�) ��п