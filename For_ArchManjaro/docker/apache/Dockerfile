
#EOL DEC 2024
#FROM debian:buster-slim

FROM debian:bullseye-slim

#Update and Install Necessary Packages
RUN apt-get update -y && apt-get install -y apache2 locales-all vim php libapache2-mod-php php-sqlite3 vlc openssh-server python3-pip python3

#RUN apt update
#RUN apt install -y software-properties-common
#RUN add-apt-repository -y ppa:deadsnakes/ppa
#RUN apt install -y build-essential zlib1g-dev libncurses5-dev libgdbm-dev libnss3-dev libssl-dev libsqlite3-dev libreadline-dev libffi-dev curl libbz2-dev liblzma-dev
#RUN apt install python3.9

#RUN apt-get install -y libnetfilter-queue-dev
RUN apt-get install -y libffi-dev
RUN apt-get install -y ffmpeg
#RUN apt-get install -y git-all
RUN apt-get install -y git
#RUN apt-get install -y php-zip
RUN apt-get install -y p7zip-full

#Install to run VLC-Discord Bot
RUN pip3 install discord.py[voice]
RUN pip3 install discord.py
RUN pip3 install python-dotenv
#RUN pip3 install --upgrade --force-reinstall "git+https://github.com/ytdl-org/youtube-dl.git"
RUN pip3 install yt-dlp
RUN pip3 install asyncio
#RUN pip3 install -U git+https://github.com/Rapptz/discord.py
#RUN pip3 install youtube_dl

#Set Locale and Timezone
ENV LC_ALL C.UTF-8
ENV TZ Australia/Perth
RUN echo "${TZ}" > /etc/timezone && dpkg-reconfigure -f noninteractive tzdata

#Apache settings
###COPY docker/fstab /etc/fstab
COPY docker/apache/sites-available /etc/apache2/sites-available
COPY docker/apache/php.ini /etc/php/7.4/apache2/php.ini
COPY server.* /etc/apache2/ssl_keys/
COPY letsencrypt2/spiderspeed.site/*.pem /etc/apache2/ssl_keys/


#accessible to ssh user username
RUN useradd -p $(openssl passwd -1 PASSWORD) username
RUN chown username /etc/apache2/ssl_keys/cert.pem
RUN chown username /etc/apache2/ssl_keys/privkey.pem
COPY docker/sshd_config /etc/ssh/sshd_config


#Copy python files over
RUN mkdir python
#COPY python/discord_bot python
RUN mkdir /home/username
RUN chown username /home/username


###RUN mount -t iso9660 -i ro /dev/sr0 /run/media/username
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
#RUN chmod 777 /var/www/db
#RUN chmod 777 /var/www/db/mydatabase.sqlite

#RUN chmod 770 /var/www/db
#RUN chgrp http /var/www/db
#RUN chmod 660 /var/www/db/mydatabase.sqlite
#RUN chgrp http /var/www/db/mydatabase.sqlite


# Set ownership to the web server group (e.g., http, www-data)
RUN chown -R :www-data /var/www/db

# Set correct permissions
# Directory needs read/write/execute (770) so SQLite can create temporary journal files
RUN chmod 770 /var/www/db
# Database file needs read/write (660)
RUN chmod 660 /var/www/db/mydatabase.sqlite


CMD ["apachectl", "-D", "FOREGROUND"]
