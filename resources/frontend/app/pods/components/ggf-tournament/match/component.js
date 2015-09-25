import Ember from 'ember';

const {get, Component} = Ember;

export default Component.extend({
  match: null,

  editState: false,

  classNameBindings: [':row', ':col', ':s12'],

  actions: {

    confirmMatchResult: function() {
      const flashMessages = get(this, 'flashMessages');

      let match = this.get('match');

      match.set('status', 'finished');

      match.save().then(() => {
        this.set('editState', false);

        flashMessages.success('Match has been saved');
      }).catch(() => {
        flashMessages.danger('Unable to save the match');
        match.rollback();
      });
    },

    toggleOnEditState: function() {
      const session = this.get('session');

      if (session.isAuthenticated && false === this.get('editState')) {
        this.set('editState', !this.get('editState'));
      }
    },
    toggleOffEditState: function() {
      if (true === this.get('editState')) {
        this.get('match').rollback();

        this.set('editState', !this.get('editState'));
      }
    }
  }
});