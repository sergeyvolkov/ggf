import Ember from 'ember';

export default Ember.Route.extend({
  model(params) {
    return this.store.filter('league', {id: params.leagueId}, function (league) {
      return !league.get('isNew');
    });
  },

});
