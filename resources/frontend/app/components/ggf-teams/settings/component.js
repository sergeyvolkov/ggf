import Ember from 'ember';

export default Ember.Component.extend({
  tournament: null,

  name: Ember.computed.oneWay('tournament.name'),
  description: Ember.computed.oneWay('tournament.description'),
  type: Ember.computed.alias('tournament.type'),
  membersType: Ember.computed.alias('tournament.membersType'),

  actions: {
    save() {
      this.sendAction('submit', {
        name: this.get('name'),
        type: this.get('type'),
        membersType: this.get('membersType'),
        description: this.get('description'),
      });
    }
  }
});
