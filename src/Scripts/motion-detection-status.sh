#!/bin/bash
set -e

# Configuration
processName="motion-mmal"

# Check execution privilege
if [ $(id -u) = 0 ]; then
    echo "Please do NOT run as root"
    exit 1
fi

# Get motion detection status
if ps -ef | grep -q $processName; then
    echo "Motion detection is running"
else
    echo "Motion detection is not running"
fi
