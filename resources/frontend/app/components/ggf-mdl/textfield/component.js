import Ember from 'ember';

export default Ember.Component.extend({
  tagName: 'div',

  classNameBindings: [
    ':mdl-textfield', 'isUpgraded', 'isFocused', 'isDirty'
  ],

  name: '',
  label: '',
  value: '',

  focused: false,

  isDirty: Ember.computed('value', function() {
    return this.get('value').length > 0;
  }),

  isFocused: Ember.computed('focused', function() {
    return this.get('focused');
  }),

  isUpgraded () {
    return true;
  },

  actions: {
    focusOutInput() {
      this.set('focused', false);
    },
    focusInInput() {
      this.set('focused', true);
    }
  }
});
