ARG PHP_VERSION
FROM php:${PHP_VERSION}

ARG workDir
ARG dirApp
ARG supervisordDir
ARG entrypoint
ARG user
ARG uid=1000

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    libssl-dev \
    libc-client-dev \
    libkrb5-dev \
    libbrotli-dev \  
    supervisor \ 
    libjpeg-dev \
    libfreetype6-dev

# Instalar Node.js e npm
# Escolha a versão LTS mais recente conforme necessário (exemplo: Node.js 18)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && node -v \
    && npm -v

# Limpar o cache do apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install zip \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install pdo_mysql mysqli

# Redis
RUN pecl install redis \
    && docker-php-ext-enable redis 

# Instalar Swoole
RUN pecl install swoole \
    && docker-php-ext-enable swoole    

# Obter o Composer mais recente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir diretório de trabalho
WORKDIR $workDir

# Configurar usuário
RUN useradd -G www-data,root -u $uid -d /home/$user $user \
    && mkdir -p /home/$user/.composer \
    && chown -R $user:$user /home/$user

RUN echo 'root:123' | chpasswd      

# Copiar configurações personalizadas do PHP
COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini

# Copiar arquivos da aplicação
COPY ${dirApp} .

# Instalar dependências do Composer
RUN composer update --no-interaction 

# Configurar Supervisor
COPY ${supervisordDir} /etc/supervisor/conf.d/supervisord.conf
COPY ${supervisordDir} /etc/supervisord.d/

# Copiar e configurar o entrypoint
COPY ${entrypoint} /usr/local/bin/entrypoint.sh 
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

USER $user
