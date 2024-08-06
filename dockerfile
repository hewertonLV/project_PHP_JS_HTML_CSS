FROM php:8.2-apache

# Instalar extensões necessárias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiar o código da aplicação para o diretório do Apache
COPY ./project /var/www/html/

# Instalação do módulo mod_rewrite do Apache
RUN a2enmod rewrite

# Copia o arquivo de configuração do Apache do seu projeto para o diretório correto no container
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Configurar permissões corretas
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Habilitar módulos do Apache se necessário
# RUN a2enmod rewrite

# Configuração do Apache para escutar em todos os endereços IP
RUN sed -i 's/Listen 80/Listen 0.0.0.0:80/' /etc/apache2/ports.conf

# Reinicia o serviço Apache
RUN service apache2 restart

# Comando para manter o Apache em execução em primeiro plano
CMD ["apache2-foreground"]