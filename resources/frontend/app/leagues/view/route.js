import Ember from 'ember';

export default Ember.Route.extend({
  model(params) {
    return this.store.find('league', params.id, function (league) {
      return league.get('isNew');
    });
  },

});
