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

    let standingsModel;

    let rsvpHash = {
      matches: store.query('match', {tournamentId}),
      teams: store.query('team', {tournamentId}),
    };

    switch (tournament.get('type')) {
      case 'knock_out':
        rsvpHash['standing'] = store.find('standing', {tournamentId});
        break;
      case 'league':
      default:
        rsvpHash['tablescore'] = store.find('tablescore', {tournamentId});
        break;
    }


    return RSVP.hash(rsvpHash).then((hash) => {
      tournament.set('matches', hash.matches);
      tournament.set('teams', hash.teams);

      if (hash.tablescore) {
        tournament.set('tablescore', hash.tablescore);
      }

      if (hash.standing) {
        tournament.set('standing', hash.standing);
      }

      return tournament;
    });
  },

  setupController (controller, model) {
    this._super(controller, model);

    controller.set('tournament', model);
  }
});
