#!/bin/bash

"${PATH_SCRIPTS:?required}"/setup.sh || exit 1

echo 'Start apache'
apache2-foreground
echo 'Run Completed!!'

