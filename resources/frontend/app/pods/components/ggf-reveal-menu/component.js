import Ember from 'ember';
import MaterializeButtonDropdown from 'ember-cli-materialize/components/md-btn-dropdown';
import layout from './template';

const { run: { scheduleOnce }, computed } = Ember;

export default MaterializeButtonDropdown.extend({
  layout,
  text: 'Button',
  classNames: ['dropdown-button', 'btn-floating', 'reveal-menu'],
  icon: 'mdi-navigation-more-vert',
  attributeBindings: [
    'inDuration', 'outDuration', 'hover', 'gutter', 'belowOrigin'
  ]
});
