#!/bin/bash

# Configuration
processName="raspivid"

# Check execution privilege
if [ $(id -u) = 0 ]; then
    echo "Please do NOT run as root"
    exit 1
fi

# Stop videostream
pid=`pidof $processName`
if [[ -n $pid ]]; then
    kill $pid
    echo "Stopped videostream"
else
    echo "Videostream is not running"
fi
