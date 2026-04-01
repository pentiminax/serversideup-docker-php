#!/bin/sh
set -eu

if [ "${SKIP_DB_MIGRATIONS:-0}" != "1" ]; then
    echo "Running database migrations..."

    attempts=0
    max_attempts="${DB_MIGRATION_MAX_ATTEMPTS:-30}"
    sleep_seconds="${DB_MIGRATION_RETRY_DELAY:-2}"

    until php /var/www/html/bin/console doctrine:migrations:migrate --no-interaction --all-or-nothing; do
        attempts=$((attempts + 1))

        if [ "${attempts}" -ge "${max_attempts}" ]; then
            echo "Database migrations failed after ${attempts} attempts."
            exit 1
        fi

        echo "Database is not ready yet. Retrying in ${sleep_seconds}s..."
        sleep "${sleep_seconds}"
    done
fi

exit 0
