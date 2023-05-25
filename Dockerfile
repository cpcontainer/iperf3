FROM arm64v8/ubuntu:latest
RUN apt-get update \
 && DEBIAN_FRONTEND=noninteractive \
    apt-get install --assume-yes --no-install-recommends \
      iputils-ping \
      iperf3 \
      apache2 \
      php \
      libapache2-mod-php
COPY . /var/www/html
COPY ./iperf3.log /var/log
RUN chmod 777 /var/log/iperf3.log
RUN chmod 775 /var/www/html/*
EXPOSE 80
ENTRYPOINT service apache2 restart && tail -f /dev/null
