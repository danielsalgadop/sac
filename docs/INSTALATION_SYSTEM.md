---- INSTALATION SYSTEM REQUIREMENTS

Hemos usado EC2 con conexiones ssh (amdinistracion del sistema), http (iot_emulator) https (sac).


DUDA como instalar phpunit, hasta que no lanzo el primer phpunit no lo instala

System requiremetns, PHP (y extensiones), apache, mysql and npm:

- sudo apt-get install mysql-server apache2 php php-mysql php7.2-xml npm libapache2-mod-php php-curl composer -y
- TODO: probar si vale composer a perlo, Needed composer (creo que instalado 'a pelo' ya que no vale con la manera sudo apt-get install composer)
- sudo apt-get install php-curl (actualy in iot_emulator, fixtures are done in a php script via curl)
- sudo a2enmod rewrite
