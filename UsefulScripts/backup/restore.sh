#!/bin/bash

file_backup=backup_emoncms_20140807_2152.zip

echo "Liberare la directory tmp"
sudo rm -r ./tmp/

unzip -n ${file_backup} -d ./tmp/


sudo /etc/init.d/rfm12piphp stop
sudo service  apache2 stop
sudo service  timestore stop


#  A MANO  sudo mysql -u root -p  emoncms < ./tmp/media/temp_backEmoncms/mysqldump/emoncms_backup.sql
#  A MANO  sudo mysql -u root -p emoncms < ./tmp/media/temp_backEmoncms/mysqldump/emoncms_backup2.sql

sudo mv /var/lib/mysql/emoncms/ /var/lib/mysql/OLD_emoncms/
sudo mkdir /var/lib/mysql/emoncms/
sudo chown mysql:mysql /var/lib/mysql/emoncms/
sudo chmod u+rwx /var/lib/mysql/emoncms/


sudo cp -Rp ./tmp/media/temp_backEmoncms/varlib/emoncms/emoncms/ /var/lib/mysql/emoncms/
sudo chown mysql:mysql /var/lib/mysql/emoncms/


sudo cp -Rp  ./tmp/media/temp_backEmoncms/varlib/phpfina/phpfina/ /var/lib/phpfina/ 

sudo cp -Rp  ./tmp/media/temp_backEmoncms/varlib/phpfiwa/phpfiwa/ /var/lib/phpfiwa/ 

sudo cp -Rp  ./tmp/media/temp_backEmoncms/varlib/phptimeseries/phptimeseries/ /var/lib/phptimeseries/ 

sudo cp -Rp  ./tmp/media/temp_backEmoncms/varlib/timestore/timestore/ /var/lib/timestore/ 

sudo chown root:root /var/lib/timestore/



# NO sudo cp -Rp ./tmp/emoncms/emoncms/www/  /var/www/emoncms/ ./tmp/emoncms/emoncms/www/

sudo service apache2 start

#sudo php backup.php
# A MANO   sudo mysql -u root -p  emoncms < ./tmp/media/temp_backEmoncms/emoncms_backup.sql


sudo service timestore start
sudo /etc/init.d/rfm12piphp start


exit 0




# If you cannot see any of your data in the new installation:
# 1) try clearing your browser cache 
# 2) if you where using timestore to store your feed data check that the adminkey is entered correctly in settings.php 
# 3) if you already have redis installed, try reseting redis with:
#     $ redsi-cli and then: flushall
