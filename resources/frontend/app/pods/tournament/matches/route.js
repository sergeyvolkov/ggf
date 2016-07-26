import Ember from 'ember';
import ApplicationRouteMixin from 'simple-auth/mixins/application-route-mixin';

const { Route, RSVP } = Ember;

export default Route.extend(ApplicationRouteMixin, {
  model() {
    const tournamentId = this.modelFor('tournament').get('id');

    let rsvpHash = {
      matches: this.get('store').query('match', {tournamentId}),
      teams: this.get('store').query('team', {tournamentId}),
    };

    return RSVP.hash(rsvpHash).then((hash) => {
      return hash.matches;
    });
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
