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

#sudo apt-get update
#sudo apt-get upgrade
#sudo apt-get autoremove

# Setup LAMP server
#apt-install lamp-server^

#service apache2 restart
#service mysql restart

# Setup video streaming
#apt-install vlc

# Setup motion detection
apt-install motion

