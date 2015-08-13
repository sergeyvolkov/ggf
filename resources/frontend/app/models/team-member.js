import DS from 'ember-data';

const {
  Model,
  belongsTo,
  attr
} = DS;

export default Model.extend({
  name: attr('string'),
  teamId: attr('number'),
  memberId: attr('number'),
  team: belongsTo('team', {async: false})
});
