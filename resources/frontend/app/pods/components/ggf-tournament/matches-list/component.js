import Ember from 'ember';

export default Ember.Component.extend({
  selectedRound: {
    id:   -1,
    text: 'All rounds'
  },

  hideFinishedMatches: false,

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
    const hideFinishedMatches = this.get('hideFinishedMatches');

    return matches
      .filter( (match) => {
        const isMatchFinished = (match.get('status') === 'finished');
        const matchRound = match.get('round');

        // use match status filter
        if (hideFinishedMatches && isMatchFinished) {
          return false;
        }

        // is round filter enabled
        if (selectedRound === -1) {
          return true;
        }

        return matchRound === selectedRound;
      } )
      .map( (match) => {
        // set score variable for each match
        const score = this.getMatchScore(match);

        match.set('score', score);

        return match;
    } );
  }.property('matches', 'selectedRound', 'hideFinishedMatches'),

  getMatchScore(match) {
    const homeScore = (match.get('status') !== 'not_started') ? match.get('homeScore') : '-';
    const awayScore = (match.get('status') !== 'not_started') ? match.get('awayScore') : '-';

    return `${homeScore} : ${awayScore}`;
  }
});
