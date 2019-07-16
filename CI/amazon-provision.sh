#!/usr/bin/env bash
ssh -i "socialaccesscontroller-paris.pem" ubuntu@ec2-35-180-227-177.eu-west-3.compute.amazonaws.com

ssh -i ~/dev/socialaccesscontroller-paris.pem ubuntu@ec2-35-180-227-177.eu-west-3.compute.amazonaws.com sudo apt-get update; sudo apt-get install mysql-server apache2 php php-mysql php7.2-xml npm libapache2-mod-php php-curl composer -y;


sudo cp /etc/mysql/debian.cnf /home/ubuntu/.my.cnf; sudo chown ubuntu:ubuntu /home/ubuntu/.my.cnf



ssh -i ~/dev/socialaccesscontroller-paris.pem ubuntu@ec2-35-180-227-177.eu-west-3.compute.amazonaws.com cd /var/www/; sudo mkdir -p /var/www/temp; sudo chown ubuntu:ubuntu /var/www/temp; cd /var/www/temp/; git clone https://github.com/danielsalgadop/sac.git; cd /var/www; sudo mv  /var/www/temp/sac /var/www;  sudo rm -rf /var/www/temp

mysql -D mysql -e "CREATE USER 'sac'@'localhost' IDENTIFIED BY 'sac'; GRANT ALL PRIVILEGES ON sac.* TO
'sac'@'localhost'; FLUSH PRIVILEGES"

cd /var/www/sac; composer install; php bin/console doctrine:database:create; php bin/console doctrine:schema:create;

ssh -i ~/dev/socialaccesscontroller-paris.pem ubuntu@ec2-35-180-227-177.eu-west-3.compute.amazonaws.com cd
/var/www/sac;  git pull origin master