FROM nginx:1.10

ENV TZ=Europe/Moscow

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
ADD ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www
