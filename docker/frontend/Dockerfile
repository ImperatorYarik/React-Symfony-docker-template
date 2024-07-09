FROM node:20

WORKDIR /var/www/project/frontend

COPY package.json ./
COPY package-lock.json ./
RUN npm install --silent
RUN npm install react-scripts -g --silent
#RUN npm audit fix



