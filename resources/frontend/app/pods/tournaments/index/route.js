import Ember from 'ember';

export default Ember.Route.extend({
  model: function() {
    const store = this.store;

    return store.findAll('tournament').then(() => {
      return store.filter('tournament', (tournament) => {
        return !tournament.get('isNew');
      });
    });
  },

  actions: {
    createTournament: function() {
      return this.transitionTo('tournaments.new');
    }
  }
});