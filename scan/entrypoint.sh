#!/bin/sh

envsubst '${SERVER_NAME}' < /etc/nginx/conf.d/default.template.conf > /etc/nginx/conf.d/default.conf

exec nginx -g "daemon off;"
