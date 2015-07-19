import Ember from 'ember';

export default Ember.Route.extend({
  setupController(controller) {
    const newTournament = {
      name: '',
      description: '',
      type: '',
      membersType: ''
    };

    controller.set('tournament', newTournament);
  },

  actions: {
    saveTournament(tournament) {
      this.store.createRecord('tournament', tournament);
    }
  }
});
