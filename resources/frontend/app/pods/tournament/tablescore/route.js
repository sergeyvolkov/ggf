import Ember from 'ember';

const {
  Route,
  RSVP
} = Ember;

export default Route.extend({

  model: function() {
    const store = this.store;
    const tournamentId = this.modelFor('tournament').get('id');

    return RSVP.hash({
      tournament: this.modelFor('tournament'),
      tablescore: store.query('tablescore', {tournamentId}),
      matches: store.query('match', {tournamentId}),
      teams: store.query('team', {tournamentId}),
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
