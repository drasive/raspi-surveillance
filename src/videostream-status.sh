#!/bin/bash
set -e

# Configuration
screenName="videostream"

# Check execution privilege
if ! [ $(id -u) = 0 ]; then
    echo "Please run as root"
    exit 1
fi

# Get videostream status
if screen -list | grep -q $screenName; then
    echo "Videostream is running in screen \"$screenName\""
else
	echo "Videostream is not running in screen \"$screenName\""
fi
