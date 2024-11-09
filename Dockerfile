FROM composer:2.4 AS build

COPY ./src/composer.json /app

WORKDIR /app
RUN composer update \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-dev \
    --prefer-dist


COPY ./src /app/
RUN composer dump-autoload --optimize




FROM php:8.2-fpm-alpine AS dev


ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}
ARG USERNAME
ENV USERNAME=${USERNAME}

RUN addgroup -g ${GID} --system ${USERNAME}
RUN adduser -G ${USERNAME} --system -D -s /bin/sh -u ${UID} ${USERNAME}


RUN sed -i "s/user = www-data/user = ${USERNAME}/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = ${USERNAME}/g" /usr/local/etc/php-fpm.d/www.conf


WORKDIR /var/www/html


ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apk update && apk add  zip
RUN docker-php-ext-install pdo pdo_mysql
COPY ./src/php.ini /usr/local/etc/php/conf.d/
COPY ./src /var/www/html/
#COPY ./src/.env.dev /var/www/html/.env
COPY --from=build /usr/bin/composer /usr/bin/composer
RUN composer install --prefer-dist --no-interaction

RUN chown -R ${USERNAME}:www-data /var/www/html
RUN find /var/www/html -type f -exec chmod 664 {} \;   
RUN find /var/www/html -type d -exec chmod 775 {} \;
RUN chgrp -R www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache
USER ${USERNAME}






FROM php:8.2-fpm-alpine AS production




RUN docker-php-ext-install pdo pdo_mysql



#COPY ./src/php.ini /usr/local/etc/php/conf.d/


RUN apk add --update supervisor
COPY --from=build /app /var/www/html
RUN php artisan config:cache && \
    php artisan route:cache 
#COPY ./supervisor/laravel-worker.conf /etc/supervisor/conf.d/
RUN mkdir -p "/etc/supervisor/logs"

RUN chown -R $USER:www-data /var/www/html
RUN find /var/www/html -type f -exec chmod 664 {} \;   
RUN find /var/www/html -type d -exec chmod 775 {} \;
RUN chgrp -R www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache
RUN php artisan optimize:clear













