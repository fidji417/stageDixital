FROM php:7.2-fpm



# Ajouter l'alias ll
RUN echo "alias ll='ls -l'" >> /root/.bashrc


# Installer l'extension MongoDB pour PHP
RUN apt-get update && apt-get install -y \
    libssl-dev \
    libcurl4-openssl-dev \
    libmemcached-dev \
    pkg-config \
    libzip-dev \
    nano \
    git \
    busybox \
    libicu-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libxml2-dev \
    libxslt1-dev \
    libmagickwand-dev && \
    pecl install mongodb-1.11.0 memcached apcu imagick && \
    docker-php-ext-enable imagick mongodb memcached apcu && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Installer l'extension php
RUN docker-php-ext-install bcmath \
    pdo_mysql \
    opcache \
    soap \
    xml \
    xsl \
    dom \
    zip && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl && \
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-webp-dir=/usr/include/ && \
    docker-php-ext-install gd


# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installer le paquet mongodb/mongodb
WORKDIR /var/www/
#RUN composer require mongodb/mongodb
#RUN composer require phpmailer/phpmailer

SHELL ["/bin/bash", "-c"]
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.1/install.sh | bash && \
    source ~/.bashrc && \
    nvm install v10.24.1 && \
    nvm use v10.24.1

RUN apt-get update && apt-get install -y nano bash-completion

RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/*

RUN echo 'export PS1="\[\033[34m\][\u@\${SERVICE_NAME}:\w]\[\033[31m\] \$(git rev-parse --abbrev-ref HEAD 2>/dev/null)\[\033[0m\] "' >> /root/.bashrc

RUN echo "PROMPT_COMMAND='history -a' && history -r" >> /root/.bashrc


