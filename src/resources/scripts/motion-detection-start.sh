#!/bin/bash

# Configuration
processName="motion"

# Start motion detection
pid=`pidof $processName`
if [[ -n $pid ]]; then
    echo "Motion detection is already running"
else
    echo "Starting motion-detection"
    nohup motion -n -c /etc/motion.conf > /dev/null 2>&1  &
fi
