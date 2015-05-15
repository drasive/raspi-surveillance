#!/bin/bash
set -e

# Check execution privilege
if ! [ $(id -u) = 0 ]; then
    echo "Please run as root"
    exit 1
fi

# Check access to configuration file
configurationFile="/boot/config.txt"

if ! [ -e $configurationFile ]; then
    echo "Configuration file ($configurationFile) doesn't exist"
    exit 1
fi
if ! [ -w $configurationFile ]; then
    echo "No write access to configuration file ($configurationFile)"
    exit 1
fi

# Enable camera
if grep "start_x=1" $configurationFile; then
	echo "Camera module is already enabled"
else
    sed -i "s/start_x=0/start_x=1/g" $configurationFile
    echo "Camera module is now enabled, a reboot is required for the change to take effect"
fi
