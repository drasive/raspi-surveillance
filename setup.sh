#!/bin/bash
set -e

# Check execution privilege
if ! [ $(id -u) = 0 ]; then
  echo "Please run as root"
  exit 1
fi

# Prepare setup
alias apt-install='sudo -E apt-get install --yes --force-yes'

export DEBIAN_FRONTEND=noninteractive # Turn off configuration dialogs

# Setup LAMP server
apt-install lamp-server^

service apache2 restart
service mysql restart

# Setup video streaming
apt-install vlc

# Setup motion detection
motionConfigurationFile="/etc/motion.conf"

# TODO: http://jankarres.de/2013/12/raspberry-pi-kamera-modul-mit-motion-tracking/
apt-install motion
sudo apt-get remove motion # Only the dependencies are required

wget https://www.dropbox.com/s/xdfcxm5hu71s97d/motion-mmal.tar.gz
tar zxvf motion-mmal.tar.gz

# TODO: Check what folders and files have been extracted
sudo mv motion-mmalcam.conf $motionConfigurationFile
sudo mv motion /usr/bin

# TODO: http://sjj.azurewebsites.net/?p=701
#sed -i "s/start_x=0/start_x=1/g" $motionConfigurationFile
