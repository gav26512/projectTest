#!/usr/bin/env bash
set -e

/usr/local/bin/wait-for-it.sh \
	--host=${POSTGRES_HOST} \
	--port=${POSTGRES_PORT} \
	--timeout=100 \
	--strict


cd /app/activity
composer update --no-interaction
php yii migrate/up --interactive=0

exec "$@"
