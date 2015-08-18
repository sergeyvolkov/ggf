import Ember from 'ember';

export default Ember.Component.extend({
  // set score variable for each match
  matchesList: function() {
    const matches = this.get('matches');

    return matches.map( (match) => {
      const score = this.getMatchScore(match);

      match.set('score', score);

      return match;
    } );
  }.property('matches'),

  getMatchScore(match) {
    const homeScore = (match.get('status') !== 'not_started') ? match.get('homeScore') : '-';
    const awayScore = (match.get('status') !== 'not_started') ? match.get('awayScore') : '-';

    return `${homeScore} : ${awayScore}`;
  }
});
