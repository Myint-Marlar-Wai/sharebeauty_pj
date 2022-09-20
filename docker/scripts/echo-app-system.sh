#!/bin/bash -eu

# shellcheck disable=SC2046
: "${PROJECT_DIR:?required!!}" && \
cd "$PROJECT_DIR" && \
: "${APP_ENV:?required!!}" && \
ENV_FILE=.env."$APP_ENV" && \
export $( grep -v '^#' "$ENV_FILE" | grep -v '^$' | sed -e 's/[ ]*=[ ]*/=/g' ) && \
echo "$APP_SYSTEM"
