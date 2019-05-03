FROM nanoninja/php-fpm

RUN docker-php-ext-install gettext soap calendar
RUN docker-php-ext-enable soap calendar

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \
    && composer global require hirak/prestissimo