import Ember from 'ember';

import ApplicationRouteMixin from 'simple-auth/mixins/application-route-mixin';

export default Ember.Route.extend(ApplicationRouteMixin, {
  model() {
    const tournamentId = this.modelFor('tournament').get('id');
    return this.store.find('match', {tournamentId, status: 'not_started'});
  },

  setupController(controller, model) {
    this._super(controller, model);

    const tournamentStatus = this.controllerFor('tournament').get('status');
    controller.set('tournamentStatus', tournamentStatus);
  },

  actions: {
    goToSettings() {
      this.transitionTo('tournament.settings');
    }
  }
});
