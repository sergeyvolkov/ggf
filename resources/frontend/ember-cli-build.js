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
      clientAllowedKeys: ['APP_HOSTNAME', 'NEW_RELIC_LICENSE_KEY', 'NEW_RELIC_APPLICATION_ID'],
      path: '../../.env'
    }
  };
  
  var app = new EmberApp(defaults, options);

  if (process.env.NEW_RELIC_LICENSE_KEY && process.env.NEW_RELIC_APPLICATION_ID) {
    app.options['inlineContent'] = {
      'new-relic': {
        file: './new-relic.js',
        postProcess: function (content) {
          return content
            .replace(/\{\{NEW_RELIC_LICENSE_KEY\}\}/g, process.env.NEW_RELIC_BROWSER_LICENSE_KEY)
            .replace(/\{\{NEW_RELIC_APPLICATION_ID\}\}/g, process.env.NEW_RELIC_BROWSER_APPLICATION_ID);
        }
      }
    }
  }

  return app.toTree();
};
