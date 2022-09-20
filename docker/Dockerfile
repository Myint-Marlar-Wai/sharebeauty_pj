# https://github.com/docker-library/docs/blob/master/php/README.md#supported-tags-and-respective-dockerfile-links
# https://github.com/docker-library/php/blob/5d0a0578db9e923bfbb72efc443d7c254a0fae44/7.4/bullseye/apache/Dockerfile
# https://github.com/docker-library/php/blob/master/7.4/bullseye/apache/Dockerfile
FROM php:8.1.8-apache

RUN apt-get update  && \
    apt-get install apt-utils curl gnupg -y && \
    curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs && \
    mkdir -p /usr/share/man/man1 && \
    apt-get install gcc pkg-config libmagickwand-dev imagemagick \
    nodejs python make g++ git unzip zip libzip-dev libcurl4-openssl-dev libc-client-dev libkrb5-dev autoconf \
    default-jre-headless cron p7zip-full vim zlib1g-dev mariadb-client \
    libfreetype6-dev libjpeg62-turbo-dev libpng-dev libwebp-dev \
    libmemcached-dev jq \
    -y && \
    printf "\n" | pecl install memcached redis imagick && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer && \
    docker-php-ext-install pdo_mysql iconv bcmath curl opcache zip && \
    docker-php-ext-enable memcached redis && \
    docker-php-ext-configure gd \
#    --with-png=/usr/include/ \
    --with-jpeg=/usr/include/ \
    --with-freetype=/usr/include/ && \
    docker-php-ext-install -j$(nproc) gd && \
    cd /etc/apache2/mods-enabled && \
    ln -s ../mods-available/rewrite.load ./

#    ln -s /dev/stdout /var/log/apache2/access_atslp.log && \
#    ln -s /dev/stdout /var/log/apache2/access_crmlp.log && \
#    ln -s /dev/stdout /var/log/apache2/access_firstlp.log && \
#    ln -s /dev/stdout /var/log/apache2/access_top.log && \
#    ln -s /dev/stderr /var/log/apache2/error_atslp.log && \
#    ln -s /dev/stderr /var/log/apache2/error_crmlp.log && \
#    ln -s /dev/stderr /var/log/apache2/error_firstlp.log && \
#    ln -s /dev/stderr /var/log/apache2/error_top.log

# Default Time Zone
RUN ln -sf /usr/share/zoneinfo/Japan /etc/localtime

COPY ./docker/uploads.ini /usr/local/etc/php/conf.d/uploads.ini
COPY ./docker/apache2.conf /etc/apache2/apache2.conf
COPY ./docker/000-default.conf /etc/apache2/sites-available/000-default.conf

ENV PATH_SCRIPTS /usr/local/bin
COPY ./docker/scripts/*.sh /usr/local/bin/

RUN chmod 755 /usr/local/bin/run.sh && \
    chmod 755 /usr/local/bin/setup.sh  && \
    chmod 755 /usr/local/bin/setup-permissions.sh  && \
    chmod 755 /usr/local/bin/install-project.sh && \
    chmod 755 /usr/local/bin/reset-project.sh && \
    chmod 755 /usr/local/bin/echo-app-system.sh

# Not Caching after this action
#ADD "https://www.random.org/strings/?num=10&len=8&digits=on&upperalpha=on&loweralpha=on&unique=on&format=plain&rnd=new" uuid
# 引数を変えることでソースコードのキャッシュを更新
# 例えば、docker build --build-arg PROJECT_SOURCE_CACHE=$(date +%s)
# 例えば、docker build --build-arg PROJECT_SOURCE_CACHE=datetime-2021-0216-0128
ARG PROJECT_SOURCE_CACHE=1
RUN echo "PROJECT_SOURCE_CACHE: $PROJECT_SOURCE_CACHE"

ENV PROJECT_DIR /var/www/onceec-web
ENV PATH_APP_SYSTEM_ECHO /usr/local/bin/echo-app-system.sh

RUN mkdir -p $PROJECT_DIR && \
    chown www-data:www-data $PROJECT_DIR && \
    chmod 777 $PROJECT_DIR && \
    ls -la /var/www/

COPY ./src $PROJECT_DIR

#RUN chmod -R guo+rwx $PROJECT_DIR/public
#RUN chown www-data:www-data $PROJECT_DIR/public

# App-Env
# APP_ENV ex. production, staging, development
ARG APP_ENV
ENV APP_ENV $APP_ENV

# Default false, false is optimization, true is no optimization.
ARG FLAG_DEVELOP=false
ENV FLAG_DEVELOP $FLAG_DEVELOP

# Check for mandatory build arguments and show env.
RUN : "${APP_ENV:?required!!}" && \
    APP_SYSTEM="$($PATH_APP_SYSTEM_ECHO)" && \
    APP_SYSTEM="${APP_SYSTEM:?required!!}" && \
    if ! expr "$APP_SYSTEM" : '^[a-z][a-z0-9_\-]*$' > /dev/null ; then echo "不正なAPP_SYSTEM $APP_SYSTEM" ; exit 2; fi && \
    echo "APP_ENV: '$APP_ENV'" && \
    echo "App System: '$APP_SYSTEM'" && \
    echo "Show Date" && date && \
    echo "Show Locale" && locale

# Reset project
RUN /usr/local/bin/reset-project.sh

# Install project
RUN /usr/local/bin/install-project.sh

RUN /usr/local/bin/setup.sh

WORKDIR $PROJECT_DIR

CMD ["/usr/local/bin/run.sh"]
