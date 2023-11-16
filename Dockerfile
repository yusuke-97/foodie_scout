FROM php:8.2.3-fpm

# Laravelアプリケーションのファイルをコピー
COPY src/ /var/www/html

# COPY php.ini と entrypoint.sh
COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/php/entrypoint.sh /entrypoint.sh

# Composer install
COPY --from=composer:2.5.8 /usr/bin/composer /usr/bin/composer

# install Node.js
COPY --from=node:20.6.1 /usr/local/bin /usr/local/bin
COPY --from=node:20.6.1 /usr/local/lib /usr/local/lib

# 必要なパッケージのインストール
RUN apt-get update && \
    apt-get -y install \
    git \
    zip \
    unzip \
    vim \
    cron \
    && docker-php-ext-install pdo_mysql bcmath

# ワークディレクトリの設定
WORKDIR /var/www/html

# 依存関係のインストール
RUN composer install --no-dev --optimize-autoloader

# エントリポイントとしてスクリプトを設定
CMD ["/entrypoint.sh"]