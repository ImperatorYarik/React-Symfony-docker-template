#!/bin/sh

GREEN='\033[0;32m'
NC='\033[0m' 


docker compose exec api php bin/console cache:clear
docker compose exec api chmod -R 777 ./var


echo -e "=======================${GREEN}FINISHED!${NC}==========================="

