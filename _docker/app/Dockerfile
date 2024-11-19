FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libzip-dev \
      zip unzip \
      libxml2-dev \
      git && \
      docker-php-ext-install pdo_mysql && \
      docker-php-ext-install bcmath && \
      docker-php-ext-install gd && \
      docker-php-ext-install zip && \
      docker-php-ext-install xml && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer



# Чтобы следить за очередями и выполнять джобы в фоне нужен супервизор
RUN apt-get update
RUN apt-get install procps -y
RUN apt-get install supervisor -y
COPY ./_docker/app/supervisor/conf.d/laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf

#Устанавливаем и запускаем крон чтобы выполнялись задачи в шедулере ларавела
#добавляем задачу ежеминутного запуска шедулера ларавела
RUN apt-get install -y cron && cron
RUN (crontab -l ; echo "* * * * * /usr/local/bin/php /var/www/artisan schedule:run >> /dev/null 2>&1") | crontab
CMD ["cron", ""]

#устанавливаем московское время на сервере, но вообще это необязательно, можно просто в ларавел сменить таймзону

WORKDIR /var/www

#это не работает, нужно как-то сделать так, чтобы супервизор автоматически корректно запускался после подъёма контейнеров
CMD service supervisor start


#запускаем крон и php (без крона можно было бы php не запускаться, он как-то сам запускается,
#   но если cmd cron прописать то начинаются какие-то проблемы с запуском php, потому что команда cmd может быть только одна
#   и видимо она где-то еще запускается
CMD bash -c "service supervisor start && cron && php-fpm"
