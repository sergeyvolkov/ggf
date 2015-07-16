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
      matches: store.query('match', {tournamentId: tournamentId}),
      tournament: store.peekAll('tournament').findBy('id', tournamentId)
    });
  },

  setupController (controller, model) {
    this._super(controller, model);

    controller.set('tournament', model.tournament);
    controller.set('matches', model.matches);
  }
});
