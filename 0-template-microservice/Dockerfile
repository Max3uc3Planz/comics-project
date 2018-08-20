FROM webdevops/php-nginx-dev:alpine-php7

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN composer global require "hirak/prestissimo:^0.3" --prefer-dist --no-progress --no-suggest --optimize-autoloader --classmap-authoritative \
	&& composer clear-cache

RUN buildDeps=" build-base re2c file readline-dev autoconf binutils bison \
        libxml2-dev curl-dev freetype-dev openssl-dev \
        libjpeg-turbo-dev libpng-dev libwebp-dev libmcrypt-dev \
        gmp-dev icu-dev libmemcached-dev linux-headers" \
    && apk --update add $buildDeps

RUN apk add --no-cache \
        $PHPIZE_DEPS \
		php7-dev \
		openssl-dev \
		gcc

RUN pecl install mongodb
RUN set -xeo pipefail \
    && version=$(php -r "echo PHP_MAJOR_VERSION, PHP_MINOR_VERSION;") \
    && curl -sSL -D - -A "Docker" -o /tmp/blackfire-probe.tar.gz https://blackfire.io/api/v1/releases/probe/php/alpine/amd64/${version} \
    && curl -sSL -D - -A "Docker" -o /tmp/blackfire-client.tar.gz https://blackfire.io/api/v1/releases/client/linux_static/amd64 \
    && for file in /tmp/blackfire-*.tar.gz; do tar zxfp "${file}" -C /tmp; done \
    && for file in /tmp/blackfire-*.sha*; do echo "$(cat ${file})  ${file/.sha1/}"; done | sed 's/\.sha/.so/' | sha1sum -c - \
    && chmod +x /tmp/blackfire-*.so /tmp/blackfire \
    && mv /tmp/blackfire-*.so "$(php -r "echo ini_get('extension_dir');")/blackfire.so" \
    && mv /tmp/blackfire /bin/blackfire-agent \
    && printf "extension=blackfire.so\nextension=mongodb.so\n" > /opt/docker/etc/php/php.ini \
    && rm -rf /tmp/blackfire* \
    && php -m | grep "^blackfire$" > /dev/null

COPY  ./docker/nginx/ /opt/docker/etc/nginx/
WORKDIR /var/www/html/src

COPY app/bin bin
COPY app/config config
COPY app/public public
COPY app/src src
#COPY app/templates templates
#COPY app/translations translations

COPY app/composer.json composer.json
COPY app/composer.lock composer.lock
COPY app/symfony.lock symfony.lock

RUN mkdir -p \
		var/cache \
		var/logs \
		var/sessions \
	&& composer install --prefer-dist --no-dev --no-autoloader --no-scripts --no-progress --no-suggest \
	&& composer clear-cache \
	&& chown -R application var

RUN composer dump-autoload --optimize --classmap-authoritative --no-dev