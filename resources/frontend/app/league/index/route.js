import Ember from 'ember';

export default Ember.Route.extend({

  beforeModel: function() {
    return this.transitionTo('league.teams');
  },

  setupController (controller, model, transition) {
   console.log('model', model);
  }

});
