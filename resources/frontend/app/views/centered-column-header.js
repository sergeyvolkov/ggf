import Ember from 'ember';
import DefaultHeaderView from 'ember-cli-materialize/views/default-column-header';
import layout from '../templates/centered-column-header';

export default DefaultHeaderView.extend({
  classNameBindings: [':centered', ':min'],
  layout
});