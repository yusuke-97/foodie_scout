FROM php:8.2.3-fpm

# COPY php.ini と entrypoint.sh
COPY php.ini /usr/local/etc/php/php.ini
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

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

# Crontabファイルのコピーと設定
COPY my-crontab /etc/cron.d/my-crontab
RUN chmod 0644 /etc/cron.d/my-crontab
RUN crontab /etc/cron.d/my-crontab

# ワークディレクトリの設定
WORKDIR /var/www/html

# エントリポイントとしてスクリプトを設定
CMD ["/entrypoint.sh"]
