import DS from 'ember-data';

const { Model, hasMany, belongsTo, attr } = DS;

export default Model.extend({
  name: attr('string'),
  logoPath: attr('string'),
  teamId: attr('number'),
  tournamentId: attr('number'),
  tournament: belongsTo('tournament', {async: false}),
  teamMembers: hasMany('team-member', {async: false})
});
