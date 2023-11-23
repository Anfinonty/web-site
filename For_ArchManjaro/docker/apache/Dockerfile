
FROM debian:buster-slim

#Update and Install Necessary Packages
RUN apt-get update -y && apt-get install -y apache2 locales-all vim php libapache2-mod-php php-sqlite3 vlc openssh-server


#Set Locale and Timezone
ENV LC_ALL C.UTF-8
ENV TZ Australia/Perth
RUN echo "${TZ}" > /etc/timezone && dpkg-reconfigure -f noninteractive tzdata

#Apache settings
###COPY docker/fstab /etc/fstab
COPY docker/apache/sites-available /etc/apache2/sites-available
COPY docker/apache/php.ini /etc/php/7.3/apache2/php.ini
COPY server.* /etc/apache2/ssl_keys/
COPY letsencrypt/*.pem /etc/apache2/ssl_keys

#accessible to ssh user myUsername
RUN useradd -p $(openssl passwd -1 myDockerPassword) myUsername
RUN chown fey /etc/apache2/ssl_keys/cert1.pem
RUN chown fey /etc/apache2/ssl_keys/privkey1.pem
COPY docker/sshd_config /etc/ssh/sshd_config

###RUN mount -t iso9660 -i ro /dev/sr0 /run/media/fey
RUN a2enmod headers rewrite ssl proxy proxy_http proxy_wstunnel proxy_balancer lbmethod_byrequests

RUN a2ensite gdaym8
RUN a2dissite 000-default

EXPOSE 80
EXPOSE 443
EXPOSE 8085

#Create folder for SQLite DB
RUN mkdir /var/www/db
COPY ./mydatabase.sqlite /var/www/db/mydatabase.sqlite
#Folder and Database file must be writeable to work
RUN chmod 777 /var/www/db
RUN chmod 777 /var/www/db/mydatabase.sqlite


CMD ["apachectl", "-D", "FOREGROUND"]
