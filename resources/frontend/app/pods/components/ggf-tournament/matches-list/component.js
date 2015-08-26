import Ember from 'ember';

export default Ember.Component.extend({
  rounds: function() {
    const matches = this.get('matches');
    let rounds = [];

    matches.forEach( (match) => {
      const round = match.get('round');

      // if property exists and doesn't saved in result array
      if (!round || rounds.contains(round)) {
        return false;
      }

      rounds.push(round);
    } );

    // format for select-2
    return rounds.map( (round) => {
      return {
        id:   round,
        text: round
      };
    } );
  }.property('matches'),

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
