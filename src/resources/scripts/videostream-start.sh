#!/bin/bash

# Configuration
processName="raspivid"

videoWidth=1280
videoHeight=720
videoFPS=30

streamPort=8554

# Check execution privilege
if [ $(id -u) = 0 ]; then
    echo "Please do NOT run as root"
    exit 1
fi

# Start videostream
pid=`pidof $processName`
if [[ -n $pid ]]; then
    echo "Videostream is already running"
else
    echo "Starting HTTP videostream on port $streamPort (${videoWidth}x${videoHeight}p, ${videoFPS}FPS)"
    
    nohup raspivid -o - -t 0 -n -w $videoWidth -h $videoHeight -fps $videoFPS \
      | cvlc -v stream:///dev/stdin --sout '#standard{access=http,mux=ts,dst=:'$streamPort'}' :demux=h264 \
      > /dev/null 2>&1  &
fi
