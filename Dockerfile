# Start from Apache based PHP image
FROM php:apache

# Make sure git command is installed
RUN apt-get update && \
    apt-get install vim git -y

# Install additional PHP modules
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Download chatbot app
RUN cd /var/www/html && \
    git clone https://github.com/henryvredenburgh/Chatbot.git . && \
    chmod 600 .git && \
    cp -f homepage.php index.php
