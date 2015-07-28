import Ember from 'ember';

export default Ember.Component.extend({
  classNameBindings: [':tablescore-team'],

  name: Ember.computed('team', function() {
    return this.get('team').get('name');
  })
});
