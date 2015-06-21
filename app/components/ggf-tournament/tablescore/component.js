import Ember from 'ember';

export default Ember.Component.extend({
  statistic: function() {
    let teams = this.get('teams'),
        matches = this.get('matches'),
        teamStatistic,
        tablescore = {};

    teamStatistic = {
      matches:          0,
      wins:             0,
      draws:            0,
      loses:            0,
      goalsScored:      0,
      goalsAgainsted:   0,
      goalsDifference:  0,
      points:           0
    };

    teams.forEach(function(team) {
      tablescore[team] = teamStatistic;
      tablescore[team]['name'] = team;
    });

    matches.forEach(function(match) {
      let homeTeam = match.get('homeTeam'),
          awayTeam = match.get('awayTeam'),
          homeScore = +match.get('homeScore'),
          awayScore = +match.get('awayScore'),
          homeTeamStats = tablescore[homeTeam],
          awayTeamStats = tablescore[awayTeam];

      if (match.get('status') !== 'finished') {
        return false;
      }

      if (homeScore > awayScore) {
        // home wins
        homeTeamStats['wins']++;
        awayTeamStats['loses']++;
      } else if (homeScore < awayScore) {
        // away wins
        homeTeamStats['loses']++;
        awayTeamStats['wins']++;
      } else {
        // draw, maybe
        homeTeamStats['draws']++;
        awayTeamStats['draws']++;
      }

      homeTeamStats['matches']++;
      awayTeamStats['matches']++;

      homeTeamStats['goalsScored'] += homeScore;
      awayTeamStats['goalsScored'] += awayScore;
      homeTeamStats['goalsAgainsted'] += awayScore;
      awayTeamStats['goalsAgainsted'] += homeScore;
      homeTeamStats['goalsDifference'] += (homeScore - awayScore);
      awayTeamStats['goalsDifference'] += (awayScore - homeScore);

      homeTeamStats['points'] = homeTeamStats['wins']*3 + homeTeamStats['draws'];
      awayTeamStats['points'] = awayTeamStats['wins']*3 + awayTeamStats['draws'];
    });

    return tablescore;
  }.property(),

  tablescore: function() {
    let result = [],
        statistic = this.get('statistic');

    for (let team in statistic) {
      if (!statistic.hasOwnProperty(team)) {
        continue;
      }

      result.push(statistic[team]);
    }

    return result;
  }.property()
});
