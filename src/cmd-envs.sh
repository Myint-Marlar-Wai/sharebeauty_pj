#!/bin/bash

# prints colored text
print_style() {

    if [ "$2" == "info" ]; then
        COLOR="96m"
    elif [ "$2" == "success" ]; then
        COLOR="92m"
    elif [ "$2" == "warning" ]; then
        COLOR="93m"
    elif [ "$2" == "danger" ]; then
        COLOR="91m"
    else #default color
        COLOR="0m"
    fi

    STARTCOLOR="\e[$COLOR"
    ENDCOLOR="\e[0m"

    printf "$STARTCOLOR%b$ENDCOLOR" "$1"
}

display_options() {
    printf "Available options:\n"
    print_style "   update <map-json-file>" "success"; printf "\t build and deploy.\n"
    print_style "   build  <map-json-file>" "success"; printf "\t build.\n"
    print_style "   deploy"                 "success"; printf "\t\t\t deploy.\n"
    print_style "   example"                "success"; printf "\t\t\t example.\n"
    print_style "   hint"                   "success"; printf "\t\t\t\t hint.\n"
}

if [[ $# -eq 0 ]]; then
    print_style "Missing arguments.\n" "danger"
    display_options
    exit 1
fi

SCRIPT_DIR=$(cd "$(dirname "$0")" && pwd)
cd "${SCRIPT_DIR}" || exit 1
DEPLOY_DIR=$SCRIPT_DIR
ENVS_SRC_DIR="${SCRIPT_DIR}/envs"
ENVS_OUT_DIR="${ENVS_SRC_DIR}/out"
echo "ENVS_SRC_DIR=$ENVS_SRC_DIR"
echo "ENVS_OUT_DIR=$ENVS_OUT_DIR"
LF=$'\n'



exec_build() {
    local mapJsonFile
    mapJsonFile="$1"

    if [[ ! $mapJsonFile =~ ^.*\.json$ ]]; then print_style "Invalid map-json-file ${mapJsonFile}\n" 'danger'; exit 11; fi
    print_style "map-json-file ${mapJsonFile}\n" "info"
    if [[ ! -e "${mapJsonFile}" ]]; then print_style "Not found map-json-file ${mapJsonFile}\n" 'danger'; exit 13; fi

    local mapJson
    mapJson=$(
        cat "$mapJsonFile"
    )
    local mapKeys
    mapKeys=$(
        echo "$mapJson" |
            jq -s -r ' .[] | keys | .[] '
    )
    mkdir -p "${ENVS_OUT_DIR}"

    IFS_PREV=$IFS
    IFS=$'\n'
    for mapKey in ${mapKeys}; do
        #echo "Key: $mapKey"
        outEnvFile="${ENVS_SRC_DIR}/out/.env.${mapKey}"
        print_style "Out Env File: ${outEnvFile}\n" 'info'
        fileNames=$(
            echo "$mapJson" |
                jq -s -r \
                    --arg key "$mapKey" \
                    ' .[] | .[$key] | .[]'
        )
        outEnvData=''
        for fileName in ${fileNames}; do
            srcEnvFile="${ENVS_SRC_DIR}/${fileName}"
            print_style "Src Env File: ${srcEnvFile}\n" 'info'
            if [[ ! -e "${srcEnvFile}" ]]; then print_style "Not found src env file ${srcEnvFile}\n" 'danger'; exit 13; fi
            while read -r envRow; do
                envKey=nul
                envVal=null
                if echo "$outEnvData" | grep '^[a-zA-Z0-9_]\+=' >/dev/null; then
                    # shellcheck disable=SC2001
                    envRow=$(echo "$envRow" | sed -e 's/[ ]*=[ ]*/=/g')
                    # shellcheck disable=SC2001
                    envKey=$(echo "$envRow" | sed -e 's/^\([a-zA-Z0-9_]\+\)=\(.*\)$/\1/')
                    # shellcheck disable=SC2001
                    envVal=$(echo "$envRow" | sed -e 's/^\([a-zA-Z0-9_]\+\)=\(.*\)$/\2/')
                fi
                #echo "Key: '$envKey', Val: '$envVal'"
                if [ -n "$envKey" ] && echo "$outEnvData" | grep "^${envKey}=" >/dev/null; then
                    #echo "Replace Key: '$envKey', Val: '$envVal'"
                    # shellcheck disable=SC2001
                    envValForRgx=$(echo "$envVal" | sed -e "s#/#\\\\/#g" || exit 11)
                    # shellcheck disable=SC2001
                    outEnvData=$(echo "$outEnvData" | sed -e "s/^${envKey}=\(.*\)$/${envKey}=${envValForRgx}/g" || exit 11)
                else
                    #echo "Append '$envRow'"
                    outEnvData="${outEnvData}${envRow}$LF"
                fi
            done < "$srcEnvFile" || exit 12
            outEnvData="${outEnvData}$LF"
        done
        echo "$outEnvData" > "${outEnvFile}"
    done

    IFS=$IFS_PREV
}

exec_deploy() {
    print_style "Deploying files...\n" 'info'
    find "${ENVS_OUT_DIR}" -type f \( -name '.env' -or -name '.env.*' \)
    find "${ENVS_OUT_DIR}" -type f \( -name '.env' -or -name '.env.*' \) -print0 | xargs -0 -r -I {} mv {} "${DEPLOY_DIR}/"
}

exec_clear() {
    print_style "Clear out dir ${ENVS_OUT_DIR}\n" 'info'
    find "${ENVS_OUT_DIR}" -type f \( -name '.env' -or -name '.env.*' \)
    find "${ENVS_OUT_DIR}" -type f \( -name '.env' -or -name '.env.*' \) -print0 | xargs -0 -r rm
}

if [ "$1" == "update" ]; then
    print_style "Update...\n" "info"
    exec_clear
    exec_build "$2"
    exec_deploy

elif [ "$1" == "build" ]; then
    print_style "Building to out dir...\n" "info"
    exec_build "$2"

elif [ "$1" == "deploy" ]; then
    print_style "Deploying from out dir...\n" "info"
    exec_deploy

elif [ "$1" == "clear" ]; then
    print_style "Clearing...\n" "info"
    exec_clear

elif [ "$1" == "example" ]; then
    print_style "Show example...\n" "info"
    echo './cmd-envs.sh update envs/map-local.json'

elif [ "$1" == "hint" ]; then
    print_style "Show options...\n" "info"
    display_options

else
    print_style "Invalid arguments.\n" "danger"
    display_options
    exit 1
fi

