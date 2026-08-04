FROM php:8.2-cli

WORKDIR /usr/src/app

COPY . .

EXPOSE 80

CMD ["php", "-S", "0.0.0.0:80", "router.php"]
