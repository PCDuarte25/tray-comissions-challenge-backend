FROM wyveo/nginx-php-fpm:php82

WORKDIR /var/www

COPY . .

COPY nginx.conf /etc/nginx/conf.d/default.conf

RUN chown -R nginx:nginx /var/www

RUN composer install --no-interaction

RUN php artisan key:generate

EXPOSE 80
