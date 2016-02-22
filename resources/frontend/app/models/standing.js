import DS from 'ember-data';

const { Model, attr, belongsTo, hasMany } = DS;

export default Model.extend({

  round: attr('string'),

  tournament: belongsTo('tournament', {async: false}),

  homeTeam: belongsTo('team', {async: false}),
  awayTeam: belongsTo('team', {async: false}),

  matches: hasMany('match', {async: false})
});
