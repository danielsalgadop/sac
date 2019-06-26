---- 

all things have user:user password:password, if not they are meant not to be accesible

Restriction on actions and properties name!

(esto ira a las diferecncias entre modelo w3 y nuestro modelo) Cant set various properties at once

Cant retrieve recent executions or a specific action

Cant add web thing to a gateway

Cant mange subscriptions

To create a thing in iot_emulator we are assuming w3 model resource


Constrain to simplify action and property relationship. In our model a SET to a property is equal to execution of the action with that propery_name. property name === action/property_name. 

For SAC our iot_emulator acts as a gateway to all web things




---- INSTALATION

DUDA como instalar phpunit, hasta que no lanzo el primer phpunit no lo instala


System requiremetns, PHP (extensions) and npm:

- sudo apt-get install mysql-server -y
- sudo apt-get install php php-mysql php-xml npm libapache2-mod-php -y
- TODO: probar si vale composer a perlo, Needed composer (creo que instalado 'a pelo' ya que no vale con la manera sudo apt-get install composer)
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

Using DTO in iot_emulator for storing Credentials

"Confusion" when using same name for different concepts "dependiendo" of project, eg: ThingController, thing

# TFM - Daniel Salgado - SAC

## Terminology

WEB_THING:
A Web Thing is a digital representation of a physical object accessible via a RESTful Web API. As described in 
[link](https://www.w3.org/Submission/wot-model/)

## Differences with Web Thing  

- 1 user per Web Thing
- Nuestar app esta acoplada a Fb (no hay Interface para Repositorio de busqueda de )

## Fixture Data

Links for files used in creation of Web Things

- [general Web Thing definition](general_wt_definition.yaml) 
- [termostato](termostato.yaml) TODO revisar esta traduccion de termostato
- lamp
- garage door
 
## Convenciones (nombre no me convence)
----------------------

- 1 server will contain (simulate) all web Things
- Web Thing has root /{number}

----------------------
https://tuhrig.de/find-vs-get/
Sin asumirlo en total detalle voy a seguir esta regla

"usar GET cuando SEGURO que devuelves algo y FIND cuando puede que o devuelvas resultado alguno"  

acabo de cambiarlo. SEARCH es buscar, FIND encontrar, asi que la versión de verdad es:

"usar GET cuando SEGURO que devuelves algo y SEARCH cuand puede que devuelvas resulatdo alguno"
----------------------


## How we stick to W3 Web Thing Model

Although Web Thing may have different connection we implemented the: Direct connectivity (4.1), not conection via Gateway or Cloud Service

### Web Things requirements

5.1 Level 0 – MUST
- 5.1.1 R0.1 – A Web Thing MUST at least be an HTTP/1.1 server
  - NO: 1 unique server simulating all WT
- 5.1.2 R0.2 – A Web Thing MUST have a root resource accessible via an HTTP URL
  - YES
- 5.1.3 R0.3 – A Web Thing MUST support GET, POST, PUT and DELETE HTTP verbs
  - YES
- 5.1.4 R0.4 – A Web Thing MUST implement HTTP status codes 200, 400, 500
  - all but 500 (since WT have no webserver)
- 5.1.5 R0.5 – A Web Thing MUST support JSON as default representation
  - YES
- 5.1.6 R0.6 – A Web Thing MUST support GET on its root URL
  - YES

5.2 Level 1 – SHOULD
- 5.2.1 R1.1 – A Web Thing SHOULD use secure HTTP connections (HTTPS)
  - NO - Es sencillo quizás lo metamos más adelante
- 5.2.2 R1.2 – A Web Thing SHOULD implement the WebSocket Protocol
  - NO
- 5.2.3 R1.3 – A Web Thing SHOULD support the Web Things model
  - No lo acabo de entender a ver si al leer punto 6 se me aclara
- 5.2.4 R1.4 – A Web Thing SHOULD return a 204 for all write operations
  - YES
- 5.2.5 R1.5 – A Web Thing SHOULD provide a default human-readable documentation
  - NO
  
5.3 Level 2 – MAY
- 5.3.1 R2.1 – A Web Thing MAY support the HTTP OPTIONS verb for each of its resources
  - YES
- 5.3.2 R2.2 – A Web Thing MAY provide additional representation mechanisms (RDF, XML, JSON-LD)
  - NO
- 5.3.3 R2.3 – A Web Thing MAY offer a HTML-based user interface
  - NO
- 5.3.4 R2.4 – A Web Thing MAY provide precise information about the intended meaning of individual parts of the model
  -NO




## IOT_EMULATOR

### Technologies
Symfony 4
Mysql
It is an API, follows web thing
REST

### DDBB model
<poner foto aqui>

## Social Access Controller

### Technologies
Symfony 4
Mysql
Handlebars.js
Jquery-UI
Facebook
Guzzle

### DDBB model

<poner foto aqui>

## Mejoras
- Simular connectivity Hub and Cloud
- Preguntar a Sergio por el servicio
- Completar rutas de Web Thing, como búsqueda de raiz que devuelva array de Things 



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

More complex iot emuation. Using noSQL for hetorgenic structure

iot_emulator, add Action to iot, add Property to iot

Manage more than 1 owner (ddbb is thought to be extended in this way)
