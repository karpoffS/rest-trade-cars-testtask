FROM phpdockerio/php:7.4-fpm
WORKDIR "/application"

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
        git \
        php7.4-amqp \
        php7.4-bcmath \
        php7.4-bz2 \
        php7.4-gd \
        php7.4-igbinary \
        php7.4-imagick \
        php7.4-intl \
        php7.4-mysql \
        php7.4-pgsql \
        php7.4-redis \
        php7.4-soap \
        php7.4-sqlite3 \
        php7.4-uuid \
        php7.4-xdebug \
        php7.4-xsl \
        php7.4-yaml \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
