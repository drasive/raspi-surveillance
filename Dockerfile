# Dockerfile for https://github.com/drasive/raspi-surveillance
FROM debian:jessie
MAINTAINER Dimitri Vranken <dimitri.vranken@hotmail.ch>

ENV DEBIAN_FRONTEND noninteractive

# Install packages and execute setup scripts
RUN apt-get update

COPY ./setup-development.sh /host/
RUN /bin/bash -c "source /host/setup-development.sh"

COPY ./setup.sh /host/
RUN /bin/bash -c "source /host/setup.sh"

# Configure container
EXPOSE -p 80

CMD /bin/bash
