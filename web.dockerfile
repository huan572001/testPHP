FROM nginx:1.10.3

ADD vhost.conf /etc/nginx/conf.d/default.conf
