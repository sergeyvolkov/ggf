import Ember from 'ember';
import DS from 'ember-data';

const { Model, attr, belongsTo, hasMany } = DS;

export default Model.extend({

  round: attr('string'),

  gameType: Ember.computed('matches', function() {
    if (!Ember.isArray(this.get('matches')) || Ember.isBlank(this.get('matches').get('firstObject'))) {
      return null;
    }

    return this.get('matches').get('firstObject').get('gameType');
  }),

  tournament: belongsTo('tournament', {async: false}),

  homeTeam: belongsTo('team', {async: false}),
  awayTeam: belongsTo('team', {async: false}),

  matches: hasMany('match', {async: false})
});
