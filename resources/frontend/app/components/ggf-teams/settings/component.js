import Ember from 'ember';

export default Ember.Component.extend({
  name: '',
  description: '',

  settingsName: Ember.computed.oneWay('name'),
  settingsDescription: Ember.computed.oneWay('description'),


  actions: {
    save() {

      this.sendAction('submit', {
        name: this.get('settingsName'),
        description: this.get('settingsDescription'),
      })
      //
      //this.set('name', '');
      //this.set('description', '');
    }
  }
});
