import Ember from 'ember';

export default Ember.Component.extend({
  selectedRound: {
    id:   -1,
    text: 'All rounds'
  },

  rounds: function() {
    const matches = this.get('matches');
    let rounds = [];

    const allRoundsOption = this.get('selectedRound');

    matches.forEach( (match) => {
      const round = match.get('round');

      // if property exists and doesn't saved in result array
      if (!round || rounds.contains(round)) {
        return false;
      }

      rounds.push(round);
    } );

    // format for select-2
    let roundsForSelect = rounds.map( (round) => {
      return {
        id:   round,
        text: round
      };
    } );

    roundsForSelect.unshift(allRoundsOption);

    return roundsForSelect;
  }.property('matches'),

  matchesList: function() {
    const matches = this.get('matches');
    const selectedRound = this.get('selectedRound.id');

    return matches
      .filter( (match) => {
        // use round filter
        if (selectedRound === -1) {
          return true;
        }

        return match.get('round') === selectedRound;
      } )
      .map( (match) => {
        // set score variable for each match
        const score = this.getMatchScore(match);

        match.set('score', score);

        return match;
    } );
  }.property('matches', 'selectedRound'),

  getMatchScore(match) {
    const homeScore = (match.get('status') !== 'not_started') ? match.get('homeScore') : '-';
    const awayScore = (match.get('status') !== 'not_started') ? match.get('awayScore') : '-';

    return `${homeScore} : ${awayScore}`;
  }
});
