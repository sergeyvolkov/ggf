import DS from 'ember-data';

export default DS.Model.extend({
  name:         DS.attr('string'),
  description:  DS.attr('string'),
  type:         DS.attr('string'),
  teams:        DS.attr('', {defaultValue: []})
});
