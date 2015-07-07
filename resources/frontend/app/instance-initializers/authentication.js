import Ember from 'ember';

var AuthenticationInitializer = {
  name: 'authentication',

  initialize: function (instance) {
    var store = instance.container.lookup('store:main'),
      Session = instance.container.lookup('simple-auth-session:main'),
            OAuth2 = instance.container.lookup('simple-auth-authenticator:oauth2-password-grant');

    Session.reopen({
      user: Ember.computed(function () {
        return this.get('secure').user;
      })
    });

    //OAuth2.reopen({
    //  makeRequest: function (url, data) {
    //
    //  }
    //});
  }
};

export default AuthenticationInitializer;