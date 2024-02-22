FROM php:8.1-fpm
# Ajouter l'alias ll
RUN echo "alias ll='ls -l'" >> /root/.bashrc
# Installe l'extension MySQLi
RUN docker-php-ext-install mysqli

# Copie les fichiers de votre application dans le conteneur
COPY . /var/www/html


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
    libmagickwand-dev

# Installer l'extension PECL / PHP
RUN pecl install mongodb \
&& pecl install memcached \
&& pecl install apcu \
&& pecl install imagick

# Installer l'extension php
RUN docker-php-ext-enable imagick \
&& docker-php-ext-install bcmath \
&& docker-php-ext-install pdo_mysql \
&& docker-php-ext-install opcache \
&& docker-php-ext-install soap \
&& docker-php-ext-install xml \
&& docker-php-ext-install xsl \
&& docker-php-ext-install dom \
&& docker-php-ext-configure intl \
&& docker-php-ext-install intl \
&& docker-php-ext-install zip \
&& docker-php-ext-enable mongodb \
&& docker-php-ext-enable memcached \
&& docker-php-ext-enable apcu


RUN docker-php-ext-configure gd \
    --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd

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

