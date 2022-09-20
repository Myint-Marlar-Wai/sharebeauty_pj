#!/bin/bash -eu

echo 'Reset project.' &&
  echo "PROJECT_DIR=${PROJECT_DIR:?}" &&
  cd "$PROJECT_DIR" &&
  rm -rf vendor &&
  rm -rf node_modules &&
  find bootstrap/cache -type f -not \( -name '.gitignore' -or -name '.gitkeep' \) -print0 | xargs -0 -r rm &&
  find storage -type f -not \( -name '.gitignore' -or -name '.gitkeep' \) -print0 | xargs -0 -r rm &&
  echo 'Finish reset project'
