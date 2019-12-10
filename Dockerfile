FROM composer:latest AS composer
FROM pengyue/alpine-php7

MAINTAINER Peng Yue <penyue@gmail.com>

# Used only to force cache invalidation
ARG CACHE_BUSTER=2019-12-10A

# Setup a simple and informative shell prompt
ENV PS1='\u@\h.${POD_NAMESPACE}:/\W \$ '

# Install composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Enable Blackfire profiling PHP probe
RUN version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/alpine/amd64/$version \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp \
    && mv /tmp/blackfire-*.so $(php -r "echo ini_get('extension_dir');")/blackfire.so \
    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > /etc/php7/conf.d/blackfire.ini

# Add app
COPY . /app

# Set permissions for build
RUN mkdir -p /app/vendor/ && \
    chown -R build:build /app/vendor/ && \
    mkdir -p /app/var && \
    chown -R build:build /app/var/ && \
    mkdir -p /app/var/cache/ && \
    chown -R build:build /app/var/cache/ && \
    mkdir -p /app/var/log/ && \
    chown -R build:build /app/var/log/ && \
    mkdir -p /app/var/storage/ && \
    chown -R build:build /app/var/storage/ && \
    chown -R build:build /app/bin/

# Set a trigger to purge the sample app on descendants
ONBUILD RUN rm -rf /app/public
ONBUILD RUN rm -rf /app/var/cache

# Run composer install as user 'build' and clean up the cache
USER build
RUN composer clear-cache --no-ansi --quiet && \
    composer install --no-interaction --no-ansi --no-progress --prefer-dist
USER root

# Fix permissions
RUN chown -R root:root /app/vendor/ && \
    chmod -R go-w /app/vendor/ && \
    chown -R www:www /app/var/cache/ && \
    chown -R www:www /app/var/storage/ && \
    chown -R www:www /app/var/log/ && \
    chown -R www:www /app/bin/
