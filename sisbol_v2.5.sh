#! /bin/bash

#define a senha do usuario "root" do mysql
mysqladmin -u root password vertrigo

mv /var/www/band /var/www/band_ant
mv /var/www/fckeditor /var/www/fckeditor_ant

#copia a nova pasta "band" para "/var/www"
cp -rvu band/ /var/www/

#copia a nova pasta "fckeditor" para "/var/www"
cp -rvu fckeditor/ /var/www/

cp /var/www/band_ant/alteracao/*.* /var/www/band/alteracao
cp /var/www/band_ant/backup/*.* /var/www/band/backup
cp /var/www/band_ant/boletim/*.* /var/www/band/boletim
cp /var/www/band_ant/ficha/*.* /var/www/band/ficha
cp /var/www/band_ant/import/*.* /var/www/band/import
cp /var/www/band_ant/nota_boletim/*.* /var/www/band/nota_boletim

#copia o arquivo "sisbol.ini" para a pasta "/var" 
cp -rvu sisbol.ini /var/

#copia o arquivo "geradb.sql" para a pasta "/var"
cp -vu geradb.sql /var/

FILE="/var/supervisor.ini"
if [ -f $FILE ] ; then echo "supervisor.ini ja existe!"
else
	touch /var/supervisor.ini
fi

#define o usuario "www-data" como dono da pasta "band", da pasta "fckeditor" e do arquivo "sisbol.ini"
chown -R www-data.www-data /var/www/band/
chown -R www-data.www-data /var/www/fckeditor/
chown www-data.www-data /var/sisbol.ini
chown www-data.www-data /var/supervisor.ini
chown www-data.www-data /var/geradb.sql

#altera as permissoes da pasta "band", da pasta "fckeditor" e do arquivo "sisbol.ini"
chmod -R 770 /var/www/band/
chmod -R 770 /var/www/fckeditor/
chmod 440 /var/sisbol.ini
chmod 440 /var/geradb.sql

#renomeia para "php.ini.old" o arquivo de configuracao "php.ini"
mv /etc/php5/apache2/php.ini /etc/php5/apache2/php.ini.old

#copia o novo arquivo de configuracao do php
cp php.ini /etc/php5/apache2/

#renomeia para "default.old" o arquivo de configuracao do servidor de paginas ("default")
mv /etc/apache2/sites-available/default /etc/apache2/sites-available/default.old

#copia o novo arquivo de configuracao do servidor de paginas
cp default /etc/apache2/sites-available/

#renomeia para "apache2.conf.old" o arquivo original de configuracao do apache (apache2.conf)
mv /etc/apache2/apache2.conf /etc/apache2/apache2.conf.old

#copia o arquivo de configuracao do apache para sua pasta default
cp apache2.conf /etc/apache2

#reinicia o servidor de paginas
/etc/init.d/apache2 stop
/etc/init.d/apache2 start

