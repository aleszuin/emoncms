#!/bin/bash

anno=$(date +"%G")
mese=$(date +"%m")
giorno=$(date +"%d")
ora=$(date +"%H")
minuto=$(date +"%M")

nome_zip=backup_emoncms_${anno}${mese}${giorno}_${ora}${minuto}.zip


sudo /etc/init.d/rfm12piphp stop
sudo service  apache2 stop
sudo service  timestore stop

sudo mkdir /media/temp_backEmoncms/
sudo chmod ugo+rwx /media/temp_backEmoncms/

sudo mkdir /media/temp_backEmoncms/mysqldump/
sudo chmod ugo+rwx /media/temp_backEmoncms/mysqldump/


sudo mysqldump -u root -p emoncms > /media/temp_backEmoncms/mysqldump/emoncms_backup.sql

sudo mysqldump -u root -p emoncms users input feeds dashboard multigraph > /media/temp_backEmoncms/mysqldump/emoncms_backup2.sql

sudo service  mysql stop

mkdir /media/temp_backEmoncms/varlib/
chmod ugo+rwx /media/temp_backEmoncms/varlib/

mkdir /media/temp_backEmoncms/varlib/emoncms/
chmod ugo+rwx /media/temp_backEmoncms/varlib/emoncms/

sudo cp -Rp /var/lib/mysql/emoncms/ /media/temp_backEmoncms/varlib/emoncms/


mkdir /media/temp_backEmoncms/varlib/phpfiwa/
chmod ugo+rwx /media/temp_backEmoncms/varlib/phpfiwa/

sudo cp -Rp  /var/lib/phpfiwa/ /media/temp_backEmoncms/varlib/phpfiwa/

mkdir /media/temp_backEmoncms/varlib/phpfina/
chmod ugo+rwx /media/temp_backEmoncms/varlib/phpfina/

sudo cp -Rp  /var/lib/phpfina/ /media/temp_backEmoncms/varlib/phpfina/


mkdir /media/temp_backEmoncms/varlib/phptimeseries/
chmod ugo+rwx /media/temp_backEmoncms/varlib/phptimeseries/

sudo cp -Rp  /var/lib/phptimeseries/ /media/temp_backEmoncms/varlib/phptimeseries/


mkdir /media/temp_backEmoncms/varlib/timestore/
chmod ugo+rwx /media/temp_backEmoncms/varlib/timestore/

sudo cp -Rp  /var/lib/timestore/ /media/temp_backEmoncms/varlib/timestore/


mkdir /media/temp_backEmoncms/emoncmsdata/
chmod ugo+rwx /media/temp_backEmoncms/emoncmsdata/

sudo cp -Rp  /data/emoncmsdata/ /media/temp_backEmoncms/emoncmsdata/


mkdir /media/temp_backEmoncms/varwww/
chmod ugo+rwx /media/temp_backEmoncms/varwww/

sudo cp -Rp /var/www/emoncms/ /media/temp_backEmoncms/varwww/


mkdir /media/temp_backEmoncms/php/
chmod ugo+rwx /media/temp_backEmoncms/php/

crontab -l > /media/temp_backEmoncms/crontab.txt

sudo service apache2 start

sudo php backup.php

mv /var/www/emoncms/00* /media/temp_backEmoncms/php/

sudo service timestore start
sudo /etc/init.d/rfm12piphp start

sudo zip -r ${nome_zip} /media/temp_backEmoncms/

exit 0

