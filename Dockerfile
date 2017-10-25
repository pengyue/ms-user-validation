FROM 449338121782.dkr.ecr.eu-west-1.amazonaws.com/alpine-base-php7

# Add app
COPY . /app

# Do not use laravel.log and specify exceptions path
ENV APP_LOG errorlog

# Set permissions for build
RUN mkdir -p /app/vendor/ && \
    chown -R build:build /app/vendor/ && \
    mkdir -p /app/var/cache/ && \
    chown -R build:build /app/var/cache/

# Run composer install as user 'build' and clean up the cache
#USER build
RUN composer install --no-interaction --no-ansi --no-progress --prefer-dist && composer clear-cache --no-ansi --quiet
USER root

# Fix permissions
RUN chown -R root:root /app/vendor/ && \
    chmod -R go-w /app/vendor/ && \
    chown -R www:www /app/var/cache/ && \
    mkdir -p /app/var/storage/ && \
    chown -R www:www /app/var/storage/ && \
    chown -R www:www /app/var/cache/ && \
    chown -R www:www /app/var/log/

# Add custom startup script
#COPY rc.local /etc/rc.local

# Record build info
#RUN /etc/build-info record settings

# Run a healthcheck as user 'www'
#RUN s6-setuidgid www php artisan infra:healthcheck