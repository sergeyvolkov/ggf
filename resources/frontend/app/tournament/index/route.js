import Ember from 'ember';

export default Ember.Route.extend({

  beforeModel: function() {
    return this.transitionTo('tournament.tablescore');
  },
  
  setupController (controller, model, transition) {
    let tournamentId = transition.params.tournament.tournamentId;
    let tournament = this.store.peekAll('tournament').findBy('id', tournamentId);

    controller.set('tournament', tournament);
    controller.set('matches', model);

    this._super(controller, model, transition);
  }
});
