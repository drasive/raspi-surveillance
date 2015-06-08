#!/bin/bash
set -e

# Configuration
processName="motion-mmal"

# Get motion detection status
if ps -ef | grep -q $processName; then
    echo "Motion detection is running"
else
    echo "Motion detection is not running"
fi
