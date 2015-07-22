import Ember from 'ember';

export default Ember.Component.extend({
  name:         '',
  description:  '',
  type:         'league', // tournament type
  membersType:  'single', // single or double

  actions: {
    saveTournament() {
      const params = this.getProperties('name', 'description', 'type', 'membersType');

      this.sendAction('create', params);
    }
  }
});
