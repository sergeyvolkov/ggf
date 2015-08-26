import Ember from 'ember';

const {
  Component,
  A,
  computed
} = Ember;

export default Component.extend({
  store: Ember.inject.service(),

  team: null,

  emptyList: new A(),

  actions: {
    assign: function(member) {
      this.sendAction('assign', member);
    },
    remove: function(member) {
      this.sendAction('remove', member);
    }
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
        members.addObject(this.get('store').createRecord('teamMember', {
          teamId: this.get('team').get('id'),
          name: null
        }));

        membersLeft--;
      }

      return members;
    }
  })
});