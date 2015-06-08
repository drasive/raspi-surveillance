#!/bin/sh
set -e

# Configuration
screenName="videostream"

videoWidth=1280
videoHeight=720
videoFPS=30

streamPort=8554

# Check execution privilege
if [ $(id -u) = 0 ]; then
    echo "Please do NOT run as root"
    exit 1
fi

# Prepare videostream
export DISPLAY=:0
$startx&

# Start videostream
if screen -list | grep -q $screenName; then
    echo "Videostream is already running in screen \"$screenName\""
else
    echo "Starting HTTP videostream on port $streamPort (${videoWidth}x${videoHeight}p, ${videoFPS}FPS) in screen \"$screenName\""
    
    screen -dmS $screenName \
      raspivid -o - -t 0 -n -w $videoWidth -h $videoHeight -fps $videoFPS \
      | cvlc --x11-display :0 stream:///dev/stdin --sout '#standard{access=http,mux=ts,dst=:'$streamPort'}' :demux=h264 \
      &> /dev/null
fi
