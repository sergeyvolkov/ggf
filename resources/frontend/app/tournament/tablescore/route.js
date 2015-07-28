import Ember from 'ember';

const {
  Route,
  RSVP
} = Ember;

export default Route.extend({

  model: function() {
    let store = this.store;
    let tournamentId = this.paramsFor('tournament').id;

    return RSVP.hash({
      tournament: this.modelFor('tournament'),
      tablescore: store.query('tablescore', {tournamentId: tournamentId}),
      matches: store.query('match', {tournamentId: tournamentId}),
      teams: store.query('team', {tournamentId: tournamentId}),
    }).then((hash) => {

      hash.tournament.set('tablescore', hash.tablescore);
      hash.tournament.set('matches', hash.matches);
      hash.tournament.set('teams', hash.teams);

      return hash.tournament;
    });
  },

  setupController (controller, model) {
    this._super(controller, model);

    controller.set('tournament', model);
  }
});
