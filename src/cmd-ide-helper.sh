#!/bin/bash

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
    print_style "   base"  "success"; printf "\t\t Generate Base.\n"
    print_style "   models"  "success"; printf "\t Generate Models.\n"
}

if [[ $# -eq 0 ]] ; then
    print_style "Missing arguments.\n" "danger"
    display_options
    exit 1
fi

if [ "$1" == "base" ] ; then
    print_style "Exec Base...\n" "info"
    php artisan ide-helper:generate
    php artisan ide-helper:meta

elif [ "$1" == "models" ]; then
    print_style "Exec Models...\n" "info"
    # --nowrite or --write
    php artisan ide-helper:models --nowrite

else
    print_style "Invalid arguments.\n" "danger"
    display_options
    exit 1
fi
