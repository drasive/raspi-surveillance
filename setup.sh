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
$apt_install wget

# Setup LAMP server
$apt_install apache2
$apt_install mysql-server
$apt_install php5 php-pear php5-mysql

service apache2 restart
service mysql restart

# Setup video streaming
$apt_install vlc

# Setup motion detection
$apt_install motion
$apt_remove motion # Only the dependencies are required

wget https://www.dropbox.com/s/xdfcxm5hu71s97d/motion-mmal.tar.gz -P /tmp/
tar zxvf /tmp/motion-mmal.tar.gz -C /tmp/ && rm /tmp/motion-mmal.tar.gz
mv /tmp/motion-mmalcam.conf /etc/motion.conf
mv /tmp/motion /usr/bin

# TODO: http://sjj.azurewebsites.net/?p=701
# TODO: http://www.lavrsen.dk/foswiki/bin/view/Motion/ConfigFileOptions
#sed -i "s/start_x=0/start_x=1/g" /etc/motion.conf

# Setup control scripts

