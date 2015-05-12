#!/bin/bash
set -e

# Check execution privilege
if ! [ $(id -u) = 0 ]; then
  echo "Please run as root"
  exit 1
fi

# Prepare setup
export DEBIAN_FRONTEND=noninteractive

apt_install='apt-get install --yes'
$apt_install apt-utils

# Install apt-get packages
$apt_install nano
$apt_install tree

$apt_install net-tools
$apt_install wget
$apt_install curl
$apt_install w3m

$apt_install openssh-server
$apt_install openssh-client
