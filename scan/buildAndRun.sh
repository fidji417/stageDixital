#!/bin/bash

COMPOSE_FILE="$HOME/dockernegocianplateform/docker-compose.yml"


case "$1" in
  build)
    docker-compose -f $COMPOSE_FILE build nginx php7.2 php8.1 mailhog mini-dns
   ;;
  up)

    ## Flush le cache windows depuis wsl
    cmd.exe /C ipconfig /flushdns
    docker-compose -f $COMPOSE_FILE up -d nginx php7.2 php8.1 mailhog mini-dns
    ;;
  down)
    ## Flush le cache windows depuis wsl
    cmd.exe /C ipconfig /flushdns
    docker-compose -f $COMPOSE_FILE down
    ;;
  t7)
    docker-compose -f $COMPOSE_FILE exec php7.2 /bin/bash
    ;;
  t8)
   docker-compose -f $COMPOSE_FILE exec php8.1 /bin/bash
   ;;
  *)
    echo -e "Usage: $0 {build|up|down|t7|t8}\r\n"
    echo -e "Etat des containers plateform negocian.cloud : \r\n"
    if [ -z "$1" ]; then
        docker-compose -f $COMPOSE_FILE ps
    exit 0
fi


    exit 1
esac
