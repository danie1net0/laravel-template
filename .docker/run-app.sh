#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}
env=${APP_ENV:-production}

if [ "$env" != "local" ]; then
    echo "Caching configuration..."
    (cd /var/www/html && php artisan config:cache && php artisan route:cache)

    echo "Removing Xdebug..."
    rm -rf /usr/local/etc/php/conf.d/{docker-php-ext-xdebug,xdebug}.ini
fi

if [ "$env" == "local" ] && [ ! -z "$DEV_UID" ]; then
    echo "Changing www-data UID to $DEV_UID"
    echo "The UID should only be changed in development environments."
    usermod -u $DEV_UID www-data
fi

confd -onetime -backend env

# App
if [ "$role" = "app" ]; then

    ln -sf /etc/supervisor/conf.d-available/app.conf /etc/supervisor/conf.d/app.conf

# Horizon
elif [ "$role" = "horizon" ]; then

    ln -sf /etc/supervisor/conf.d-available/horizon.conf /etc/supervisor/conf.d/horizon.conf

# Scheduler
elif [ "$role" = "scheduler" ]; then

    ln -sf /etc/supervisor/conf.d-available/scheduler.conf /etc/supervisor/conf.d/scheduler.conf

else
    echo "Could not match the container role \"$role\""
    exit 1
fi

exec supervisord -c /etc/supervisor/supervisord.conf
