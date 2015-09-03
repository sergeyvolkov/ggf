var EmberApp = require('ember-cli/lib/broccoli/ember-app');

module.exports = function(defaults) {
  var envConfig = require('./config/environment')(process.env.EMBER_ENV);

  var options = {
    fingerprint: {
      exclude: ['teams-logo', 'leagues-logo'],
      enabled: envConfig.APP.fingerprintEnabled || false
    },
    sassOptions: {
      includePaths: ['bower_components/materialize/sass']
    },
    dotEnv: {
      clientAllowedKeys: ['NEW_RELIC_LICENSE_KEY', 'NEW_RELIC_APPLICATION_ID'],
      path: '../../.env'
    }
  };

  if (envConfig.newRelic) {

    options['inlineContent'] = {
      'new-relic': {
        file: './new-relic.js',
        postProcess: function (content) {
          return content
            .replace(/\{\{NEW_RELIC_LICENSE_KEY\}\}/g, envConfig.newRelic.licenseKey)
            .replace(/\{\{NEW_RELIC_APPLICATION_ID\}\}/g, envConfig.newRelic.applicationID);
        }
      }
    }
  }

  var app = new EmberApp(defaults, options);

  return app.toTree();
};
