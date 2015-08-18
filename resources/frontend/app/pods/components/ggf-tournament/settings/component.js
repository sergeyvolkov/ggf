import Ember from 'ember';

export default Ember.Component.extend({
  tournament: null,

  name: Ember.computed.oneWay('tournament.name'),
  description: Ember.computed.oneWay('tournament.description'),
  status: Ember.computed.alias('tournament.status'),
  type: Ember.computed.alias('tournament.type'),
  membersType: Ember.computed.alias('tournament.membersType'),

  actions: {
    create() {
      const params = this.getProperties('name', 'description', 'type', 'membersType');

      this.sendAction('submit', params);
    },

    save() {
      const params = this.getProperties('name', 'description', 'type', 'membersType', 'status');

      this.sendAction('submit', params);
    }
  }
});
