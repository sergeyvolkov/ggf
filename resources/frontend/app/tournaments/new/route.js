import Ember from 'ember';

export default Ember.Route.extend({
  model() {
    return this.store.createRecord('tournament', {
      'type': 'league',
      'membersType': 'single'
    });
  },

  actions: {
    save(tournament) {
      let newTournament = this.store.createRecord('tournament', tournament);

      newTournament.save().then( () => {
        this.transitionTo('tournament.teams', newTournament.id);
      });

    }
  }
});
