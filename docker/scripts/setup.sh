#!/bin/bash -eu

"${PATH_SCRIPTS:?required}"/setup-permissions.sh

echo "PROJECT_DIR=${PROJECT_DIR:?}" &&
  echo "FLAG_DEVELOP=${FLAG_DEVELOP:?}" &&
  cd "$PROJECT_DIR" &&
  if [ "${FLAG_DEVELOP}" = 'true' ]; then
    echo 'No Optimization for Develop.'
  else
    echo 'Optimization for Production.' &&
      php artisan config:cache &&
      php artisan route:cache &&
      php artisan view:cache
  fi
