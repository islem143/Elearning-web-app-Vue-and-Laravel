FROM php:8.2-fpm-alpine

ARG UID
ARG GID
ARG USERNAME
ENV UID=${UID}
ENV GID=${GID}
ENV USERNAME=${USERNAME}


RUN addgroup -g ${GID} --system ${USERNAME}
RUN adduser -G ${USERNAME} --system -D -s /bin/sh -u ${UID} ${USERNAME}


RUN sed -i "s/user = www-data/user = ${USERNAME}/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = ${USERNAME}/g" /usr/local/etc/php-fpm.d/www.conf

RUN docker-php-ext-install pdo pdo_mysql

RUN apk update && apk add --no-cache supervisor

RUN mkdir -p "/etc/supervisor/logs"
RUN chown islem /etc/supervisor/logs
COPY supervisor/laravel-worker.conf /etc/supervisor/supervisord.conf

CMD ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/supervisord.conf"]