import Ember from 'ember';

export default Ember.Route.extend({
  model() {
    return this.store.createRecord('tournament', {
      'type': 'league',
      'membersType': 'single'
    });
  },

  deactivate() {
    const store = this.store;

    store.filter('tournament', (tournament) => {
      if (tournament.get('isNew')) {
        store.deleteRecord(tournament);
      }
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
