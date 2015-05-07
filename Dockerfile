# Dockerfile for https://github.com/drasive/raspi-surveillance

FROM debian:wheezy
MAINTAINER Dimitri Vranken <dimitri.vranken@hotmail.ch>

RUN apt-get update
RUN sh ./setup-development.sh
RUN sh ./setup.sh

EXPOSE 80

CMD /bin/bash
