#!/bin/bash -eu

echo 'Setup project directory permissions.' &&
  echo "PROJECT_DIR=${PROJECT_DIR:?}" &&
  cd "$PROJECT_DIR" &&
  find storage -type d -print0 | xargs -0 chown www-data:www-data &&
  find storage -type d -print0 | xargs -0 chmod 775 &&
  find bootstrap/cache -type d -print0 | xargs -0 chown www-data:www-data &&
  find bootstrap/cache -type d -print0 | xargs -0 chmod 775 &&
  echo 'Finish setup project directory permissions.'
