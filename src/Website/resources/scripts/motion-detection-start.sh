#!/bin/bash
set -e

# Configuration
processName="motion-mmal"

# Start motion detection
if ps -ef | grep -q $processName; then
    echo "Motion detection is already running"
else
    echo "Starting motion-detection"
    motion -n -c /etc/motion.conf &> /dev/null
fi
