#!/bin/bash
set -e

# Check execution privilege
if ! [ $(id -u) = 0 ]; then
  echo "Please run as root"
  exit 1
fi

# TODO:
echo "Doing nothing"

# Webserver


# Video streaming


# Motion detection


echo "Setup completed"
