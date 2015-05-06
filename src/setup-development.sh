#!/bin/bash
set -e

# Check execution privilege
if ! [ $(id -u) = 0 ]; then
  echo "Please run as root"
  exit 1
fi

# Prepare setup
alias apt-install='sudo apt-get install --yes --force-yes'

# Install apt-get packages
#apt-install nano
#apt-install w3m
#apt-install tree

#apt-install openssh-server
#apt-install openssh-client

#apt-install tightvncserver

