#!/bin/bash
set -e

# Check execution privilege
if ! [ $(id -u) = 0 ]; then
    echo "Please run as root"
    exit 1
fi

# Prepare setup
export DEBIAN_FRONTEND=noninteractive

apt_install='apt-get install --yes'
apt_remove='apt-get remove --yes'
$apt_install apt-utils
$apt_install screen

# Setup LAMP server
$apt_install apache2
$apt_install mysql-server
$apt_install php5 php-pear php5-mysql php5-mcrypt libapache2-mod-php5 php5-json

service apache2 restart
service mysql restart

# Setup video streaming
$apt_install vlc

# Setup motion detection
$apt_install motion
$apt_remove motion # Only the dependencies are required

$apt_install wget
wget https://www.dropbox.com/s/xdfcxm5hu71s97d/motion-mmal.tar.gz -P /tmp/
tar zxvf /tmp/motion-mmal.tar.gz -C /tmp/ && rm /tmp/motion-mmal.tar.gz
mv /tmp/motion-mmalcam.conf /etc/motion.conf
mv /tmp/motion /usr/bin

# TODO: http://sjj.azurewebsites.net/?p=701
# TODO: http://www.lavrsen.dk/foswiki/bin/view/Motion/ConfigFileOptions
sed -i "s#target_dir /home/pi#/var/www/raspi-surveillance/public/videos#g" /etc/motion.conf
sed -i "s#output_pictures on#output_pictures off#g" /etc/motion.conf
sed -i "s#framerate 2/framerate 3#g" /etc/motion.conf

# Setup database
# TODO: Create database ()/database/)
# TODO: Create user (@w)
