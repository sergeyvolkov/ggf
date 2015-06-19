import Ember from 'ember';

export default Ember.Route.extend({
  model: function(params) {
    return this.store.all('tournament').findBy('id', params.tournamentId);
  },

  setupController: function(controller, model) {
    controller.set('tournament', model);
  }
});
