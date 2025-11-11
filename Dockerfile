# Etapa 1: Imagen base
FROM php:8.3-apache

# Copia tus archivos del backend al contenedor
COPY . /var/www/html/

# Da permisos a Apache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expone el puerto 80
EXPOSE 80

# Inicia Apache
CMD ["apache2-foreground"]
