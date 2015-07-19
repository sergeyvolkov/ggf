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
      // @todo fix ggf-mdl.radio button
      tournament.type = 'league';
      tournament.membersType = 'single';

      const newTournament = this.store.createRecord('tournament', tournament);
      newTournament.save();
    }
  }
});
