import Ember from 'ember';

export default Ember.Component.extend({
  classNameBindings: [':collection-item', ':avatar'],

  member: null
});
