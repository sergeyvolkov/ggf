import Ember from 'ember';

export default Ember.Component.extend({
  tournament: null,

  name: Ember.computed.oneWay('tournament.name'),
  description: Ember.computed.oneWay('tournament.description'),
  status: Ember.computed.alias('tournament.status'),
  type: Ember.computed.alias('tournament.type'),
  membersType: Ember.computed.alias('tournament.membersType'),

  actions: {
    save() {
      this.sendAction('submit', {
        name: this.get('name'),
        type: this.get('type'),
        status: this.get('status'),
        membersType: this.get('membersType'),
        description: this.get('description'),
      });
    }
  }
});
