## How to setup a raspberrypi running emonhub + emoncms

This guide details how to setup a raspberry pi basestation that can be used to either forward data to a remote server or record data locally or both.

![System diagram](files/emonpi_sys_diag.png)

Download the official raspberrpi raspbian image and write to the SD card.

    [http://www.raspberrypi.org/downloads](http://www.raspberrypi.org/downloads)
    
To upload the image using dd on linux 

Check the mount location of the SD card using:

    df -h
    
Unmount any mounted SD card partitions
    
    umount /dev/sdb1
    umount /dev/sdb2
    
Write the raspbian image to the SD card (Make sure of=/dev/sdb is the correct location)
    
    sudo dd bs=4M if=2014-01-07-wheezy-raspbian.img of=/dev/sdb
    
**Open the SD Card in GParted and format the unallocated 899 MiB disk space as a FAT16 Drive** 

Insert the SD card into the raspberrypi and power the pi up.

Find the IP address of your raspberrypi on your network then connect and login to your pi with SSH, for windows users there's a nice tool called [putty](http://www.putty.org/) which you can use to do this. To connect via ssh on linux, type the following in terminal:

    ssh pi@YOUR_PI_IP_ADDRESS

It will then prompt you for a username and password which are: **username:**pi, **password:**raspberry.

### Setup Data partition

Steps for creating 3rd partition for data using fdisk and mkfs:

    sudo fdisk -l
    Note end of last partition (5785599 on standard sd card)
    sudo fdisk /dev/mmcblk0
    enter: n->p->3
    enter: 5785600
    enter: default or 7626751
    enter: w (write partition to disk)
    fails with error, will write at reboot
    sudo reboot
    
    On reboot, login and run:
    sudo mkfs.ext2 -b 1024 /dev/mmcblk0p3
    
**Note:** We create here an ext2 filesystem with a blocksize of 1024 bytes instead of the default 4096 bytes. A lower block size results in significant write load reduction when using an application like emoncms that only makes small but frequent and across many files updates to disk. Ext2 is choosen because it supports multiple linux user ownership options which are needed for the mysql data folder. Ext2 is non-journaling which reduces the write load a little although it may make data recovery harder vs Ext4, The data disk size is small however and the downtime from running fsck is perhaps less critical.
    
Now that your loged in to your pi, the first step is to edit the _inittab_ and _boot cmdline config_ file to allow the python gateway which we will install next to use the serial port, type:

    sudo nano /etc/inittab

At the bottom of the file comment out the line, by adding a ‘#’ at beginning:

    # T0:23:respawn:/sbin/getty -L ttyAMA0 115200 vt100

[Ctrl+X] then [y] then [Enter] to save and exit

Edit boot cmdline.txt

    sudo nano /boot/cmdline.txt

replace the line:

    dwc_otg.lpm_enable=0 console=ttyAMA0,115200 kgdboc=ttyAMA0,115200 console=tty1 
    root=/dev/mmcblk0p2 rootfstype=ext4 elevator=deadline rootwait

with:

    dwc_otg.lpm_enable=0 console=tty1 root=/dev/mmcblk0p2 rootfstype=ext4 elevator=deadline rootwait
    
Create a directory that will be a mount point for the rw data partition

    mkdir /home/pi/data

    
## Read only mode

Configure Raspbian to run in read-only mode for increased stability (optional but recommended)

The following is copied from: 
http://emonhub.org/documentation/install/raspberrypi/sd-card/

Then run these commands to make changes to filesystem

    sudo cp /etc/default/rcS /etc/default/rcS.orig
    sudo sh -c "echo 'RAMTMP=yes' >> /etc/default/rcS"
    sudo mv /etc/fstab /etc/fstab.orig
    sudo sh -c "echo 'tmpfs           /tmp            tmpfs   nodev,nosuid,size=30M,mode=1777       0    0' >> /etc/fstab"
    sudo sh -c "echo 'tmpfs           /var/log        tmpfs   nodev,nosuid,size=30M,mode=1777       0    0' >> /etc/fstab"
    sudo sh -c "echo 'proc            /proc           proc    defaults                              0    0' >> /etc/fstab"
    sudo sh -c "echo '/dev/mmcblk0p1  /boot           vfat    defaults                              0    2' >> /etc/fstab"
    sudo sh -c "echo '/dev/mmcblk0p2  /               ext4    defaults,ro,noatime,errors=remount-ro 0    1' >> /etc/fstab"
    sudo sh -c "echo '/dev/mmcblk0p3  /home/pi/data   ext2    defaults,rw,noatime                   0    2' >> /etc/fstab"
    sudo sh -c "echo ' ' >> /etc/fstab"
    sudo mv /etc/mtab /etc/mtab.orig
    sudo ln -s /proc/self/mounts /etc/mtab
    
The Pi will now run in Read-Only mode from the next restart.

Before restarting create two shortcut commands to switch between read-only and write access modes.

Firstly “ rpi-rw “ will be the command to unlock the filesystem for editing, run

    sudo nano /usr/bin/rpi-rw

and add the following to the blank file that opens

    #!/bin/sh
    sudo mount -o remount,rw /dev/mmcblk0p2  /
    echo "Filesystem is unlocked - Write access"
    echo "type ' rpi-ro ' to lock"

save and exit using ctrl-x -> y -> enter and then to make this executable run

    sudo chmod +x  /usr/bin/rpi-rw

Next “ rpi-ro “ will be the command to lock the filesytem down again, run

    sudo nano /usr/bin/rpi-ro

and add the following to the blank file that opens

    #!/bin/sh
    sudo mount -o remount,ro /dev/mmcblk0p2  /
    echo "Filesystem is locked - Read Only access"
    echo "type ' rpi-rw ' to unlock"

save and exit using ctrl-x -> y -> enter and then to make this executable run

    sudo chmod +x  /usr/bin/rpi-ro

Lastly reboot for changes to take effect

    sudo shutdown -r now
    
Login again, change data partition permissions:
    
    sudo chmod -R a+w data
    sudo chown -R pi data
    sudo chgrp -R pi data

### Install dependencies

Update the rasbian repositories with:

    rpi-rw

    sudo apt-get update

Install all dependencies:
There are a few extra things in here such as mosquitto (MQTT) which is not currently used but may be soon.

    sudo apt-get install apache2 mysql-server mysql-client php5 libapache2-mod-php5 php5-mysql php5-curl php-pear php5-dev php5-mcrypt git-core redis-server build-essential ufw ntp python-serial python-configobj mosquitto mosquitto-clients python-pip python-dev screen iostat minicom

Install python pip dependencies

    sudo pip install tendo      (not used atm)
    sudo pip install mosquitto  (not used atm)
    sudo pip install redis      (not used atm)
    sudo pip install web.py     (not used atm)

Install pecl dependencies (redis and swift mailer)

    sudo pear channel-discover pear.swiftmailer.org
    sudo pecl install redis swift/swift
    
Add pecl modules to php5 config

    sudo sh -c 'echo "extension=redis.so" > /etc/php5/apache2/conf.d/20-redis.ini'
    sudo sh -c 'echo "extension=redis.so" > /etc/php5/cli/conf.d/20-redis.ini'
    
Configure redis to run without logging or data persistance.

    sudo nano /etc/redis/redis.conf

comment out redis log file

    # logfile /var/log/redis/redis-server.log

comment out all redis saving

    # save 900 1
    # save 300 10
    # save 60 10000
    
    sudo /etc/init.d/redis-server start

Emoncms uses a front controller to route requests, modrewrite needs to be configured:

    $ sudo a2enmod rewrite
    $ sudo nano /etc/apache2/sites-enabled/000-default

Change (line 7 and line 11), "AllowOverride None" to "AllowOverride All".
That is the sections <Directory /> and <Directory /var/www/>.
[Ctrl + X ] then [Y] then [Enter] to Save and exit.

Restart the lamp server:

    $ sudo /etc/init.d/apache2 restart

Change apache2 log directory:
    sudo nano /etc/apache2/envvars    
    export APACHE_LOG_DIR=/var/log$SUFFIX (remove the apache2 bit)

Mysql:
    mkdir /home/pi/data/mysql
    sudo cp -rp /var/lib/mysql/. /home/pi/data/mysql
    
    sudo nano /etc/mysql/my.cnf
    change line datadir to /home/pi/data/mysql
    
PHP5 Sessions:
    sudo nano /etc/php5/apache2/php.ini
    
Find line:
; session.save_path = "/var/lib/php5"

change to:
session.save_path = "/tmp"


### Security

[http://blog.al4.co.nz/2011/05/setting-up-a-secure-ubuntu-lamp-server/](http://blog.al4.co.nz/2011/05/setting-up-a-secure-ubuntu-lamp-server/)

#### Install ufw

ufw: uncomplicated firewall, is a great little firewall program that you can use to control your server access rules. The default set below are fairly standard for a web server but are quite permissive. You may want to only allow connection on a certain ip if you will always be accessing your pi from a fixed ip.

UFW Documentation
[https://help.ubuntu.com/community/UFW](https://help.ubuntu.com/community/UFW)

    sudo ufw allow 80/tcp
    sudo ufw allow 443/tcp
    sudo ufw allow 22/tcp
    sudo ufw enable

#### Change root password

Set root password

    sudo passwd root

The default root password used in the ready to go image is **raspberry**. 
Change this to a hard to guess password to make your root account secure.

#### Secure MySQL

Run mysql_secure_installation see [mysql docs](http://dev.mysql.com/doc/refman/5.0/en/mysql-secure-installation.html)

    mysql_secure_installation

#### Secure SSH

Disable root login:

    sudo nano /etc/ssh/sshd_config

Set **PermitRootLogin** to **no**

### Apache access logs

Comment the access log to other-vhosts (add #)

    sudo nano /etc/apache2/conf.d/other-vhosts-access-log
    
### Reboot the pi

    sudo reboot

### Install the emoncms application via git

Git is a source code management and revision control system but at this stage we use it to just download and update the emoncms application.

First cd into the var directory:

    $ cd /var/

Set the permissions of the www directory to be owned by your username:

    $ sudo chown pi www

Cd into www directory

    $ cd www

Download emoncms using git:

    $ git clone -b bufferedwrite https://github.com/emoncms/emoncms.git
    
Once installed you can pull in updates with:

    git pull
    
### Create a MYSQL database

    $ mysql -u root -p

Enter the mysql password that you set above.
Then enter the sql to create a database:

    mysql> CREATE DATABASE emoncms;

Exit mysql by:

    mysql> exit
    
### Create data repositories for emoncms feed engine's

    sudo mkdir /home/pi/data/phpfina
    sudo mkdir /home/pi/data/phptimeseries

    sudo chown www-data:root /home/pi/data/phpfina
    sudo chown www-data:root /home/pi/data/phptimeseries

### Set emoncms database settings.

cd into the emoncms directory where the settings file is located

    $ cd /var/www/emoncms/

Make a copy of default.settings.php and call it settings.php

    $ cp default.settings.php settings.php

Open settings.php in an editor:

    $ nano settings.php

Enter in your database settings.

    $username = "USERNAME";
    $password = "PASSWORD";
    $server   = "localhost";
    $database = "emoncms";

Save (Ctrl-X), type Y and exit

Move the writer script to home folder

    mv /var/www/emoncms/run/feedwriter.php /home/pi
    
## Install emonhub

    cd /home/pi
    
    git clone https://github.com/emonhub/emonhub.git
    
    nano /home/pi/emonhub/conf/emonhub.conf
    
    remove dispatchers that you dont need, add local emoncms apikey, set radio settings
    
    rpi-ro
    
    screen
    sudo python src/emonhub.py --config-file conf/emonhub.conf
    ctrl a+d to exit
    
    screen
    sudo php feedwriter.php
    ctrl a+d to exit
    
    Monitor disk load with sysstat:
    
    sudo iostat 60 (will give you 1 minuite disk load average, note kb_wrtn/s value)
    