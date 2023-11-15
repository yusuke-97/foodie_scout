#!/bin/bash

# cronデーモンの起動
service cron start

# PHP-FPMの起動
exec php-fpm
