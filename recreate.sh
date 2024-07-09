#/bin/sh

GREEN='\033[0;32m'
NC='\033[0m' 

docker compose up -d --build
docker compose exec api -c sh 'composer install'
echo -e "=======================${GREEN}FINISHED!${NC}==========================="