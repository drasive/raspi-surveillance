#!/bin/bash
set -e

# Configuration
screenName="motion-detection"

# Check execution privilege
if ! [ $(id -u) = 0 ]; then
    echo "Please run as root"
    exit 1
fi

# Stop motion detection
if screen -list | grep -q $screenName; then
    screen -S $screenName -X quit
    echo "Stopped motion-detection in screen \"$screenName\""
else
    echo "Motion detection is not running in screen \"$screenName\""
fi
