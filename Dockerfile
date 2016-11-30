FROM ubuntu:xenial

RUN apt-get update -qq -y && \
  apt-get install -y --no-install-recommends php7.0-cli php7.0-xml php7.0-mbstring php7.0-zip php7.0-curl curl ca-certificates && \
  apt-get clean && \
  rm -rf /var/lib/apt/lists/*

RUN curl -o /usr/local/bin/composer https://getcomposer.org/composer.phar && chmod +x /usr/local/bin/composer

COPY composer.json ./
COPY composer.lock ./

RUN composer install --no-scripts --no-autoloader --no-dev

COPY . ./

ENV SYMFONY_ENV=prod

RUN composer dump-autoload --optimize --no-dev && \
	composer run-script --no-dev post-install-cmd

EXPOSE 8080

CMD bin/console server:run 0.0.0.0:8080
