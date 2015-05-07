#!/bin/bash
set -e

# Check execution privilege
if ! [ $(id -u) = 0 ]; then
  echo "Please run as root"
  exit 1
fi

# Enable camera
if grep "start_x=1" /boot/config.txt; then
	echo "Camera module is already enabled"
else
    sed -i "s/start_x=0/start_x=1/g" /boot/config.txt
    echo "Camera module is now enabled, a reboot is required for the change to take effect"
fi
