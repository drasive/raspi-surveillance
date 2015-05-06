#!/bin/sh
set -e

# Configuration
videoWidth=1280
videoHeight=720
videoFPS=24

streamPort=8554

# Start videostream
echo "Starting videostream on port "$streamPort" ("$videoWidth"x"$videoHeight"p, "$videoFPS"FPS) \n"
raspivid -o - -t 0 -n -w $videoWidth -h $videoHeight -fps $videoFPS \
  | cvlc stream:///dev/stdin --sout '#rtp{sdp=rtsp://:'$streamPort'/}' :demux=h264

