#!/bin/sh
set -e

# TODO: Finish implementation
export LD_LIBRARY_PATH="/usr/lib"
mjpg_streamer -i "input_raspicam.so -d 0 -ex night -x 640 -y 480" -o "output_http.so -p 8080 -w /usr/www"
exit 0
