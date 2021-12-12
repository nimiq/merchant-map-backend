#!/bin/bash

if [ -z "$1" ]
then
    echo "Docker container not specified. Try again with ./terminal.sh php|postgres|nginx"
else
    if [ "$1" == "php" ]; then
        docker exec -it nimiq-shop-directory-backend-php sh
    elif [ "$1" == "postgres" ]; then
        docker exec -it nimiq-shop-directory-backend-postgres sh
    elif [ "$1" == "nginx" ]; then
        docker exec -it nimiq-shop-directory-backend-nginx sh
    fi
fi