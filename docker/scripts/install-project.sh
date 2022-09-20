#!/bin/bash -eu

echo "PROJECT_DIR: ${PROJECT_DIR:?required!!}" && \
cd "$PROJECT_DIR" && \
echo "APP_ENV: ${APP_ENV:?required!!}" && \
APP_SYSTEM=$(${PATH_APP_SYSTEM_ECHO}) && \
echo "APP_SYSTEM: ${APP_SYSTEM:?required!!}" && \
ls -la && \
#cp .env."$APP_ENV" .env && \
#ls -la && \
if [ "${FLAG_DEVELOP}" = 'true' ]; then \
    echo 'Installing for Develop...' && \
    npm install && \
    composer install --no-dev --no-ansi && \
    BUILD_NPM_SCRIPT_NAME='development' && \
    echo 'Completed installation for Develop.'; \
 else \
    echo 'Installing for Production...' && \
    npm install && \
    composer install --optimize-autoloader --no-dev --no-ansi && \
    BUILD_NPM_SCRIPT_NAME='production' && \
    echo 'Completed installation for Production.'; \
fi && \
echo 'Building view resources...' && \
npm run whoami && \
FRONTEND_BUILD_DIRS=$( \
  find public -type d \
) && \
FRONTEND_BUILD_FILES=$( \
  find public -type f \( -path 'public/mix-manifest.json' -or -path 'public/*/*' \) \
) && \
echo "$FRONTEND_BUILD_DIRS" | xargs ls -l && \
echo "$FRONTEND_BUILD_DIRS" | xargs chmod go+w && \
echo "$FRONTEND_BUILD_FILES" | xargs ls -l && \
echo "$FRONTEND_BUILD_FILES" | xargs chmod go+w  && \
npm run "$BUILD_NPM_SCRIPT_NAME" -appsystem="$APP_SYSTEM" && \
FRONTEND_BUILD_DIRS=$( \
  find public -type d \
) && \
FRONTEND_BUILD_FILES=$( \
  find public -type f \( -path 'public/mix-manifest.json' -or -path 'public/*/*' \) \
) && \
echo "$FRONTEND_BUILD_DIRS" | xargs ls -l && \
echo "$FRONTEND_BUILD_FILES" | xargs ls -l && \
echo 'Reset permissions.' && \
echo "$FRONTEND_BUILD_DIRS" | xargs chmod go-w && \
echo "$FRONTEND_BUILD_FILES" | xargs chmod go-w && \
echo "$FRONTEND_BUILD_DIRS" | xargs ls -l && \
echo "$FRONTEND_BUILD_FILES" | xargs ls -l && \
echo 'Completed view build.'
