FROM php:8.2.3-fpm

# Viteのサーバーにローカルからアクセスするために開ける
EXPOSE 5173

# COPY php.ini
COPY ./php.ini /usr/local/etc/php/php.ini

# Composer install
COPY --from=composer:2.5.8 /usr/bin/composer /usr/bin/composer

# install Node.js
COPY --from=node:20.6.1 /usr/local/bin /usr/local/bin
COPY --from=node:20.6.1 /usr/local/lib /usr/local/lib

# エントリポイントスクリプトをイメージにコピー
COPY ./docker/php/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

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
COPY ./my-crontab /etc/cron.d/my-crontab
RUN chmod 0644 /etc/cron.d/my-crontab
RUN crontab /etc/cron.d/my-crontab

# ワークディレクトリの設定
WORKDIR /var/www/html

# エントリポイントとしてスクリプトを設定
ENTRYPOINT ["/entrypoint.sh"]
