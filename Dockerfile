# syntax=docker/dockerfile:1
FROM node:16.15.1
WORKDIR /app
COPY . .
RUN yarn install --production
CMD ["node", "src/index.js"]
EXPOSE 3000