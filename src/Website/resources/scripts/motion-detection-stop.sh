#!/bin/bash
set -e

# Configuration
processName="motion-mmal"

# Stop motion detection
if ps -ef | grep -q $processName; then
    ps -ef | grep $processName | awk '{print $2}' | xargs kill
    echo "Stopped motion-detection"
else
    echo "Motion detection is not running"
fi
