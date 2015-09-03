/* jshint node: true */

module.exports = function (environment) {

  var ENV = {
    modulePrefix: 'ggf',
    podModulePrefix: 'ggf/pods',
    environment: environment,
    baseURL: '/',
    locationType: 'hash',
    EmberENV: {
      FEATURES: {
        // Here you can enable experimental features on an ember canary build
        // e.g. 'with-controller': true
      }
    },

    APP: {
      // Here you can pass flags/options to your application instance
      // when it is created
      namespace: 'api/v1',
      host: '//' + process.env.APP_HOSTNAME
    },

    contentSecurityPolicy: {
      'connect-src': "'self' bam.nr-data.net " + process.env.APP_HOSTNAME,
      'img-src': "'self' bam.nr-data.net " + process.env.APP_HOSTNAME,
      'script-src': "'self' 'unsafe-inline' js-agent.newrelic.com bam.nr-data.net " + process.env.APP_HOSTNAME,
      'style-src': "'self' 'unsafe-inline' fonts.googleapis.com",
      'font-src': "'self' data: fonts.gstatic.com"
    },

    /* torii */
    torii: {
      // a 'session' property will be injected on routes and controllers
      sessionServiceName: 'session',
      providers: {
        'facebook-oauth2': {
          apiKey: process.env.FACEBOOK_APP_ID,
          redirectUri: process.env.FACEBOOK_REDIRECT_URI
        }
      }
    },

    flashMessageDefaults: {
      timeout: 5000,
      extendedTimeout: 0,
      priority: 200,
      showProgress: true,
    }
  };

  if (environment === 'production') {
    ENV.APP.fingerprintEnabled = true;
  }

  if (environment === 'development' || environment === 'local') {
    ENV.APP.host = 'http://' + process.env.APP_HOSTNAME;
  }

  if (environment === 'test') {
    // Testem prefers this...
    ENV.baseURL = '/';
    ENV.locationType = 'none';

    // keep test console output quieter
    ENV.APP.LOG_ACTIVE_GENERATION = false;
    ENV.APP.LOG_VIEW_LOOKUPS = false;

    ENV.APP.rootElement = '#ember-testing';
  }

  ENV['simple-auth'] = {
    crossOriginWhitelist: [ENV.APP.host],
    authorizer: 'simple-auth-authorizer:oauth2-bearer',
  };

  ENV['simple-auth-oauth2'] = {
    serverTokenEndpoint: ENV.APP.host + '/auth/facebook/token',
    serverTokenRevocationEndpoint: ENV.APP.host + '/auth/logout'
  }

  return ENV;
};
