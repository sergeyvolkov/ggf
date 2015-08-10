import DS from 'ember-data';

const {
  Model,
  hasMany,
  attr
} = DS;

export default Model.extend({
  name:         attr('string'),
  logoPath:     attr('string'),
  teamId:       attr('number'),
  tournamentId: attr('number'),
  teamMembers:  hasMany('team-member', {async: false})
});
