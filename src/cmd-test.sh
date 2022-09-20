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
    print_style "   test <options>..."              "success"; printf "\t\t\t 現環境のテスト環境でテストを実行（ testing-<APP_ENV> として実行 ).\n"
    print_style "   test-by-env <env> <options>..." "success"; printf "\t 環境を指定してテストを実行.\n"
    print_style "   test-all-local <options>..."    "success"; printf "\t\t ローカルの全環境のテストを一括実行.\n"
    print_style "   hint"                           "success"; printf "\t\t\t\t\t hint.\n"
    print_style "   example"                        "success"; printf "\t\t\t\t example.\n"
}

exec_test_internal () {
    print_style "Clear config cache...\n" "info"
    php artisan config:clear
    php artisan route:clear
    print_style "Start test...\n" "info"
    php artisan test "${@}"
}

exec_test_by_env () {
    export APP_ENV="$1"
    if [[ ! $APP_ENV =~ ^testing-[a-z][a-z\-]*$ ]]; then print_style "Invalid APP_ENV $APP_ENV\n" 'danger'; exit 11; fi
    print_style "Set APP_ENV to ${APP_ENV}\n" "info"
    if [[ ! -e ".env.${APP_ENV}" ]]; then print_style "Not found APP_ENV $APP_ENV\n" 'danger'; exit 13; fi
    shift 1 # removing first argument
    exec_test_internal "${@}"
}

exec_test_envs () {
    local envNamesText
    envNamesText="$1"
    envNamesText=$(echo "$envNamesText" | tr -s ',' ' ')
    # shellcheck disable=SC2206
    envNames=( $envNamesText )
    for envName in "${envNames[@]}"
    do
        echo "APP_ENV $envName"
        if [[ ! $APP_ENV =~ ^[a-z][a-z\-]*$ ]]; then print_style "Invalid APP_ENV $envName\n" 'danger'; exit 11; fi
        if [[ ! -e ".env.${envName}" ]]; then print_style "Not found APP_ENV $envName\n" 'danger'; exit 13; fi
    done;
    for envName in "${envNames[@]}"
    do
        export APP_ENV="$envName"
        print_style "Set APP_ENV to ${APP_ENV}\n" "info"
        exec_test_internal
    done;
}

if [[ $# -eq 0 ]] ; then
    print_style "Missing arguments.\n" "danger"
    display_options
    exit 1
fi

if [ "$1" == "test" ] ; then
    print_style "Test...\n" "info"
    if [[ ! $APP_ENV =~ ^[a-z][a-z\-]*$ ]]; then print_style "Invalid APP_ENV $APP_ENV\n" 'danger'; exit 11; fi
    if [[ $APP_ENV =~ ^testing((-.*)|$) ]]; then print_style "Must not testing APP_ENV $APP_ENV\n" 'danger'; exit 12; fi
    export APP_ENV="testing-${APP_ENV}"
    print_style "Set APP_ENV to ${APP_ENV}\n" "info"
    if [[ ! -e ".env.${APP_ENV}" ]]; then print_style "Not found APP_ENV $APP_ENV\n" 'danger'; exit 13; fi
    shift 1 # removing first argument
    exec_test_internal "${@}"

elif [ "$1" == "test-by-env" ] ; then
    print_style "Test By Env...\n" "info"
    appEnv="$2"
    shift 2 # removing first argument
    exec_test_by_env "$appEnv" "${@}"

elif [ "$1" == "test-all-local" ] ; then
    print_style "Test All Local...\n" "info"
    shift 1 # removing first argument

    # SellerはCommonも含み、それ以外は固有のもののみ
    exec_test_by_env testing-local-seller-development --testsuite Seller      "${@}" || exit 1
    exec_test_by_env testing-local-shop-development   --testsuite Shop-Onlu   "${@}" || exit 1
    exec_test_by_env testing-local-admin-development  --testsuite Admin-Only  "${@}" || exit 1
    exec_test_by_env testing-local-batch-development  --testsuite Batch-Only  "${@}" || exit 1

    #envNamesText='testing-local-shop-development,testing-local-seller-development,testing-local-admin-development,testing-local-batch-development'
    #exec_test_envs "$envNamesText"

elif [ "$1" == "hint" ] ; then
    print_style "Show options...\n" "info"
    display_options

elif [ "$1" == "example" ] ; then
    print_style "Example...\n" "info"
    echo './cmd-test.sh test --stop-on-failure tests/Unit/EnvTest.php'
    echo './cmd-test.sh test --stop-on-failure --testsuite Common-Unit'
    echo './cmd-test.sh test --stop-on-failure --testsuite Seller'
    echo './cmd-test.sh test --stop-on-failure --testsuite Seller-Unit'
    echo './cmd-test.sh test-by-env testing-local-development --stop-on-failure tests/Unit/EnvTest.php'
    echo './cmd-test.sh test-by-env testing-local-development --stop-on-failure --testsuite Seller'
    echo './cmd-test.sh test-all-local'

else
    print_style "Invalid arguments.\n" "danger"
    display_options
    exit 1
fi
