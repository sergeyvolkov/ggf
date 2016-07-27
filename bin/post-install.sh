#!/bin/bash

DIR="$( cd "$( dirname "$0" )" && pwd )"

cd $DIR/../

# Install npm dependencies
echo "NPM Install [backend]"
npm install

cd $DIR/../resources/frontend

# Install npm dependencies
echo "NPM Install [frontend]"
npm install

cd $DIR/../

sh bin/build.sh
