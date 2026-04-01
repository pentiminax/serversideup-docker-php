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
RUN chmod +x /var/www/html/docker/entrypoint.sh

# Switch back to non-root user for security
USER www-data

ENTRYPOINT ["/var/www/html/docker/entrypoint.sh"]
