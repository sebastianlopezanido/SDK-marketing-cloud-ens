FROM php:7.4-fpm

# Set working directory
WORKDIR /var/www/html/

# Install dependencies for the operating system software
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    libzip-dev \
    unzip \
    git \
    libonig-dev \
    curl \
    libaio1

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions for php
RUN docker-php-ext-install pdo pdo_mysql

# Install extensions for php
RUN docker-php-ext-install mbstring zip exif

# Install composer (php package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ARG APP_ENV

RUN if [ $APP_ENV = "local" ]; then \
  # Install the xdebug extension
  pecl install xdebug-2.9.1 \
      && docker-php-ext-enable xdebug \
      && echo "xdebug.remote_host="host.docker.internal"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
      && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
      && echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
      && echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
      && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
      && echo "xdebug.remote_connect_back=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
      && echo "xdebug.remote_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
      && echo "xdebug.extended_info=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
      && echo "xdebug.remote_autostart=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
      && echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
      && echo "xdebug.profiler_enable=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
      && echo "xdebug.profiler_output_dir=/tmp/snapshots" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
      && echo "xdebug.max_nesting_level=9999" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
      && echo "xdebug.profiler_enable_trigger=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
      && echo "xdebug.cli_color=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
      && echo "xdebug.remote_handler=dbgp" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
      && echo "xdebug.remote_mode=req" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
      && echo "xdebug.var_display_max_children=-1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
      && echo "xdebug.var_display_max_data=-1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
      && echo "xdebug.var_display_max_depth=-1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
;fi

# Copy existing application directory contents to the working directory
COPY . /var/www/html

# Assign permissions of the working directory to the www-data user
RUN chown -R www-data:www-data \
     /var/www/html/storage \
     /var/www/html/bootstrap/cache \
    /var/www/html/storage/logs


# Expose port 9000 and start php-fpm server (for FastCGI Process Manager)
EXPOSE 9000
CMD ["php-fpm"]
