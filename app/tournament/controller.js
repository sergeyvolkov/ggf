import Ember from 'ember';

export default Ember.Controller.extend({
  tournament: Ember.A(),
  matches:    Ember.A(),

  matchesForTeam: function() {
    // @todo need to merge with tablescore
    let matches = this.get('matches'),
        teams = this.get('tournament.teams'),
        matchesForTeam = {};

    teams.forEach(function(team) {
      matchesForTeam[team] = [];
    });

    matches.forEach(function(match) {
      let homeTeam = match.get('homeTeam'),
          awayTeam = match.get('awayTeam'),
          homeResult = '',
          awayResult = '',
          matchId = match.get('id');

      if (match.get('status') !== 'finished') {
        homeResult = awayResult = 'N'; // not finished yet
      } else if (homeTeam > awayTeam) {
        homeResult = 'W';
        awayResult = 'L';
      } else if (homeTeam < awayTeam) {
        homeResult = 'L';
        awayResult = 'W';
      } else {
        homeResult = awayResult = 'D';
      }

      matchesForTeam[homeTeam].push({
        matchId:  matchId,
        result:   homeResult
      });

      matchesForTeam[awayTeam].push({
        matchId:  matchId,
        result:   awayResult
      });
    });

  }.property()
});
