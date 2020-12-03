FROM php:8.0.0-fpm

LABEL maintainer="youngk"
LABEL email="784253179@163.com"

RUN echo "Asia/Shanghai" > /etc/timezone

#安装extension
RUN sed -i 's/deb.debian.org/mirrors.ustc.edu.cn/g' /etc/apt/sources.list \
    && sed -i 's|security.debian.org/debian-security|mirrors.ustc.edu.cn/debian-security|g' /etc/apt/sources.list \
    && apt-get update && apt-get install -y \
    apt-utils \
    git \
    #安装gd扩展依赖
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    #安装intl扩展依赖
    libicu-dev \
    #安装imagick扩展依赖
    imagemagick \
    #安装zip扩展依赖
    libzip-dev \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install -j$(nproc) intl \
    && docker-php-ext-install -j$(nproc) opcache \  
    && docker-php-ext-install -j$(nproc) mysqli \
    && docker-php-ext-install -j$(nproc) pdo_mysql \
    && docker-php-ext-install -j$(nproc) pcntl \
    && docker-php-ext-install -j$(nproc) zip \
    && docker-php-ext-install -j$(nproc) bcmath

RUN chmod -R 755 /var/log/

RUN curl -fsSL 'https://pecl.php.net/get/redis-5.3.2.tgz' -o redis-5.3.2.tgz \
    && tar -xvf redis-5.3.2.tgz \
    && rm redis-5.3.2.tgz \
    && ( \
    cd redis-5.3.2 \
    && /usr/local/bin/phpize \
    && ./configure  \
    && make \
    && make install \
    ) \
    && rm -r redis-5.3.2 \
    && docker-php-ext-enable redis

RUN php -r "copy('http://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer && \
    composer self-update && \
    composer config -g repo.packagist composer https://packagist.phpcomposer.com

RUN curl -fsSL 'https://pecl.php.net/get/swoole-4.5.9.tgz' -o swoole-4.5.9.tgz \
    && tar -xvf swoole-4.5.9.tgz \
    && rm swoole-4.5.9.tgz \
        && ( \
            cd swoole-4.5.9 \
            && /usr/local/bin/phpize \
            && ./configure  \
            && make \
            && make install \
        ) \
        && rm -r swoole-4.5.9 \
        && docker-php-ext-enable swoole

RUN git clone https://github.com/laruence/yaf.git \
    && ( \
        cd yaf \
        && /usr/local/bin/phpize \
        && ./configure  \
        && make \
        && make install \
    ) \
    && rm -r yaf \
    && docker-php-ext-enable yaf

CMD ["php-fpm"]