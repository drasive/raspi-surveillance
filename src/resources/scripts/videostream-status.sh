#!/bin/bash

# Configuration
processName="raspivid"

# Check execution privilege
if [ $(id -u) = 0 ]; then
    echo "Please do NOT run as root"
    exit 1
fi

# Get videostream status
pid=`pidof $processName`
if [[ -n $pid ]]; then
    echo "Videostream is running"
else
    echo "Videostream is not running"
fi
