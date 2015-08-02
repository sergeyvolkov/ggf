import Ember from 'ember';
import ApplicationRouteMixin from 'simple-auth/mixins/application-route-mixin';

export default Ember.Route.extend(ApplicationRouteMixin, {
  model() {
    const tournamentId = this.modelFor('tournament').get('id');
    return this.store.find('match', {tournamentId, status: 'started'});
  },

  setupController(controller, model) {
    this._super(controller, model);

    const isDraft = this.modelFor('tournament').get('isDraft');
    controller.set('isDraft', isDraft);
  },

  actions: {
    goToSettings() {
      this.transitionTo('tournament.settings');
    }
  }

});
