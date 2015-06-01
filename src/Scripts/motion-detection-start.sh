#!/bin/bash
set -e

# Configuration
screenName="motion-detection"

# Check execution privilege
if [ $(id -u) = 0 ]; then
    echo "Please do NOT run as root"
    exit 1
fi

# Start motion detection
if screen -list | grep -q $screenName; then
    echo "Motion detection is already running in screen \"$screenName\""
else
    echo "Starting motion-detection in screen \"$screenName\""

    screen -dmS $screenName \
      motion -n -c /etc/motion.conf
fi
