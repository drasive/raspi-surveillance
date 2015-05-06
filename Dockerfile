# Dockerfile for image drasive/raspi-surveillance
# Used to develop and test https://github.com/drasive/raspi-surveillance
# Version 1.0.0

FROM ubuntu
MAINTAINER Dimitri Vranken, dimitri.vranken@hotmail.ch

RUN apt-get update
RUN apt-get upgrade
RUN apt-get autoremove

CMD /bin/bash

