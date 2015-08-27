var EmberApp = require('ember-cli/lib/broccoli/ember-app');

module.exports = function(defaults) {
  var envConfig = require('./config/environment')(process.env.EMBER_ENV);

  var app = new EmberApp(defaults, {
    fingerprint: {
      exclude: ['teams-logo', 'leagues-logo'],
      enabled: envConfig.APP.fingerprintEnabled || false
    }
  });

  return app.toTree();
};
