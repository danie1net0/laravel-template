FROM php:8.3-fpm

ENV PATH="./vendor/bin:${PATH}" \
    NGINX_SERVER_NAME="_"

RUN apt update \
    && apt -y --no-install-recommends install \
        build-essential \
        libpq-dev libzip-dev libpng-dev libjpeg62-turbo-dev libicu-dev \
        unzip \
        procps \
        supervisor \
        nginx \
        jpegoptim optipng pngquant gifsicle \
        nodejs npm \
        postgresql-client \
    && pecl install redis \
    && docker-php-ext-configure gd --with-jpeg=/usr/include \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install sockets pdo pdo_pgsql gd zip exif pcntl intl \
    && docker-php-ext-enable redis

RUN npm update -g npm

COPY .docker/php/php-fpm.d/docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY .docker/php/conf.d/*.ini /usr/local/etc/php/conf.d/
COPY .docker/php/php.ini /usr/local/etc/php/php.ini

COPY .docker/nginx/h5bp /etc/nginx/h5bp

COPY .docker/supervisor/supervisord.conf /etc/supervisor/supervisord.conf
COPY .docker/supervisor/conf.d/*.conf /etc/supervisor/conf.d-available/

COPY .docker/run-app.sh /usr/local/bin/run-app
COPY .docker/php/composer-installer.sh /usr/local/bin/composer-installer

ADD https://github.com/kelseyhightower/confd/releases/download/v0.11.0/confd-0.11.0-linux-amd64 /usr/local/bin/confd
COPY .docker/confd/conf.d/ /etc/confd/conf.d/
COPY .docker/confd/templates/ /etc/confd/templates/

RUN echo "max_file_uploads=100" >> /usr/local/etc/php/conf.d/docker-php-ext-max_file_uploads.ini
RUN echo "post_max_size=120M" >> /usr/local/etc/php/conf.d/docker-php-ext-post_max_size.ini
RUN echo "upload_max_filesize=120M" >> /usr/local/etc/php/conf.d/docker-php-ext-upload_max_filesize.ini

RUN chmod +x /usr/local/bin/confd \
    && chmod +x /usr/local/bin/run-app \
    && chmod +x /usr/local/bin/composer-installer \
    && /usr/local/bin/composer-installer \
    && mv composer.phar /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer \
    && composer --version

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["/usr/local/bin/run-app"]
