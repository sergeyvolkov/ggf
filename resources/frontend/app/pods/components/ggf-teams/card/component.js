import Ember from 'ember';

const {computed, Component} = Ember;

export default Component.extend({

  removeState: false,

  isMenuAllowed: computed('session', 'team', function () {
    return this.get('team').get('tournament').get('isDraft') && this.get('session').get('isAuthenticated');
  }),

  actions: {

    toggleRemoveState() {
      this.set('removeState', !this.get('removeState'));
    },

    confirmRemove(team) {
      this.set('removeState', false);

      this.sendAction('remove', team);
    }
  }
});
