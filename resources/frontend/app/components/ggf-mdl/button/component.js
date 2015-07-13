import Ember from 'ember';

import MdlButtonComponent from 'ember-material-lite/components/mdl-button';

import RippleSupport from 'ember-material-lite/mixins/ripple-support';
import layout from 'ember-material-lite/templates/components/mdl-button';
import computed from 'ember-new-computed';

export default Ember.Component.extend(RippleSupport, {

  tagName: 'button',
  icon: null,
  isColored: true,
  isRaised: false,
  isFloating: false,
  isPrimary: false,
  isMiniFab: false,
  isAccent: false,
  _isIconMode: computed('icon', 'isFloating', {
    get() {
      return !this.get('isFloating') && this.get('icon');
    }
  }),
  attributeBindings: ['disabled'],
  classNames: ['mdl-button', 'mdl-js-button'],
  classNameBindings: [
    'isMiniFab:mdl-button--mini-fab',
    'isAccent:mdl-button--accent',
    'isRaised:mdl-button--raised',
    '_isIconMode:mdl-button--icon',
    'isColored:mdl-button--colored',
    'isPrimary:mdl-button--primary',
    'isFloating:mdl-button--fab'],
  layout,

  click() {

    this.sendAction();
  }

});
