import Ember from 'ember';

export default Ember.Component.extend({
  statistic: function() {
    let teams = this.get('teams'),
        matches = this.get('matches'),
        tablescore = {},
        self = this;

    teams.forEach(function(team) {
      tablescore[team] = self.getBasicStatForTeam(team);
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

    result = this.orderedTeams(result);

    return result;
  }.property(),

  getBasicStatForTeam: function(team) {
    return {
      name:             team,
      matches:          0,
      wins:             0,
      draws:            0,
      loses:            0,
      goalsScored:      0,
      goalsAgainsted:   0,
      goalsDifference:  0,
      points:           0
    };
  },

  // sort teams and set indexes
  orderedTeams: function(teams) {
    teams = this.sortTeams(teams);
    teams = this.setIndexesForSortedTeams(teams);

    return teams;
  },

  sortTeams: function(teams) {
    teams.sort(function(team1, team2) {
      if (team2.points === team1.points) {
        return team2.goalsDifference - team1.goalsDifference;
      }

      return team2.points - team1.points;
    });

    return teams;
  },

  setIndexesForSortedTeams: function(teams) {
    let startIndex = 1;

    teams.forEach(function(team) {
      team['index'] = startIndex++;
    });

    return teams;
  }

});
