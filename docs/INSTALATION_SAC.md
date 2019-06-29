(sac) App scaffold:

        git clone https://github.com/danielsalgadop/sac
        composer install



Facebook, create proyect and get FACEBOOK_APP_ID and FACEBOOK_SECRET

(sac) Create .env.local

- fill FACEBOOK_APP_ID and FACEBOOK_SECRET
- fill DATABASE_URL


Create .env.local with FB and Mysql credentials


    php bin/console doctrine:database:create
    php bin/console doctrine:schema:create