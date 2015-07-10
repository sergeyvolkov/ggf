import Ember from 'ember';

let AuthenticationInitializer = {
  name: 'authentication',

  initialize: function (instance) {
    let Session = instance.container.lookup('simple-auth-session:main');

    Session.reopen({
      user: Ember.computed(function () {
        return this.get('secure.user');
      })
    });
  }
};

export default AuthenticationInitializer;