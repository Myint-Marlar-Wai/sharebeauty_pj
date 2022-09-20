#!/bin/bash

#PROJECT_SOURCE_CACHE="$(date +%s)"
#echo "PROJECT_SOURCE_CACHE: $PROJECT_SOURCE_CACHE"

docker-compose build \
--build-arg APP_ENV=development \
--progress=plain

#--build-arg PROJECT_SOURCE_CACHE="$PROJECT_SOURCE_CACHE"

