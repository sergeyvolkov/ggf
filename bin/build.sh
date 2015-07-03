#!/bin/bash

DIR="$( cd "$( dirname "$0" )" && pwd )"

cd $DIR/../resources/frontend

# Install npm dependencies
echo "NPM Install"
npm install

# Install bower dependencies
echo "Bower Install"
./node_modules/.bin/bower install

# Build Ember Application
echo "Build Ember"
./node_modules/.bin/ember build