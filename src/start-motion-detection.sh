#!/bin/bash
set -e

# Configuration
screenName="motion-detection"

# Check execution privilege
if ! [ $(id -u) = 0 ]; then
  echo "Please run as root"
  exit 1
fi

# Start motion detection
echo "Starting motion-detection in screen \"$screenName\""

screen -dmS $screenName motion -c /etc/motion.conf
