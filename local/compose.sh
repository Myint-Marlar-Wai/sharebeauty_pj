#!/bin/bash

# This shell script is an optional tool to simplify
# the installation and usage of laradock with volume.

# To run, make sure to add permissions to this file:
# chmod 755 sync.sh

# USAGE EXAMPLE:
# Start sync and services with nginx and mysql: ./compose.sh up nginx mysql
# Stop containers and sync: ./compose.sh down

# prints colored text
print_style () {

    if [ "$2" == "info" ] ; then
        COLOR="96m"
    elif [ "$2" == "success" ] ; then
        COLOR="92m"
    elif [ "$2" == "warning" ] ; then
        COLOR="93m"
    elif [ "$2" == "danger" ] ; then
        COLOR="91m"
    else #default color
        COLOR="0m"
    fi

    STARTCOLOR="\e[$COLOR"
    ENDCOLOR="\e[0m"

    printf "$STARTCOLOR%b$ENDCOLOR" "$1"
}

display_options () {
    printf "Available options:\n";
    print_style "   up [services]" "success"; printf "\t Starts runs docker compose in detached mode.\n"
    print_style "   up-a [services]" "success"; printf "\t Starts runs docker compose in attached mode.\n"
    print_style "   build [services]" "success"; printf "\t Build docker.\n"
    print_style "   stop" "success"; printf "\t\t\t Stops containers.\n"
    print_style "   down" "success"; printf "\t\t\t Downs containers.\n"
    print_style "   bash" "success"; printf "\t\t\t Opens bash on the workspace with user laradock.\n"
}

if [[ $# -eq 0 ]] ; then
    print_style "Missing arguments.\n" "danger"
    display_options
    exit 1
fi

if [ "$1" == "up" ] ; then
    print_style "Initializing Docker Compose in Detached mode.\n" "info"
    shift # removing first argument
    docker-compose up -d "${@}"

elif [ "$1" == "up-a" ] ; then
    print_style "Initializing Docker Compose in Attached mode.\n" "info"
    shift # removing first argument
    docker-compose up "${@}"

elif [ "$1" == "build" ] ; then
    print_style "Building Docker Compose\n" "info"
    shift # removing first argument
    docker-compose build "${@}"

elif [ "$1" == "stop" ]; then
    print_style "Stopping Docker Compose\n" "info"
    docker-compose stop

elif [ "$1" == "down" ]; then
    print_style "Downing Docker Compose\n" "info"
    docker-compose down

elif [ "$1" == "bash" ]; then
#    docker-compose exec --user=laradock workspace bash
    docker-compose exec workspace bash

else
    print_style "Invalid arguments.\n" "danger"
    display_options
    exit 1
fi
