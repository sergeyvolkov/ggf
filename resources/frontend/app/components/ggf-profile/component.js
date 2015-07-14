import Ember from 'ember';

export default Ember.Component.extend({

  classNameBindings: [
      ':ggf-profile'
  ],

  method: 'authenticate',

  actions: {
    facebookAuth () {
      console.log('auth');

      this.sendAction('method', 'facebook-oauth2');
    },

    invalidateSession () {
      this.sendAction();
    }
  }
});
