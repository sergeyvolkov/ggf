import Ember from 'ember';

import RippleSupport from 'ember-material-lite/mixins/ripple-support';

export default Ember.Component.extend(RippleSupport, {

  name: null,
  value: null,
  groupValue: null,

  tagName: 'label',

  attributeBindings: ['disabled', 'for:id'],
  classNames: ['mdl-radio', 'mdl-js-radio', 'is-upgraded'],
  classNameBindings: [
    'isChecked:is-checked',
    'isDisabled:is-disabled'
  ],

  checked: false,
  disabled: false,

  id: Ember.computed('name', function() {
    return this.get('name') + '-id-' + this.get('value');
  }),

  isChecked: Ember.computed('checked', 'value', 'groupValue', function() {
    if (this.get('groupValue')) {
      return this.get('groupValue') === this.get('value')
    } else {
      return this.get('checked');
    }
  }),

  isFocused: Ember.computed.alias('focused'),

  isDisabled: Ember.computed.alias('disabled'),

  actions: {
    toggle: function() {
      if (this.get('disabled')) {
        return false;
      }

      this.set('checked', true);
      if (this.get('groupValue')) {
        this.set('groupValue', this.get('value'));
      }
    }
  }

});
