FROM serversideup/php:8.5-frankenphp

USER root
RUN install-php-extensions intl

WORKDIR /var/www/html

# Install Composer dependencies in the image so production does not rely on host-built vendors
COPY --chown=www-data:www-data composer.json composer.lock symfony.lock ./

USER www-data
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader --no-scripts

USER root
COPY --chown=www-data:www-data . /var/www/html

# Build static assets at image build time (not at runtime)
USER www-data
RUN php bin/console importmap:install --env=prod && \
    php bin/console tailwind:build --minify --env=prod && \
    php bin/console asset-map:compile --env=prod

# Copy our scripts as executable
USER root
COPY --chmod=755 ./docker/entrypoint.d/ /etc/entrypoint.d/

# Switch back to non-root user for security
USER www-data
