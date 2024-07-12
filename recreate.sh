#/bin/sh

GREEN='\033[0;32m'
NC='\033[0m' 

docker compose up -d --build
docker compose exec api sh -c "composer install"
echo -e "=======================${GREEN}FINISHED!${NC}==========================="