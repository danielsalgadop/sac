---- 

all things have user:user password:password, if not they are meant not to be accesible

Restriction on actions and properties name!

(esto ira a las diferecncias entre modelo w3 y nuestro modelo) Cant set various properties at once

Cant retrieve recent executions or a specific action

Cant add web thing to a gateway

Cant mange subscriptions

To create a thing in iot_emulator we are assuming w3 model resource


Constrain to simplify action and property relationship. In our model a SET to a property is equal to execution of the action with that propery_name. property name === action/property_name. 

DUDA Victor, some way our iot_emulator is a gateway to all web things




---- INSTALATION

DUDA como instalar phpunit, hasta que no lanzo el primer phpunit no lo instala


System requiremetns, PHP (extensions) and npm:

- TODO: probar si vale composer a perlo, Needed composer (creo que instalado 'a pelo' ya que no vale con la manera sudo apt-get install composer)
- sudo apt-get install mysql-server -y
- sudo apt-get install php php-mysql php-xml npm -y
- sudo apt-get install php-curl (actualy in iot_emulator, fixtures are done in a php script via curl)


Development requirements

- sudo apt-get install httpie jq

(sac) App scaffold:

        git clone https://github.com/danielsalgadop/iot_emulator
        composer install

(iot_emulator) App scaffold:

    git clone https://github.com/danielsalgadop/iot_emulator
    composer install
    npm install



Facebook, create proyect and get FACEBOOK_APP_ID and FACEBOOK_SECRET

(sac) Create .env.local

- fill FACEBOOK_APP_ID and FACEBOOK_SECRET
- fill DATABASE_URL

Create .env.local with FB and Mysql credentials


Prepare Mysql:

(sac)
- For simplicity database user, database name and table all are 'sac'
- create user with privileges for

    - creating database 'sac'
    - accessing table 'sac' DDL ALTER, AND DML SELECT, INSERT, UPDATE, DELETE

(iot_emulator)
- For simplicity database user, database name and table all are 'iot'
- create database 'iot'
- create user with privileges for accessing database iot DDL ALTER, AND DML SELECT, INSERT, UPDATE, DELETE

    php bin/console doctrine:database:create
    php bin/console doctrine:schema:create



(Optional) fixtures for populating databases


    php bin/console doctrine:fixture:load -n


En algún sitio he empezado esto antes BUSCARLO!!

---- Tecnología usada
- Symfony4 etc..

----  Simplificaciones de modelo
Solo usar LAN iots


---- Get vs Find
https://tuhrig.de/find-vs-get/
Sin asumirlo en total detalle voy a seguir esta regla

"usar GET cuando SEGURO que devuelves algo y FIND cuando puede que o devuelvas resultado alguno"  

acabo de cambiarlo. SEARCH es buscar, FIND encontrar, asi que la versión de verdad es:

"usar GET cuando SEGURO que devuelves algo y SEARCH cuand puede que devuelvas resulatdo alguno"








___ MEJORAS

Add headers response 'Link: <model/>; rel="model"' 

More comples iot emuation. Using noSQL for hetorgenic structure


iot_emulator, add Action to iot, add Property to iot