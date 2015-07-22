import DS from 'ember-data';

const {
  Model,
  attr
} = DS;

export default Model.extend({
  name:         attr('string'),
  description:  attr('string'),
  type:         attr('string'),
  status:       attr('string'),
  membersType:  attr('string'),
  teams:        DS.hasMany('teams', {async: false})
});
