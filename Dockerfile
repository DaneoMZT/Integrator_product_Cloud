FROM php:8.3-apache

# Copiar todos los archivos
COPY . /var/www/html/

# Cambiar la raíz del servidor a /var/www/html/public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Actualizar configuración de Apache para reconocer la nueva ruta
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Permitir index.html como página inicial
RUN echo "DirectoryIndex index.html index.php" >> /etc/apache2/apache2.conf

# Permisos
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]
