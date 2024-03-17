# Sử dụng image PHP chính thức của Laravel
FROM php:8.3-fpm

# Cài đặt các gói phụ thuộc cần thiết
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl

# Cài đặt Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Đặt thư mục làm thư mục làm việc
WORKDIR /var/www/html

# Copy file composer.json và composer.lock vào Docker image
COPY composer.json composer.lock ./

# Cài đặt các gói phụ thuộc của Composer
RUN composer install --no-scripts

# Copy toàn bộ mã nguồn của ứng dụng Laravel vào Docker image
COPY . .

# Chạy tất cả các script trong scripts/ của ứng dụng
RUN chmod -R 777 storage bootstrap/cache