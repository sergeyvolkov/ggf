import DS from 'ember-data';

const { Model, attr, belongsTo, hasMany } = DS;

export default Model.extend({

  tournament: belongsTo('tournament', {async: false}),

  round: DS.attr('number'),
  homeTeamId: DS.attr('number'),
  awayTeamId: DS.attr('number'),
  homeTeam: belongsTo('team', {async: false}),
  awayTeam: belongsTo('team', {async: false}),
  matches: hasMany('match', {async: false})
});
