import Ember from 'ember';

const {
  computed,
  getWithDefault
} = Ember;

const { escapeExpression } = Ember.Handlebars.Utils;
const { SafeString }       = Ember.Handlebars;

export default Ember.Component.extend({
  title: '',
  logoPath: '',

  classNames: ['mdl-card__title mdl-card--expand'],

  attributeBindings: ['style'],

  style: computed('logoPath', function() {
    const logoPath = getWithDefault(this, 'logoPath', 'transparent');
    const escapedCSS = escapeExpression(`background-image: url(${logoPath});`);
console.log('esca', escapedCSS);
    return new SafeString(escapedCSS);
  }).readOnly()
});
