#!/bin/bash

# Configuration
processName="motion"

# Get motion detection status
pid=`pidof $processName`
if [[ -n $pid ]]; then
    echo "Motion detection is running"
else
    echo "Motion detection is not running"
fi
