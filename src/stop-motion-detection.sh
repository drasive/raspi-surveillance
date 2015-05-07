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
screen -S $screenName -X quit
