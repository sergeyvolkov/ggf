#!/bin/bash

DIR="$( cd "$( dirname "$0" )" && pwd )"

cd $DIR/../

npm install --dev

cd $DIR/../resources/frontend

# Install npm dependencies
echo "NPM Install"
npm install

# Install bower dependencies
echo "Bower Install"
./node_modules/.bin/bower install

# Build Ember Application
echo "Build Ember (env: ${EMBER_ENV})"
./node_modules/.bin/ember build --environment=${EMBER_ENV}

# Copy
cp dist/index.html $DIR/../resources/views/app.blade.php
cp -r dist/assets $DIR/../public
cp -r dist/teams-logo $DIR/../public