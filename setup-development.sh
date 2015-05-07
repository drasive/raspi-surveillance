#!/bin/bash
set -e

# Check execution privilege
if ! [ $(id -u) = 0 ]; then
  echo "Please run as root"
  exit 1
fi

# Prepare setup
apt_install='apt-get install --yes'

# Install apt-get packages
$apt_install nano
$apt_install tree

$apt_install wget
$apt_install curl
$apt_install w3m

$apt_install openssh-server
$apt_install openssh-client
