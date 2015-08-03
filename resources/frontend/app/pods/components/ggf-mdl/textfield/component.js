import Ember from 'ember';
import TextfieldMixin from './mixin';

export default Ember.Component.extend(TextfieldMixin, {
  actions: {
    focusOutInput() {
      this.set('focused', false);
    },
    focusInInput() {
      this.set('focused', true);
    }
  }
});
