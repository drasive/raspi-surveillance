#!/bin/bash
set -e

# Configuration
dockerImage="drasive/raspi-surveillance"
dockerCommands="sh /host/setup-development.sh && sh /host/setup.sh \
                && /bin/bash"

hostDirectory="/src"    # Relative path
clientDirectory="/host" # Absolute path

# Check execution privilege
if ! [ $(id -u) = 0 ]; then
  echo "Please run as root"
  exit 1
fi

# Start docker image
currentDirectory=`pwd`
command="docker run -v $currentDirectory$hostDirectory:$clientDirectory \
         -ti $dockerImage \
         sh -c '$dockerCommands'"

eval $command

