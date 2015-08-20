import Ember from 'ember';
import MaterializeButton from 'ember-cli-materialize/components/md-btn';
import layout from './template';

const { run: { scheduleOnce }, computed } = Ember;

export default MaterializeButton.extend({
  layout,
  tagName: 'a',
  text: 'Button',
  classNames: ['dropdown-button', 'btn-floating', 'reveal-menu'],
  icon: 'mdi-navigation-more-vert',
  iconPosition: 'right',
  attributeBindings: [
    'inDuration', 'outDuration', 'hover', 'gutter', 'belowOrigin'
  ],

  didInsertElement() {
    this._super(...arguments);
    scheduleOnce('afterRender', this, this._setupDropdown);
  },

  _setupDropdown() {
    // needed until the Materialize.dropdown plugin is replaced
    this.$().attr('data-activates', this.get('_dropdownContentId'));

    this.$().dropdown({
      hover: !!this.getWithDefault('hover', false),
      constrain_width: false,
      inDuration: this.getWithDefault('inDuration', this.get('_mdSettings.dropdownInDuration')),
      outDuration: this.getWithDefault('outDuration', this.get('_mdSettings.dropdownOutDuration')),
      gutter: this.getWithDefault('gutter', 0),
      belowOrigin: !!this.getWithDefault('belowOrigin', false)
    });
  },
  _dropdownContentId: computed(function() {
    return `${this.get('elementId')}-dropdown-content`;
  })
});
