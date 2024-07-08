#/bin/sh

GREEN='\033[0;32m'
NC='\033[0m' 

docker compose up -d --build

echo -e "=======================${GREEN}FINISHED!${NC}==========================="