import Ember from 'ember';

const { Component, computed } = Ember;

export default Component.extend({

  team: null,

  matches: new Ember.A(),

  scores: computed('matches', 'team', function () {
    let scores = new Ember.A();

    const matches = this.get('matches').sortBy('id');

    matches.forEach((match) => {
      const homeScore = (match.get('status') !== 'not_started') ? match.get('homeScore') : '-';
      const awayScore = (match.get('status') !== 'not_started') ? match.get('awayScore') : '-';

      if (match.get('homeTeam').get('id') === this.get('team').get('id')) {
        scores.push(homeScore);
      }

      if (match.get('awayTeam').get('id') === this.get('team').get('id')) {
        scores.push(awayScore);
      }
    });

    return scores;
  })

});
