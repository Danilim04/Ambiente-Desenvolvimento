#!/bin/sh
set -e

# Executar chown
chown -R www-data:www-data * 

# Executar chmod
chmod -R o+w /var/www/app 

# # Executar o Supervisor
# /usr/bin/supervisord -c /etc/supervisor/supervisord.conf

# Executar o PHP FPM
php-fpm

exec "$@"



