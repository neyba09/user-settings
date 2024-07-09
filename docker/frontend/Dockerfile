FROM node:lts-alpine

# устанавливаем зависимости проекта
WORKDIR /var/www
COPY ./vue/package*.json ./
RUN npm install

# копируем файлы и каталоги проекта в текущий рабочий каталог
COPY ./vue .

# собираем приложение для production с минификацией
EXPOSE 5173
CMD ["npm", "run", "dev"]
