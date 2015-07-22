import Ember from 'ember';

export default Ember.Route.extend({
  actions: {
    createTournament(tournament) {
      let newTournament = this.store.createRecord('tournament', tournament);

      newTournament.save().then( () => {
        this.transitionTo('tournament.teams', newTournament.id);
      });

    }
  }
});
