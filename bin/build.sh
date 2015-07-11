#!/bin/bash

DIR="$( cd "$( dirname "$0" )" && pwd )"

cd $DIR/../resources/frontend

# Build Ember Application
echo "Build Ember (env: ${EMBER_ENV})"
./node_modules/.bin/ember build --environment=${EMBER_ENV}

# Copy
cp dist/index.html $DIR/../resources/views/app.blade.php
cp -r dist/assets $DIR/../public
cp -r dist/teams-logo $DIR/../public