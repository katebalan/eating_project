#!/usr/bin/env bash

# Prepare Symfony Project
chown -R www-data:www-data var/cache
chown -R www-data:www-data var/logs
chown -R www-data:www-data var/sessions
rm -rf var/log/* var/cache/* var/sessions/*
php app/console doctrine:database:create
php app/console doctrine:schema:update --force
php app/console cache:clear --env=prod
chmod 777 -R var/cache var/logs var/sessions

source /etc/apache2/envvars
exec apache2 -D FOREGROUND
