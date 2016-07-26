import Ember from 'ember';

const {
  Route,
  RSVP
} = Ember;

export default Route.extend({

  model: function() {
    const store = this.store;
    const tournament = this.modelFor('tournament');

    const tournamentId = tournament.get('id');

    let rsvpHash = {
      matches: store.query('match', {tournamentId}),
      teams: store.query('team', {tournamentId}),
    };

    switch (tournament.get('type')) {
      case 'knock_out':
        rsvpHash['standings'] = store.query('standing', {tournamentId});
        break;
      case 'league':
        rsvpHash['tablescore'] = store.query('tablescore', {tournamentId});
        break;
      default:
        break;
    }


    return RSVP.hash(rsvpHash).then((hash) => {
      tournament.set('matches', hash.matches);
      tournament.set('teams', hash.teams);
      tournament.set('tablescore', new Ember.A());
      tournament.set('standings', new Ember.A());

      if (hash.tablescore) {
        tournament.set('tablescore', hash.tablescore);
      }

      if (hash.standings) {
        tournament.set('standings', hash.standings);
      }

      return tournament;
    });
  }
});
