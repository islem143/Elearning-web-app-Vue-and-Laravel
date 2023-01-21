FROM php:8.1-fpm-alpine


RUN docker-php-ext-install pdo pdo_mysql


ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}


RUN addgroup -g ${GID} --system islem
RUN adduser -G islem --system -D -s /bin/sh -u ${UID} islem


RUN sed -i "s/user = www-data/user = islem/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = islem/g" /usr/local/etc/php-fpm.d/www.conf

RUN apk add --update supervisor

COPY ./supervisor/laravel-worker.conf /etc/supervisor/

RUN supervisord --configuration /etc/supervisor/laravel-worker.conf





WORKDIR /var/www/html

