#!/bin/bash
set -e

# Configuration
imageDirectory="images"

# Check execution privilege
if ! [ $(id -u) = 0 ]; then
    echo "Please run as root"
    exit 1
fi

# Make sure image directory exists
if ! [ -d $imageDirector ]; then
    echo "Creating directory \"$imageDirectory\""
    mkdir $imageDirectory
fi

# Take image
fileName=`date +"%Y-%m-%d_%H-%M-%S.%3N"`.jpg
echo "Saving image to \"$imageDirectory/$fileName\""
raspistill -o $imageDirectory/$fileName
