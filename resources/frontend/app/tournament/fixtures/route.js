import Ember from 'ember';

import ApplicationRouteMixin from 'simple-auth/mixins/application-route-mixin';

export default Ember.Route.extend(ApplicationRouteMixin, {
  setupController(controller) {
    const tournamentStatus = this.controllerFor('tournament').get('status');
    controller.set('tournamentStatus', tournamentStatus);
  },

  actions: {
    goToSettings() {
      this.transitionTo('tournament.settings');
    }
  }
});
