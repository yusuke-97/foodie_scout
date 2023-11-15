#!/bin/bash

# cronデーモンの起動
service cron start

# PHP内蔵サーバーの起動（Heroku環境用）
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}