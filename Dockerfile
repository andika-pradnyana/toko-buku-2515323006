FROM  docker.io/dunglas/frankenphp:latest

RUN install-php-extensions pdo_mysql bcmath intl zip opcache
