/* global require, module */

var EmberApp = require('ember-cli/lib/broccoli/ember-app');

var envConfig = require('./config/environment')(process.env.EMBER_ENV);

var app = new EmberApp({
  fingerprint: {
    exclude: ['teams-logo'],
    enabled: envConfig.APP.fingerprintEnabled || false
  }
});

// Use `app.import` to add additional libraries to the generated
// output files.
//
// If you need to use different assets in different
// environments, specify an object as the first parameter. That
// object's keys should be the environment name and the values
// should be the asset to use in that environment.
//
// If the library that you are including contains AMD or ES6
// modules that you would like to import into your application
// please specify an object with the list of modules as keys
// along with the exports of each module as its value.


// include material design lite
app.import(app.bowerDirectory + '/material-design-lite/material.min.css');

module.exports = app.toTree();
