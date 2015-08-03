import DS from 'ember-data';

const { Model, attr, hasMany } = DS;

export default Model.extend({
  name:     attr('string'),
  logoPath: attr('string'),
  teams:    hasMany('league-team', {async: false})
});
