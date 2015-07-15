import Ember from 'ember';

export default Ember.Mixin.create({
  tagName: 'div',

  classNameBindings: [
    ':mdl-textfield', 'isUpgraded', 'isFocused', 'isDirty'
  ],

  name: '',
  label: '',
  value: '',

  focused: false,
  upgraded: false,
  disabled: false,

  id: Ember.computed('name', function() {
    return this.get('name') + '-id';
  }),

  isDirty: Ember.computed('value', function() {
    return this.get('value').length > 0;
  }),

  isFocused: Ember.computed.alias('focused'),

  isDisabled: Ember.computed.alias('disabled')
});