FROM php:7.2-apache

RUN docker-php-ext-install pdo_mysql
#WORKDIR /code
RUN apt-get update && apt-get install -y \
        git \
        unzip \
   --no-install-recommends && rm -r /var/lib/apt/lists/*


RUN echo '[Date]' >> /usr/local/etc/php/php.ini
RUN echo 'date.timezone = Europe/Paris' >> /usr/local/etc/php/php.ini

RUN pecl install apcu && docker-php-ext-enable apcu
RUN echo 'extension=apcu.so' >> /usr/local/etc/php/php.ini
RUN echo 'short_open_tag=Off' >> /usr/local/etc/php/php.ini

RUN apt-get update
RUN apt-get install -y vim git wget mysql-client

RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer


  RUN pecl install xdebug \
    && docker-php-ext-enable xdebug


RUN ls
#  COPY ./xdebug/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini


#RUN pecl install xdebug \
#  && docker-php-ext-enable xdebug
#COPY ./xdebug/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
#COPY . /code/
#RUN composer install