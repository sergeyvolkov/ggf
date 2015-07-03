import Ember from 'ember';

export default Ember.Route.extend({
  model: function(params) {
    return this.store.find('match', {tournamentId: params.tournamentId});
  },

  setupController: function(controller, model, transition) {
    let tournamentId = transition.params.tournament.tournamentId,
        tournament;

    tournament = this.store.all('tournament').findBy('id', tournamentId);

    controller.set('tournament', tournament);
    controller.set('matches', model);
  }
});
