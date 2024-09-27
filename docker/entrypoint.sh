#!/bin/sh
set -e

# Executar o PHP FPM em segundo plano

# # # Executar o Supervisor em primeiro plano
echo "123" | su root -c "/usr/bin/supervisord -c /etc/supervisor/supervisord.conf" & php-fpm    
