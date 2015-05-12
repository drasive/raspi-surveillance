#!/bin/sh
set -e

# Configuration
videoWidth=1280
videoHeight=720
videoFPS=24

streamPort=8554

# Check execution privilege
if [ $(id -u) = 0 ]; then
  echo "Please do NOT run as root"
  exit 1
fi

# Prepare videostream
# TODO: Test without
#export DISPLAY=:0
#$startx&

# Start videostream
echo -e "Starting videostream on port $streamPort (${videoWidth}x${videoHeight}p, ${videoFPS}FPS) \n"

raspivid -o - -t 0 -n -w $videoWidth -h $videoHeight -fps $videoFPS \
  | cvlc stream:///dev/stdin --sout '#standard{access=http,mux=ts,dst=:'$streamPort'}' :demux=h264
