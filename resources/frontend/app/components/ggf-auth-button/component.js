import Ember from 'ember';

export default Ember.Component.extend({
  tagName: 'li',

  actions: {
    login() {
      this.sendAction('login', 'facebook-oauth2');
    },
    logout() {
      this.sendAction('logout');
    }
  }
});
