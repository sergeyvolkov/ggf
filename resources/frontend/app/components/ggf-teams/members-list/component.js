import Ember from 'ember';
import config from '../../../config/environment';

const {
  Component,
  A,
  computed,
  observer
} = Ember;

export default Component.extend({
  classNameBindings: [':collection'],

  store: Ember.inject.service(),

  team: null,

  emptyList: new A,

  actions: {
    assign: function(member) {
      this.sendAction('assign', member);
    },
    remove: function(member) {
      this.sendAction('remove', member);
    },
  },

  list: computed('team.teamMembers.@length', {
    get() {
      const tournament = this.get('team').get('tournament');
      const members = this.get('team').get('teamMembers');
      const membersAmount = members.get('length');

      let membersLeft = 0;

      this.set('emptyList', new A());

      switch (tournament.get('membersType')) {
        case 'single':
          membersLeft = 1 - membersAmount;

          break;
        case 'double':
          membersLeft = 2 - membersAmount;

          break;
      }

      while (membersLeft > 0) {
        this.get('emptyList').addObject(this.get('store').createRecord('teamMember', {
          teamId: this.get('team').get('id'),
          name: null
        }));

        membersLeft--;
      }

      return members;
    }
  })
});