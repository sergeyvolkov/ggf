import Ember from 'ember';

export default Ember.Route.extend({
  actions: {
    createTournament: function() {
      return this.transitionTo('tournaments.new');
    }
  }
});