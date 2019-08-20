#!/usr/bin/env bash


ssh -i ~/sac_sandbox/docs/socialaccesscontroller-paris.pem ubuntu@ec2-35-180-227-177.eu-west-3.compute.amazonaws.com; cd /var/www/sac;
 git pull origin master
