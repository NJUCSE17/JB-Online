FROM php:7.3-cli

RUN apt-get update -yqq
RUN apt-get install -yqq build-essential git curl unzip
RUN apt-get install -yqq icu-devtools libicu-dev
RUN apt-get clean

RUN docker-php-ext-install bcmath intl pdo pdo_mysql

RUN curl --silent --show-error https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer global require laravel/envoy

RUN curl https://nodejs.org/dist/v12.13.0/node-v12.13.0-linux-x64.tar.xz | tar xJf - --exclude CHANGELOG.md --exclude LICENSE --exclude README.md --strip-components 1 -C /usr/local/
RUN npm install -g yarn