import Ember from 'ember';

export default Ember.Route.extend({



  model: function(params) {
    return this.store.query('match', {tournamentId: params.tournamentId});
  },
  //
  //  let tournamentId = transition.params.tournament.tournamentId;
  //  let tournament = this.store.all('tournament').filterBy('id', tournamentId);
  //
  //  controller.set('tournament', tournament);
  //  controller.set('matches', model);
  //}

  setupController (controller, model, transition) {
    let tournamentId = transition.params.tournament.tournamentId;
    let tournament = this.store.peekAll('tournament').findBy('id', tournamentId);

    controller.set('tournament', tournament);
    controller.set('matches', model);
  }
});
