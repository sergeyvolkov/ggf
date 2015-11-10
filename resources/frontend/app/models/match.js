import DS from 'ember-data';

const { attr, Model, belongsTo } = DS;

export default Model.extend({
  round: attr('number'),
  homeTeam: belongsTo('team', {async: false}),
  awayTeam: belongsTo('team', {async: false}),
  homeTeamId: attr('number'),
  awayTeamId: attr('number'),
  homeScore: attr('number'),
  awayScore: attr('number'),
  homePenaltyScore: attr('number'),
  awayPenaltyScore: attr('number'),
  status: attr('string'),
  tournamentId: attr('number')
});
