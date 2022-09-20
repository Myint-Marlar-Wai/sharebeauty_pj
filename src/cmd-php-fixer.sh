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
    print_style "   install"        "success"; printf "\t composer install .\n"
    print_style "   version"        "success"; printf "\t version.\n"
    print_style "   dry"            "success"; printf "\t\t dry run.\n"
    print_style "   dry-diff"       "success"; printf "\t dry run diff.\n"
    print_style "   fix"            "success"; printf "\t\t fix.\n"
    print_style "   list-targets"   "success"; printf "\t\t list files.\n"
}

if [[ $# -eq 0 ]] ; then
    print_style "Missing arguments.\n" "danger"
    display_options
    exit 1
fi

if [ "$1" == "install" ] ; then
    print_style "Installing...\n" "info"
    composer install --working-dir=tools/php-cs-fixer

elif [ "$1" == "version" ] ; then
    print_style "Showing version info...\n" "info"
    ./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --version

elif [ "$1" == "dry" ]; then
    print_style "Dry...\n" "info"
    shift # removing first argument
    ./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --verbose --dry-run "${@}"

elif [ "$1" == "dry-diff" ]; then
    print_style "Dry diff...\n" "info"
    shift # removing first argument
    ./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --verbose --diff --dry-run "${@}"

elif [ "$1" == "fix" ]; then
    print_style "Fix...\n" "info"
    shift # removing first argument
    ./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --verbose "${@}"

elif [ "$1" == "list-targets" ]; then
    print_style "List files...\n" "info"
    shift # removing first argument
    ./tools/php-cs-fixer/vendor/bin/php-cs-fixer list-files --config=.php-cs-fixer.dist.php "${@}"

elif [ "$1" == "dry-by-changes" ]; then
    print_style "List files...\n" "info"
    shift # removing first argument

#    git diff --name-only --diff-filter=ACMR | xargs -r -L 1 | grep '^src/' | sed -e 's|^src/||g'
#    ./tools/php-cs-fixer/vendor/bin/php-cs-fixer list-files --config=.php-cs-fixer.dist.php

#    ./tools/php-cs-fixer/vendor/bin/php-cs-fixer list-files --config=.php-cs-fixer.dist.php | \
#    xargs -r ./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix \
#    --config=.php-cs-fixer.dist.php --path-mode intersection -v --dry-run

    print_style "Diff...\n" "info"
    git diff --name-only --diff-filter=ACMR | xargs -r -L 1 | grep '^src/' | sed -e 's|^src/||g' | \
    xargs -r ./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix \
    --config=.php-cs-fixer.dist.php --path-mode intersection -v --dry-run

    print_style "Untracked...\n" "info"
    git ls-files --others --exclude-standard | \
    xargs -r ./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix \
    --config=.php-cs-fixer.dist.php --path-mode intersection -v --dry-run

else
    print_style "Invalid arguments.\n" "danger"
    display_options
    exit 1
fi
