#!/bin/sh
set -e

php-fpm > /dev/stdout &

exec "$@"