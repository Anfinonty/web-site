FROM debian:buster-slim

#Update and Install Necessary Packages
RUN apt-get update -y && apt-get install -y apache2 locales-all vim php libapache2-mod-php


#Set Locale and Timezone
ENV LC_ALL C.UTF-8
ENV TZ Australia/Perth
RUN echo "${TZ}" > /etc/timezone && dpkg-reconfigure -f noninteractive tzdata

#Apache settings
###COPY docker/fstab /etc/fstab
COPY docker/apache/sites-available /etc/apache2/sites-available
COPY server.* /etc/apache2/ssl_keys/
#COPY mkcert/rootCA* /etc/apache2/ssl_keys
COPY letsencrypt/*.pem /etc/apache2/ssl_keys
#COPY letsencrypt/privkey1.pem /etc/apache2/ssl_keys/privkey.pem
#COPY letsencrypt/chain1.pem /etc/apache2/ssl_keys/chain.pem



###RUN mount -t iso9660 -i ro /dev/sr0 /run/media/fey
RUN a2enmod headers rewrite ssl proxy proxy_http proxy_wstunnel proxy_balancer lbmethod_byrequests

RUN a2ensite gdaym8
RUN a2dissite 000-default

EXPOSE 80
EXPOSE 443

CMD ["apachectl", "-D", "FOREGROUND"]
