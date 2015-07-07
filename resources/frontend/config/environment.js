/* jshint node: true */

module.exports = function(environment) {
  var ENV = {
    modulePrefix: 'ggf',
    environment: environment,
    baseURL: '/',
    locationType: 'auto',
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
      host: 'http://good-gateway-football.herokuapp.com'
    },
    contentSecurityPolicy: {
      'connect-src': "'self' good-gateway-football.herokuapp.com",
      'font-src': "'self' data: fonts.gstatic.com",
      'style-src': "'self' 'unsafe-inline' fonts.googleapis.com"
    },

    /* torii */
    torii: {
      // a 'session' property will be injected on routes and controllers
      sessionServiceName: 'session',
      providers: {
        'facebook-oauth2': {
          apiKey:      '681786761956246'
        }
      }
    }
  };

  if (environment === 'development') {
    // ENV.APP.LOG_RESOLVER = true;
    // ENV.APP.LOG_ACTIVE_GENERATION = true;
    // ENV.APP.LOG_TRANSITIONS = true;
    // ENV.APP.LOG_TRANSITIONS_INTERNAL = true;
    // ENV.APP.LOG_VIEW_LOOKUPS = true;

    ENV.baseURL = '/';
    ENV.APP.host = 'http://192.168.10.10';

    ENV.contentSecurityPolicy['connect-src'] = "'self' 192.168.10.10";
    ENV.APP.fingerprintEnabled = true;

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

  if (environment === 'production') {
    ENV.baseURL = '/';
    ENV.APP.fingerprintEnabled = true;
  }


  ENV['torii']['providers']['facebook-oauth2']['redirectUri'] = 'http://localhost:4200';

  ENV['simple-auth'] = {
    authorizer: 'simple-auth-authorizer:oauth2-bearer',
  };

  ENV['simple-auth-oauth2'] = {
    serverTokenEndpoint: ENV.APP.host+'/auth/facebook/token'
  }

  return ENV;
};
