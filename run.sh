#!/usr/bin/env bash

# Prepare Symfony Project
chown -R www-data:www-data var/cache
chown -R www-data:www-data var/logs
chown -R www-data:www-data var/sessions
rm -rf var/log/* var/cache/* var/sessions/*
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load
php bin/console cache:clear --env=prod
chmod 777 -R var/cache var/logs var/sessions

source /etc/apache2/envvars
exec apache2 -D FOREGROUND
