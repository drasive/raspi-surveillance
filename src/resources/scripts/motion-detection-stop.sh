#!/bin/bash

# Configuration
processName="motion"

# Stop motion detection
pid=`pidof $processName`
if [[ -n $pid ]]; then
    pkill $processName
    echo "Stopped motion-detection"
else
    echo "Motion detection is not running"
fi
