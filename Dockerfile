FROM php:8.3-apache

# Copiar todos los archivos
COPY . /var/www/html/

# Cambiar la raíz del servidor a /var/www/html/public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Actualizar configuración de Apache para reconocer la nueva ruta
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Permitir index.html y index.php
RUN echo "<IfModule mod_dir.c>
    DirectoryIndex index.html index.php
</IfModule>" >> /etc/apache2/sites-available/000-default.conf

# Habilitar mod_rewrite para Angular SPA
RUN a2enmod rewrite
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Permisos
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]
