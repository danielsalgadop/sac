---- INSTALATION SYSTEM REQUIREMENTS

Hemos usado EC2 con conexiones ssh (amdinistracion del sistema), http (iot_emulator) https (sac).


como instalar phpunit, hasta que no lanzo el primer phpunit no lo instala

System requiremetns, PHP (y extensiones), nginx, mysql and npm:

- sudo apt-get install mysql-server nginx php php-mysql php7.2-xml npm php-curl php-fpm composer -y
- TODO: probar si vale composer a perlo, Needed composer (creo que instalado 'a pelo' ya que no vale con la manera sudo apt-get install composer)
- sudo apt-get install php-curl (actualy in iot_emulator, fixtures are done in a php script via curl)
- sudo a2enmod rewrite



Estoy instalando nginx, q pide php-fpm