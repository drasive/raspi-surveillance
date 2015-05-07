#!/bin/bash
set -e

# Configuration
dockerImage="drasive/raspi-surveillance"
dockerCommands="/bin/bash"

hostDirectory="/src"    # Relative path
clientDirectory="/host" # Absolute path

hostPort="9999"
clientPort="80"

# Check execution privilege
if ! [ $(id -u) = 0 ]; then
  echo "Please run as root"
  exit 1
fi

# Run docker container
currentDirectory=`pwd`

command="docker run \
           -v $currentDirectory$hostDirectory:$clientDirectory \
           -p $hostPort:$clientPort
           -ti $dockerImage \
           sh -c '$dockerCommands'"           
eval $command
