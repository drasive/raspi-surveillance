#!/bin/bash
set -e

# Configuration
processName="motion-mmal"

# Check execution privilege
if [ $(id -u) = 0 ]; then
    echo "Please do NOT run as root"
    exit 1
fi

# Start motion detection
if ps -ef | grep -q $processName; then
    echo "Motion detection is already running"
else
    echo "Starting motion-detection"
    motion -n -c /etc/motion.conf &> /dev/null
fi
