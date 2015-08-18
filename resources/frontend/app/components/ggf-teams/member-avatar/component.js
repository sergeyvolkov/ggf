import Ember from 'ember';

const {
  Component
} = Ember;

export default Component.extend({
  tagName: 'i',
  classNameBindings: [':circle', ':blue', ':mdi-action-account-box'],
  avatarPath: null,

  actions: {

  }
});
