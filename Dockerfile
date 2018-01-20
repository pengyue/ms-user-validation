FROM pengyue/alpine-php7

MAINTAINER Peng Yue <penyue@gmail.com>

# Used only to force cache invalidation
ARG CACHE_BUSTER=2018-01-20

# Install composer
RUN wget -qO /usr/local/bin/composer https://getcomposer.org/download/1.4.2/composer.phar && chmod +x /usr/local/bin/composer

# Enable Blackfire profiling PHP probe
RUN version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/alpine/amd64/$version \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp \
    && mv /tmp/blackfire-*.so $(php -r "echo ini_get('extension_dir');")/blackfire.so \
    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > /etc/php7/conf.d/blackfire.ini

# Install composer parallel install plugin
USER build
RUN composer global require "hirak/prestissimo:^0.3" --no-interaction --no-ansi --quiet --no-progress --prefer-dist && composer clear-cache --no-ansi --quiet && chmod -R go-w ~/.composer/vendor/
USER root

# Set the working directory to /app
WORKDIR /app

# Set a trigger to purge the sample app on descendants
ONBUILD RUN rm -rf /app/public
ONBUILD RUN rm -rf /app/var/cache

# Add app
COPY . /app

# Set permissions for build
RUN mkdir -p /app/vendor/ && \
    chown -R build:build /app/vendor/ && \
    mkdir -p /app/var && \
    chown -R build:build /app/var/ && \
    mkdir -p /app/var/cache/ && \
    chown -R build:build /app/var/cache/ && \
    mkdir -p /app/var/logs/ && \
    chown -R build:build /app/var/logs/ && \
    mkdir -p /app/var/storage/ && \
    chown -R build:build /app/var/storage/ && \
    chown -R build:build /app/bin/

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
    chown -R www:www /app/var/logs/ && \
    chown -R www:www /app/bin/
