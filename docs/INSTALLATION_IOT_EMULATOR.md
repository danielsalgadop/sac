(iot_emulator) App scaffold:

    git clone https://github.com/danielsalgadop/iot_emulator
    composer install
    npm install


(iot_emulator)
- For simplicity database user, database name and table all are 'iot'

    php bin/console doctrine:database:create
    php bin/console doctrine:schema:create