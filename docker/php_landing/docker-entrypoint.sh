#!/usr/bin/env bash
set -e

cd /app/landing/
composer update --no-interaction

exec "$@"
