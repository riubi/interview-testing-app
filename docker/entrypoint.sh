#!/bin/sh
set -e

php /var/www/bin/console doctrine:migrations:migrate --no-interaction

exec "$@"