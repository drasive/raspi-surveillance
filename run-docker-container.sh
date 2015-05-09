#!/bin/bash
set -e

# Configuration
dockerImage="drasive/raspi-surveillance"
dockerCommands="/bin/bash"

hostDirectory="/src"       # Relative path
containerDirectory="/host" # Absolute path

hostPort="9999"
containerPort="80"

# Check execution privilege
if ! [ $(id -u) = 0 ]; then
  echo "Please run as root"
  exit 1
fi

# Run docker container
# TODO: Doesn't seem to work
iptables -t nat -A PREROUTING -i eth0 -p tcp --dport $hostPort -j REDIRECT --to-port $containerPort

currentDirectory=`pwd`
command="docker run \
           -v $currentDirectory$hostDirectory:$containerDirectory \
           -p $hostPort:$containerPort
           -ti $dockerImage \
           sh -c '$dockerCommands'"
eval $command
