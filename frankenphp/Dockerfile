FROM serversideup/php:8.5-frankenphp

# Switch to root to install dependencies and copy files
USER root

# Install PHP dependencies
RUN install-php-extensions intl

# Copy application files with correct ownership
COPY --chown=www-data:www-data . /var/www/html
RUN chmod +x /var/www/html/docker/entrypoint.sh

# Switch back to non-root user for security
USER www-data

ENTRYPOINT ["/var/www/html/docker/entrypoint.sh"]
