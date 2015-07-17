import Ember from 'ember';

export default Ember.Component.extend({
  name: '',
  logoPath: '',

  classNames: ['ggf-league-add mdl-cell--12-col'],

  actions: {
    submit() {
      this.sendAction('submit', {
        name: this.get('name'),
        logoPath: this.get('logoPath'),
      });

      this.set('name', '');
      this.set('logoPath', '');
    }
  }
});
