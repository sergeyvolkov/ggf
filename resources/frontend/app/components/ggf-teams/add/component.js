import Ember from 'ember';

export default Ember.Component.extend({
  name: '',

  actions: {
    submit() {
      this.sendAction('submit', {
        name: this.get('name')
      });
    }
  }
});
