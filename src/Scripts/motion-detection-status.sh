#!/bin/bash
set -e

# Configuration
screenName="motion-detection"

# Check execution privilege
if [ $(id -u) = 0 ]; then
    echo "Please do NOT run as root"
    exit 1
fi

# Get motion detection status
if screen -list | grep -q $screenName; then
    echo "Motion detection is running in screen \"$screenName\""
else
    echo "Motion detection is not running in screen \"$screenName\""
fi
